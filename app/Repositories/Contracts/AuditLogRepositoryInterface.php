<?php

namespace App\Repositories\Contracts;

use App\Models\AuditLog;

interface AuditLogRepositoryInterface
{
    public function save(array $data): AuditLog;
}
