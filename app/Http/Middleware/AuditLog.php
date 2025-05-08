<?php

namespace App\Http\Middleware;

use App\Repositories\Contracts\AuditLogRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuditLog
{
    public function __construct(
        private readonly AuditLogRepositoryInterface $log
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $this->log->save([
            'user_id' => optional($request->user())->id,
            'method' => $request->method(),
            'path' => $request->path(),
            'request' => $request->all(),
            'status_code' => $response->getStatusCode(),
            'ip_address' => $request->ip(),
        ]);

        return $response;
    }
}
