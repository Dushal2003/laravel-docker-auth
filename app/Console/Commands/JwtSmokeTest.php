<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 *  php artisan jwt:smoke
 *      --base=https://nginx-server
 *      --email=admin@example.com
 *      --good=12345678
 *      --bad=wrong1 --bad=wrong2
 *      --repeat=2
 */
class JwtSmokeTest extends Command
{
    protected $signature = 'jwt:smoke
        {--base=https://localhost : Base URL (use https://nginx-server inside Docker)}
        {--api=/api              : API prefix}
        {--email=admin@example.com : Account email}
        {--good=12345678         : Good password}
        {--bad=*                 : Bad password(s)}
        {--repeat=1              : Cycles through bad list before a good login}';

    protected $description = 'Full JWT flow: login → /me → rate‑limit → refresh → logout → old token rejected.';

    public function handle(): int
    {
        /* ---------- config ---------- */
        $base   = rtrim($this->option('base'), '/');
        $api    = '/' . ltrim($this->option('api'), '/');
        $email  = $this->option('email');
        $good   = $this->option('good');
        $bad    = $this->option('bad') ?: ['wrong1', 'password'];
        $repeat = max(1, (int) $this->option('repeat'));

        $login   = "{$base}{$api}/auth/login";
        $me      = "{$base}{$api}/auth/me";
        $refresh = "{$base}{$api}/auth/refresh";
        $logout  = "{$base}{$api}/auth/logout";

        $this->info("🔐  JWT smoke‑test against {$login}\n");

        /* ---------- helper ---------- */
        $json = fn(string $url, array $data = [], ?string $token = null) =>
            Http::withoutVerifying()
                ->withHeaders($token ? ['Authorization' => "Bearer {$token}"] : [])
                ->asJson()
                ->post($url, $data);

        /* ---------- 1. bad‑cred hammer ---------- */
        $attempt = 1; $rateHit = false;
        for ($r = 0; $r < $repeat; $r++) {
            foreach ($bad as $pwd) {
                $code = $json($login, ['email'=>$email,'password'=>$pwd])->status();
                $this->line(sprintf('Attempt %-2d (%-8s) → %s',
                    $attempt++, $pwd, $code));
                if ($code === Response::HTTP_TOO_MANY_REQUESTS) {
                    $rateHit = true;
                    $this->warn("🛡️  429 rate‑limit hit\n");
                    break 2;
                }
            }
        }
        if (!$rateHit) $this->error('❌  Could not trigger rate‑limit');

        /* ---------- 2. good login ---------- */
        $resp = $json($login, ['email'=>$email,'password'=>$good]);
        $token = $resp->json('access_token');

        if (!$resp->ok() || !$token) {
            $this->error("❌  Good login failed ({$resp->status()})");
            return Command::FAILURE;
        }
        $this->info("✅  Login OK (token captured)");

        /* ---------- 3. /me ---------- */
        $meResp = $json($me, [], $token);
        if ($meResp->ok() && $meResp->json('email') === $email) {
            $this->info("✅  /me OK");
        } else {
            $this->error("❌  /me failed ({$meResp->status()})");
            return Command::FAILURE;
        }

        /* ---------- 4. refresh ---------- */
        $newToken = $json($refresh, [], $token)->json('access_token');
        if ($newToken && $newToken !== $token) {
            $this->info("✅  Refresh OK");
        } else {
            $this->error("❌  Refresh failed");
            return Command::FAILURE;
        }

        /* ---------- 5. logout ---------- */
        $out = $json($logout, [], $newToken);
        if (!$out->ok()) {
            $this->error("❌  Logout failed ({$out->status()})");
            return Command::FAILURE;
        }
        $this->info("✅  Logout OK");

        /* ---------- 6. old token rejected ---------- */
        $code = $json($me, [], $newToken)->status();
        if ($code === Response::HTTP_UNAUTHORIZED) {
            $this->info("✅  Old token now rejected\n");
            $this->info('🎉  ALL TESTS PASSED');
            return Command::SUCCESS;
        }

        $this->error("❌  Old token still accepted ({$code})");
        return Command::FAILURE;
    }
}
