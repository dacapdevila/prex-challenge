<?php

namespace App\Repositories;

use App\Models\AuditLog;
use App\Repositories\Contracts\AuditLogRepositoryInterface;

class EloquentAuditLogRepository implements AuditLogRepositoryInterface
{
    public function save(array $data): AuditLog
    {
        return AuditLog::create($data);
    }
}
