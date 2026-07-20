<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class HealthCheckController extends Controller
{
    use ApiResponse;

    public function __invoke()
    {
        $dbStatus = 'OK';
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            $dbStatus = 'FAILED';
        }

        return $this->successResponse([
            'status' => 'UP',
            'services' => [
                'database' => $dbStatus,
                'application' => 'OK',
            ]
        ], 'System operational health check status');
    }
}
