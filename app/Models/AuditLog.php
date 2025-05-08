<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'method',
        'path',
        'request',
        'status_code',
        'ip_address',
    ];

    protected $casts = [
        'request' => 'array',
    ];
}
