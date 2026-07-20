<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class MetricsController extends Controller
{
    public function __invoke(): Response
    {
        $userCount = DB::table('users')->count();
        $projectCount = DB::table('projects')->count();
        $documentCount = DB::table('documents')->count();

        $metrics = "# HELP sapz_users_total Total registered SAPZ platform users.\n";
        $metrics .= "# TYPE sapz_users_total counter\n";
        $metrics .= "sapz_users_total {$userCount}\n\n";

        $metrics .= "# HELP sapz_projects_total Total SAPZ programme projects.\n";
        $metrics .= "# TYPE sapz_projects_total gauge\n";
        $metrics .= "sapz_projects_total {$projectCount}\n\n";

        $metrics .= "# HELP sapz_documents_total Total registered ESM/CKR documents.\n";
        $metrics .= "# TYPE sapz_documents_total gauge\n";
        $metrics .= "sapz_documents_total {$documentCount}\n";

        return response($metrics, 200, ['Content-Type' => 'text/plain; version=0.0.4']);
    }
}
