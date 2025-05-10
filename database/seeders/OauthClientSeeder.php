<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;

class OauthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientRepository = new ClientRepository;

        $client = Client::where('name', 'Password Grant Client')->first();

        if (! $client) {
            $client = $clientRepository->createPasswordGrantClient(
                null,
                'Password Grant Client',
                config('app.url'),
                'users'
            );

            $this->command->info('✅ Password Grant Client created.');

            if (app()->environment('local', 'development', 'production')) {
                $this->addToEnvFile('PASSPORT_PASSWORD_CLIENT_ID', $client->id);
                $this->addToEnvFile('PASSPORT_PASSWORD_CLIENT_SECRET', $client->secret);
            }

        } else {
            $this->command->info('ℹ️ Password Grant Client already exists.');
        }
    }

    private function addToEnvFile(string $key, string $value): void
    {
        $envPath = base_path('.env');
        $envContent = File::get($envPath);

        if (! Str::contains($envContent, $key)) {
            File::append($envPath, "\n{$key}={$value}");
            $this->command->info("🔑 Added {$key} to .env");
        } else {
            $this->command->info("⚠️ {$key} already exists in .env, skipped.");
        }
    }
}
