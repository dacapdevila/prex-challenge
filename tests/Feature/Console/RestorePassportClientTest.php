<?php

namespace Tests\Feature\Console;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RestorePassportClientTest extends TestCase
{
    use RefreshDatabase;

    public function test_passport_restore_command_creates_or_updates_client(): void
    {
        DB::table('oauth_clients')->where('id', 1)->delete();

        $this->artisan('passport:restore')
            ->expectsOutput('Restoring passport password client...')
            ->assertExitCode(0);

        $this->assertDatabaseHas('oauth_clients', [
            'id' => 1,
            'name' => 'Password Grant Client',
            'secret' => 'Wonrv7pvMTIGbcth5sxDQvKe9sQxbNPBMK1hpOm1',
            'password_client' => true,
            'revoked' => false,
        ]);
    }
}
