<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class TestApiLogin extends Command
{
    protected $signature = 'api:test-login {email} {password}';
    protected $description = 'Test API login and verify ca-bundle.pem SSL configuration';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $caPath = config('services.ca_path');
        $baseUrl = config('services.api_url');
        $insecure = env('INSECURE_SSL', false);

        if (empty($baseUrl)) {
            $this->error("Missing API base URL. Check INTERNAL_API_BASE in .env or services.php");
            return Command::FAILURE;
        }

        if (!$insecure && !file_exists($caPath)) {
            $this->error("CA bundle not found at: $caPath");
            return Command::FAILURE;
        }

        $apiEndpoint = rtrim($baseUrl, '/') . '/auth/login';

        $this->info("Using CA bundle: $caPath");
        $this->info("Attempting login via: $apiEndpoint");
        $this->info("SSL Verify: " . ($insecure ? 'DISABLED' : 'ENABLED'));

        try {
            $response = Http::withOptions([
                'verify' => $insecure ? false : $caPath,
            ])->post($apiEndpoint, [
                'email' => $email,
                'password' => $password,
            ]);

            if (!$response->successful()) {
                $this->error("Login failed. Status: {$response->status()}");
                $this->line("Response Body: " . $response->body());
                Log::warning('Test login failed', ['response' => $response->body()]);
                return Command::FAILURE;
            }

            $token = $response['access_token'] ?? 'N/A';
            $user = $response['user'] ?? [];

            $this->info("Login successful!");
            $this->line("Token: $token");
            $this->line("User: " . json_encode($user));

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Request failed: " . $e->getMessage());
            Log::error('API login test exception', ['error' => $e->getMessage()]);
            return Command::FAILURE;
        }
    }
}