<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SecuritySmokeTest extends Command
{
    /**
     * Usage example
     *  php artisan security:smoke \
     *      --base=https://localhost \
     *      --email=admin@example.com \
     *      --good=12345678 \
     *      --bad=wrong1 --bad=wrong2 \
     *      --repeat=3
     */
    protected $signature = 'security:smoke
        {--base= : Base host, e.g. https://localhost (default: https://localhost)}
        {--api=/api : API prefix (default: /api)}
        {--email= : Email to test (default: admin@example.com)}
        {--good= : Good password (default: 12345678)}
        {--bad=* : Bad password(s) – repeat this flag as needed}
        {--repeat=1 : How many cycles through the bad‑password list}';

    protected $description = 'Spam bad logins until 429, then prove a good login still succeeds';

    public function handle(): int
    {
        /* ---------- options & defaults ---------- */
        $base   = rtrim($this->option('base') ?: 'https://localhost', '/');
        $api    = '/' . ltrim($this->option('api') ?: '/api', '/');   // normalise
        $login  = preg_replace('#/api/?$#', '', $base) . $api . '/auth/login';

        $email  = $this->option('email') ?: 'admin@example.com';
        $good   = $this->option('good')  ?: '12345678';
        $bad    = $this->option('bad')   ?: ['wrong1', 'wrong2', 'password'];
        $repeat = max(1, (int) $this->option('repeat'));

        $this->info("\n🔐  Security smoke test →  {$login}\n");

        /* ---------- helper closure ---------- */
        $call = function (string $pwd) use ($login, $email) {
            return Http::withoutVerifying()
                ->asJson()
                ->post($login, ['email' => $email, 'password' => $pwd]);
        };

        /* ---------- 1. hammer bad credentials ---------- */
        $limitHit = false;
        $attempt  = 1;

        for ($r = 0; $r < $repeat; $r++) {
            foreach ($bad as $pwd) {
                $resp   = $call($pwd);
                $status = $resp->status();
                $remain = $resp->header('X-RateLimit-Remaining');

                $this->line(sprintf(
                    'Attempt %-2d (%-10s) → %s  (remaining: %s)',
                    $attempt++, $pwd, $status, $remain ?? '-'
                ));

                if ($status === 429) {
                    $this->warn("\n🛡️  Rate‑limit triggered (429)\n");
                    $limitHit = true;
                    break 2;
                }
                usleep(300_000);                     // 0.3 s between attempts
            }
        }

        if (!$limitHit) {
            $this->error("\n❌  Rate‑limit NOT triggered after ".($attempt-1)." attempts\n");
        }

        /* ---------- 2. test a valid login ---------- */
        $goodResp = $call($good);

        if ($goodResp->ok() && $goodResp->json('access_token')) {
            $this->info("✅  Valid login succeeded ({$goodResp->status()})");
        } else {
            $this->error("❌  Valid login failed ({$goodResp->status()})");
        }

        return $limitHit && $goodResp->ok()
            ? Command::SUCCESS
            : Command::FAILURE;
    }
}
