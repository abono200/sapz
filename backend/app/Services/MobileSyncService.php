<?php

namespace App\Services;

use App\Models\FieldInspection;
use App\Models\MobileSyncSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MobileSyncService
{
    public function processBatchSync(string $deviceId, array $inspections): MobileSyncSession
    {
        return DB::transaction(function() use ($deviceId, $inspections) {
            $user = Auth::user();
            $syncedCount = 0;

            foreach ($inspections as $data) {
                FieldInspection::create([
                    'project_id' => $data['project_id'],
                    'inspector_id' => $user->id,
                    'latitude' => $data['latitude'] ?? null,
                    'longitude' => $data['longitude'] ?? null,
                    'inspection_date' => $data['inspection_date'],
                    'notes' => $data['notes'] ?? null,
                    'status' => $data['status'],
                    'client_created_at' => $data['client_created_at'] ?? now(),
                ]);
                $syncedCount++;
            }

            return MobileSyncSession::create([
                'user_id' => $user->id,
                'device_id' => $deviceId,
                'items_synced' => $syncedCount,
                'status' => 'SUCCESS',
            ]);
        });
    }

    public function createInspection(array $data): FieldInspection
    {
        $data['inspector_id'] = Auth::id();
        return FieldInspection::create($data);
    }
}
