<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RestorePassportClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passport:restore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore OAuth password client after tests';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Restoring passport password client...');

        DB::table('oauth_clients')->updateOrInsert(
            ['id' => 1],
            [
                'name' => 'Password Grant Client',
                'secret' => 'Wonrv7pvMTIGbcth5sxDQvKe9sQxbNPBMK1hpOm1',
                'provider' => 'users',
                'redirect' => 'http://localhost:8000',
                'personal_access_client' => false,
                'password_client' => true,
                'revoked' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        return self::SUCCESS;
    }
}
