<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\User;
use App\Repositories\EloquentAuditLogRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuditLogMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_an_audit_log()
    {
        $user = User::factory()->create();

        $repo = new EloquentAuditLogRepository;

        $data = [
            'user_id' => $user->id,
            'method' => 'POST',
            'path' => 'testing/123',
            'request' => ['testing' => '123', 'api_token' => 'xyz'],
            'status_code' => 201,
            'ip_address' => '127.0.0.1',
        ];

        $log = $repo->save($data);

        $this->assertInstanceOf(AuditLog::class, $log);
        $this->assertDatabaseHas('audit_logs', [
            'id' => $log->id,
            'user_id' => $user->id,
            'method' => 'POST',
            'path' => 'testing/123',
            'status_code' => 201,
            'ip_address' => '127.0.0.1',
        ]);

        $this->assertEquals($data['request'], $log->request);
    }
}
