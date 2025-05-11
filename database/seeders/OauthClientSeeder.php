<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OauthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}
