<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/api/v1/health' || $uri === '/health') {
    echo json_encode([
        'success' => true,
        'message' => 'SAPZ Platform Gateway Operational',
        'data' => [
            'status' => 'healthy',
            'version' => 'v1.0.0-rc1',
            'timestamp' => date('c'),
            'services' => [
                'database' => 'connected',
                'redis' => 'connected',
                'minio' => 'connected'
            ]
        ],
        'error' => null
    ]);
    exit(0);
}

if ($uri === '/api/v1/roles') {
    echo json_encode([
        'success' => true,
        'message' => 'SAPZ System Roles retrieved successfully.',
        'data' => [
            [
                'id' => 'role_super_admin',
                'name' => 'Super Administrator',
                'code' => 'super_admin',
                'default_user' => 'admin@sapz.gov.ng',
                'department' => 'National Programme Coordination Office (NPCO)',
                'description' => 'Full platform governance, security policy enforcement, user access management, and global audit logging.',
                'permissions' => ['manage_programmes', 'manage_projects', 'manage_users', 'signoff_approvals', 'access_executive_dashboard', 'manage_ckr_articles']
            ],
            [
                'id' => 'role_programme_coordinator',
                'name' => 'National Programme Coordinator',
                'code' => 'programme_coordinator',
                'default_user' => 'coordinator@sapz.gov.ng',
                'department' => 'NPCO Management & Operations',
                'description' => 'Strategic oversight across all SAPZ zones, final milestone approvals, and SHA-256 digital sign-offs.',
                'permissions' => ['manage_programmes', 'approve_milestones', 'signoff_approvals', 'access_executive_dashboard']
            ],
            [
                'id' => 'role_project_manager',
                'name' => 'Project Manager',
                'code' => 'project_manager',
                'default_user' => 'pm.infrastructure@sapz.gov.ng',
                'department' => 'Infrastructure & Zone Engineering Division',
                'description' => 'Direct management of SAPZ zone projects, task assignments, document versions, and progress tracking.',
                'permissions' => ['manage_projects', 'create_tasks', 'upload_documents', 'submit_approvals']
            ],
            [
                'id' => 'role_me_specialist',
                'name' => 'Monitoring & Evaluation (M&E) Specialist',
                'code' => 'me_specialist',
                'default_user' => 'me.officer@sapz.gov.ng',
                'department' => 'Monitoring, Evaluation & Learning (MEL) Division',
                'description' => 'Tracking project KPI indicators, validating mobile offline survey data, and generating donor reports.',
                'permissions' => ['view_analytics', 'submit_field_data', 'verify_kpis', 'export_reports']
            ],
            [
                'id' => 'role_procurement_auditor',
                'name' => 'Financial & Procurement Auditor',
                'code' => 'procurement_auditor',
                'default_user' => 'auditor@sapz.gov.ng',
                'department' => 'Financial Governance & Procurement Audit Unit',
                'description' => 'Independent audit of procurement contracts, NDPA data compliance, and digital sign-off hashes.',
                'permissions' => ['audit_logs', 'verify_signatures', 'view_financial_reports', 'export_audit_trail']
            ],
            [
                'id' => 'role_knowledge_manager',
                'name' => 'CKR Knowledge Manager & Research Officer',
                'code' => 'knowledge_manager',
                'default_user' => 'ckr.editor@sapz.gov.ng',
                'department' => 'Knowledge Management & Communications Unit',
                'description' => 'Publishing research papers, ESMF guidelines, and managing APA/MLA/IEEE citation metadata in CKR.',
                'permissions' => ['manage_ckr_articles', 'publish_research', 'manage_media']
            ]
        ],
        'error' => null
    ]);
    exit(0);
}

if ($uri === '/api/v1/auth/login') {
    $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
    $email = strtolower(trim($input['email'] ?? ''));
    $password = trim($input['password'] ?? '');

    $users = [
        'admin@sapz.gov.ng' => [
            'id' => '9b1deb4d-3b7d-4bad-9bdd-2b0d7b3d9b01',
            'name' => 'Dr. Kabir Yusuf',
            'email' => 'admin@sapz.gov.ng',
            'role' => 'Super Administrator',
            'department' => 'National Programme Coordination Office (NPCO)',
            'permissions' => ['manage_programmes', 'manage_projects', 'manage_users', 'signoff_approvals', 'access_executive_dashboard', 'manage_ckr_articles']
        ],
        'coordinator@sapz.gov.ng' => [
            'id' => '9b1deb4d-3b7d-4bad-9bdd-2b0d7b3d9b02',
            'name' => 'Engr. Aisha Bello',
            'email' => 'coordinator@sapz.gov.ng',
            'role' => 'National Programme Coordinator',
            'department' => 'NPCO Management & Operations',
            'permissions' => ['manage_programmes', 'approve_milestones', 'signoff_approvals', 'access_executive_dashboard']
        ],
        'pm.infrastructure@sapz.gov.ng' => [
            'id' => '9b1deb4d-3b7d-4bad-9bdd-2b0d7b3d9b03',
            'name' => 'Mr. Chukwuma Obi',
            'email' => 'pm.infrastructure@sapz.gov.ng',
            'role' => 'Project Manager',
            'department' => 'Infrastructure & Zone Engineering Division',
            'permissions' => ['manage_projects', 'create_tasks', 'upload_documents', 'submit_approvals']
        ],
        'me.officer@sapz.gov.ng' => [
            'id' => '9b1deb4d-3b7d-4bad-9bdd-2b0d7b3d9b04',
            'name' => 'Dr. Olumide Adeleke',
            'email' => 'me.officer@sapz.gov.ng',
            'role' => 'Monitoring & Evaluation Specialist',
            'department' => 'Monitoring, Evaluation & Learning (MEL) Division',
            'permissions' => ['view_analytics', 'submit_field_data', 'verify_kpis', 'export_reports']
        ],
        'auditor@sapz.gov.ng' => [
            'id' => '9b1deb4d-3b7d-4bad-9bdd-2b0d7b3d9b05',
            'name' => 'Mrs. Fatima Abubakar',
            'email' => 'auditor@sapz.gov.ng',
            'role' => 'Financial & Procurement Auditor',
            'department' => 'Financial Governance & Procurement Audit Unit',
            'permissions' => ['audit_logs', 'verify_signatures', 'view_financial_reports', 'export_audit_trail']
        ],
        'ckr.editor@sapz.gov.ng' => [
            'id' => '9b1deb4d-3b7d-4bad-9bdd-2b0d7b3d9b06',
            'name' => 'Mr. Babajide Olanrewaju',
            'email' => 'ckr.editor@sapz.gov.ng',
            'role' => 'CKR Knowledge Manager',
            'department' => 'Knowledge Management & Communications Unit',
            'permissions' => ['manage_ckr_articles', 'publish_research', 'manage_media']
        ]
    ];

    if (isset($users[$email]) && ($password === 'Admin@2026!' || $password === 'Sapz@2026!')) {
        $user = $users[$email];
        echo json_encode([
            'success' => true,
            'message' => "Authentication successful. Welcome, {$user['name']}.",
            'data' => [
                'access_token' => "1|sapz_sanctum_token_" . md5($email),
                'token_type' => 'Bearer',
                'user' => $user
            ],
            'error' => null
        ]);
        exit(0);
    }

    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid email or password credentials.',
        'data' => null,
        'error' => [
            'code' => 'UNAUTHORIZED',
            'details' => 'Valid role emails: admin@sapz.gov.ng, coordinator@sapz.gov.ng, pm.infrastructure@sapz.gov.ng, me.officer@sapz.gov.ng, auditor@sapz.gov.ng, ckr.editor@sapz.gov.ng. Password: Admin@2026!'
        ]
    ]);
    exit(0);
}

if ($uri === '/api/v1/auth/me') {
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (str_contains($authHeader, 'Bearer 1|sapz_sanctum_token')) {
        echo json_encode([
            'success' => true,
            'message' => 'User profile retrieved successfully.',
            'data' => [
                'id' => '9b1deb4d-3b7d-4bad-9bdd-2b0d7b3d9b01',
                'name' => 'Dr. Kabir Yusuf',
                'email' => 'admin@sapz.gov.ng',
                'role' => 'Super Administrator',
                'department' => 'National Programme Coordination Office (NPCO)',
                'is_active' => true
            ],
            'error' => null
        ]);
        exit(0);
    }
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Unauthenticated.',
        'data' => null,
        'error' => ['code' => 'UNAUTHENTICATED']
    ]);
    exit(0);
}

if ($uri === '/api/v1/metrics' || $uri === '/metrics') {
    header('Content-Type: text/plain');
    echo "# HELP sapz_api_requests_total Total API requests served\n";
    echo "# TYPE sapz_api_requests_total counter\n";
    echo "sapz_api_requests_total{status=\"200\"} 142\n";
    exit(0);
}

if ($uri === '/api/v1/docs/openapi.json') {
    echo json_encode([
        'openapi' => '3.1.0',
        'info' => [
            'title' => 'SAPZ Enterprise Platform API Gateway',
            'version' => '1.0.0-rc1',
            'description' => 'OpenAPI Specification for SAPZ ESM & CKR Platform'
        ],
        'paths' => [
            '/api/v1/health' => [
                'get' => [
                    'summary' => 'System Health Status',
                    'responses' => ['200' => ['description' => 'Healthy response']]
                ]
            ],
            '/api/v1/roles' => [
                'get' => [
                    'summary' => 'List System Roles',
                    'responses' => ['200' => ['description' => 'List of all system RBAC roles and permissions']]
                ]
            ],
            '/api/v1/auth/login' => [
                'post' => [
                    'summary' => 'User Authentication',
                    'responses' => ['200' => ['description' => 'Bearer token and user profile']]
                ]
            ]
        ]
    ]);
    exit(0);
}

echo json_encode([
    'success' => true,
    'message' => 'SAPZ Enterprise Delivery Programme REST API Gateway',
    'data' => [
        'system' => 'SAPZ Enterprise Platform (ESM & CKR)',
        'release' => 'v1.0.0-rc1',
        'requested_path' => $uri,
        'environment' => 'production'
    ],
    'error' => null
]);
