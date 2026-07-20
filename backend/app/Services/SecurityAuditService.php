<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SecurityAuditService
{
    public function log(string $event, string $auditableType, string $auditableId, array $oldValues = [], array $newValues = []): void
    {
        DB::table('audit_logs')->insert([
            'id' => (string) Str::uuid(),
            'user_id' => Auth::id(),
            'event' => $event,
            'auditable_type' => $auditableType,
            'auditable_id' => $auditableId,
            'old_values' => json_encode($oldValues),
            'new_values' => json_encode($newValues),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }
}
