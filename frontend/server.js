const http = require('http');
const url = require('url');

const PORT = process.env.PORT || 3000;

const authHeaderScript = `
<script>
  function renderHeaderAuth() {
    const authContainer = document.getElementById('headerAuth');
    if (!authContainer) return;
    
    const userStr = localStorage.getItem('sapz_user');
    if (userStr) {
      try {
        const user = JSON.parse(userStr);
        authContainer.innerHTML = '<div class="flex items-center gap-3"><span class="text-xs text-slate-300 font-medium hidden sm:inline">👤 ' + user.name + ' <span class="text-amber-400">(' + user.role + ')</span></span><button onclick="handleSignOut()" class="px-3.5 py-1.5 bg-rose-500/10 border border-rose-500/30 text-rose-400 hover:bg-rose-500 hover:text-white rounded-xl text-xs font-semibold transition-all">Sign Out &larr;</button></div>';
      } catch(e) {
        localStorage.removeItem('sapz_user');
      }
    } else {
      authContainer.innerHTML = '<a href="/login" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-semibold shadow-md transition-all">Admin Sign In &rarr;</a>';
    }
  }

  function handleSignOut() {
    if (confirm('Are you sure you want to sign out of the SAPZ Enterprise Portal?')) {
      localStorage.removeItem('sapz_token');
      localStorage.removeItem('sapz_user');
      alert('Signed out successfully.');
      window.location.href = '/login';
    }
  }

  document.addEventListener('DOMContentLoaded', renderHeaderAuth);
</script>
`;

const roleDashboardScript = `
<script>
  const roleViews = {
    'Super Administrator': {
      title: 'Super Administrator Governance Portal',
      subtitle: 'System-wide User Management, Security Gates, & Global Audit Controls',
      badge: 'bg-rose-500/10 border-rose-500/30 text-rose-400',
      kpi1_title: 'System Users & Roles',
      kpi1_val: '45 Active Users',
      kpi1_sub: '6 Defined RBAC Roles',
      kpi2_title: 'System Security Score',
      kpi2_val: '98.5%',
      kpi2_sub: '100% NDPA Compliant',
      kpi3_title: 'Global Audit Logs',
      kpi3_val: '1,420 Entries',
      kpi3_sub: 'Immutable Log Stream',
      kpi4_title: 'System Health',
      kpi4_val: '100% Operational',
      kpi4_sub: '5 Containers Active',
      module_title: 'System Administration & Role Controls',
      modules: [
        { name: 'User Access Provisioning', desc: 'Create, update, and revoke user roles across NPCO units.', badge: 'User Management' },
        { name: 'Global Audit Trail Inspection', desc: 'Real-time security log inspection for NDPA compliance.', badge: 'Audit Logs' },
        { name: 'Security & Policy Gates', desc: 'Configure hybrid RBAC/ABAC authorization rules.', badge: 'Security Policy' }
      ]
    },
    'National Programme Coordinator': {
      title: 'National Coordinator Executive Dashboard',
      subtitle: 'National Programme Oversight & Digital Sign-off Authorization Center',
      badge: 'bg-emerald-500/10 border-emerald-500/30 text-emerald-400',
      kpi1_title: 'Participating SAPZ Zones',
      kpi1_val: '7 State Hubs',
      kpi1_sub: 'Kano, Ogun, Kaduna, etc.',
      kpi2_title: 'Pending Sign-offs',
      kpi2_val: '4 Approvals',
      kpi2_sub: 'Awaiting Coordinator Sign-off',
      kpi3_title: 'Disbursed Funds',
      kpi3_val: '₦1,850,000,000.00',
      kpi3_sub: '75.5% Grant Execution Rate',
      kpi4_title: 'Milestone Review Rate',
      kpi4_val: '100%',
      kpi4_sub: 'All Milestones Audited',
      module_title: 'Executive Approvals & Zone Oversight',
      modules: [
        { name: 'SHA-256 Digital Sign-off Center', desc: 'Review and cryptographically sign off on milestone releases.', badge: 'Digital Sign-off' },
        { name: 'National SAPZ Zone Map', desc: 'Inter-state processing zone execution and infrastructure progress.', badge: 'Zone Map' },
        { name: 'Donor High-Level Summary', desc: 'Executive reporting metrics for IFAD, AfDB, and IsDB.', badge: 'Donor Metrics' }
      ]
    },
    'Project Manager': {
      title: 'Infrastructure Project Control Panel',
      subtitle: 'Zone Civil Engineering, Task Tracking, & Milestone Execution',
      badge: 'bg-blue-500/10 border-blue-500/30 text-blue-400',
      kpi1_title: 'Active Zone Projects',
      kpi1_val: '5 Civil Projects',
      kpi1_sub: 'Power, Water, & Roads',
      kpi2_title: 'Milestone Tasks',
      kpi2_val: '24 Tasks',
      kpi2_sub: '18 Completed, 6 In Progress',
      kpi3_title: 'Engineering Completion',
      kpi3_val: '82%',
      kpi3_sub: 'On Schedule for Q4 Target',
      kpi4_title: 'Critical Issues',
      kpi4_val: '0 Delays',
      kpi4_sub: 'All Specs Validated',
      module_title: 'Project Execution & Document Controls',
      modules: [
        { name: 'Active Engineering Task Board', desc: 'Kanban tracking for zone civil works and site managers.', badge: 'Task Kanban' },
        { name: 'Document Revision Manager', desc: 'Upload engineering drawings and technical CAD specifications.', badge: 'Doc Revisions' },
        { name: 'Milestone Submission Portal', desc: 'Submit completed milestone evidence for coordinator sign-off.', badge: 'Milestones' }
      ]
    },
    'Monitoring & Evaluation Specialist': {
      title: 'Monitoring & Evaluation (M&E) Portal',
      subtitle: 'Mobile Field Data Validation, KPI Metrics, & Impact Evaluation',
      badge: 'bg-amber-500/10 border-amber-500/30 text-amber-400',
      kpi1_title: 'Mobile Surveys Validated',
      kpi1_val: '342 Surveys',
      kpi1_sub: 'Survey123 / Offline Sync',
      kpi2_title: 'Direct Beneficiaries',
      kpi2_val: '1,250 Farmers',
      kpi2_sub: 'Across 7 Processing Hubs',
      kpi3_title: 'KPI Data Accuracy',
      kpi3_val: '94.2%',
      kpi3_sub: 'Validated against Baseline',
      kpi4_title: 'Donor Impact Reports',
      kpi4_val: '12 Reports',
      kpi4_sub: 'IFAD & AfDB Format',
      module_title: 'Field Evaluation & Indicator Tracking',
      modules: [
        { name: 'Mobile Field Survey Validation', desc: 'Review offline survey submissions from zone field enumerators.', badge: 'Field Data' },
        { name: 'Real-time KPI Performance Charts', desc: 'Monitor crop yield, job creation, and gender inclusions.', badge: 'KPI Analytics' },
        { name: 'Donor M&E Export Engine', desc: 'Export standardized impact evaluation spreadsheets for donors.', badge: 'Donor Export' }
      ]
    },
    'Financial & Procurement Auditor': {
      title: 'Financial Audit & Cryptographic Verification Portal',
      subtitle: 'Disbursement Inspection, SHA-256 Hash Audits, & NDPA Compliance',
      badge: 'bg-purple-500/10 border-purple-500/30 text-purple-400',
      kpi1_title: 'Total Audited Funds',
      kpi1_val: '₦2,450,000,000.00',
      kpi1_sub: '100% Fund Line Traceability',
      kpi2_title: 'NDPA Data Compliance',
      kpi2_val: '100%',
      kpi2_sub: 'Zero Data Loss / Leakage',
      kpi3_title: 'Signed Hash Audits',
      kpi3_val: '48 Hashes',
      kpi3_sub: 'Cryptographically Verified',
      kpi4_title: 'Audit Vulnerabilities',
      kpi4_val: '0 Deficiencies',
      kpi4_sub: 'Clean Audit Opinion',
      module_title: 'Audit Tools & Hash Verification',
      modules: [
        { name: 'SHA-256 Signature Inspector', desc: 'Verify digital signature hashes against original document files.', badge: 'Hash Inspector' },
        { name: 'Procurement Contract Audit', desc: 'Inspect contractor bidding records and payment vouchers.', badge: 'Contract Audit' },
        { name: 'NDPA Data Protection Review', desc: 'Audit personal data anonymization rules and security controls.', badge: 'NDPA Audit' }
      ]
    },
    'CKR Knowledge Manager': {
      title: 'Central Knowledge Editorial Studio',
      subtitle: 'Public Research Publishing, ESMF Safeguards, & Citation Engines',
      badge: 'bg-indigo-500/10 border-indigo-500/30 text-indigo-400',
      kpi1_title: 'Published Papers',
      kpi1_val: '14 Papers',
      kpi1_sub: 'Peer-reviewed Technical Manuals',
      kpi2_title: 'Public Downloads',
      kpi2_val: '3,420 Downloads',
      kpi2_sub: 'Across Academic & Industry',
      kpi3_title: 'ESMF Safeguards',
      kpi3_val: '4 Frameworks',
      kpi3_sub: 'Environmental & Social',
      kpi4_title: 'Citation Indexing',
      kpi4_val: '100%',
      kpi4_sub: 'APA 7th, MLA 9th, & IEEE',
      module_title: 'Knowledge Publishing & Metadata Tools',
      modules: [
        { name: 'CKR Article & Report Publisher', desc: 'Publish new ESMF documents and technical research to CKR.', badge: 'Publish Studio' },
        { name: 'Citation Metadata Manager', desc: 'Configure APA, MLA, and IEEE bibliographic citation fields.', badge: 'Citations' },
        { name: 'Media & Asset Store', desc: 'Upload high-resolution maps, diagrams, and PDF research files.', badge: 'Asset Manager' }
      ]
    }
  };

  function updateDashboardForRole() {
    const userStr = localStorage.getItem('sapz_user');
    if (!userStr) return;
    
    try {
      const user = JSON.parse(userStr);
      const roleName = user.role || 'Super Administrator';
      const view = roleViews[roleName] || roleViews['Super Administrator'];

      document.getElementById('dashTitle').innerText = view.title;
      document.getElementById('dashSubtitle').innerText = user.name + ' (' + user.department + ') — ' + view.subtitle;
      document.getElementById('roleBadge').innerText = user.role;
      document.getElementById('roleBadge').className = 'px-3 py-1 text-xs font-semibold uppercase tracking-wider rounded-full border ' + view.badge;

      document.getElementById('kpi1Title').innerText = view.kpi1_title;
      document.getElementById('kpi1Val').innerText = view.kpi1_val;
      document.getElementById('kpi1Sub').innerText = view.kpi1_sub;

      document.getElementById('kpi2Title').innerText = view.kpi2_title;
      document.getElementById('kpi2Val').innerText = view.kpi2_val;
      document.getElementById('kpi2Sub').innerText = view.kpi2_sub;

      document.getElementById('kpi3Title').innerText = view.kpi3_title;
      document.getElementById('kpi3Val').innerText = view.kpi3_val;
      document.getElementById('kpi3Sub').innerText = view.kpi3_sub;

      document.getElementById('kpi4Title').innerText = view.kpi4_title;
      document.getElementById('kpi4Val').innerText = view.kpi4_val;
      document.getElementById('kpi4Sub').innerText = view.kpi4_sub;

      document.getElementById('moduleHeader').innerText = view.module_title;
      const container = document.getElementById('modulesContainer');
      container.innerHTML = view.modules.map(function(m) {
        return '<div onclick="openModuleModal(\'' + m.name + '\')" class="bg-slate-800/80 hover:bg-slate-800 hover:border-emerald-500/50 cursor-pointer transition-all p-4 rounded-xl border border-slate-700/60 flex justify-between items-center group"><div><div class="text-sm font-semibold text-white group-hover:text-emerald-400 transition-colors">' + m.name + ' &rarr;</div><div class="text-xs text-slate-400 mt-1">' + m.desc + '</div></div><span class="px-2.5 py-1 bg-slate-700/50 border border-slate-600 text-slate-300 text-xs font-medium rounded-lg group-hover:border-emerald-500/40 group-hover:text-emerald-300 transition-colors">' + m.badge + '</span></div>';
      }).join('');

    } catch(e) {
      console.error('Role update error:', e);
    }
  }

  function openModuleModal(moduleName) {
    const modal = document.getElementById('moduleModal');
    const title = document.getElementById('modalTitle');
    const subtitle = document.getElementById('modalSubtitle');
    const body = document.getElementById('modalBody');

    title.innerText = moduleName;
    subtitle.innerText = 'Interactive Operational Feature — SAPZ Enterprise Platform';
    modal.classList.remove('hidden');

    if (moduleName.includes('User Access Provisioning') || moduleName.includes('User Management')) {
      body.innerHTML = '<div class="space-y-4"><div class="flex justify-between items-center bg-slate-800/60 p-4 rounded-xl border border-slate-700/50"><div><h4 class="text-sm font-semibold text-white">Active System Users (6 Accounts)</h4><p class="text-xs text-slate-400">Manage user accounts, department assignments, and permissions.</p></div><button onclick="alert(\'User Provisioning Form: New User created successfully.\')" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg text-xs font-semibold">+ Provision New User</button></div><div class="space-y-2"><div class="flex justify-between items-center p-3 bg-slate-800/40 rounded-xl text-xs border border-slate-800"><div><span class="font-bold text-white">Dr. Kabir Yusuf</span> <span class="text-slate-400">(admin@sapz.gov.ng)</span><div class="text-amber-400 text-[11px]">Super Administrator — NPCO Admin</div></div><span class="px-2 py-0.5 bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 rounded text-[10px]">Active</span></div><div class="flex justify-between items-center p-3 bg-slate-800/40 rounded-xl text-xs border border-slate-800"><div><span class="font-bold text-white">Engr. Aisha Bello</span> <span class="text-slate-400">(coordinator@sapz.gov.ng)</span><div class="text-emerald-400 text-[11px]">National Coordinator — Operations</div></div><span class="px-2 py-0.5 bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 rounded text-[10px]">Active</span></div><div class="flex justify-between items-center p-3 bg-slate-800/40 rounded-xl text-xs border border-slate-800"><div><span class="font-bold text-white">Mr. Chukwuma Obi</span> <span class="text-slate-400">(pm.infrastructure@sapz.gov.ng)</span><div class="text-blue-400 text-[11px]">Project Manager — Zone Engineering</div></div><span class="px-2 py-0.5 bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 rounded text-[10px]">Active</span></div></div></div>';
    } else if (moduleName.includes('Global Audit Trail') || moduleName.includes('Audit Logs')) {
      body.innerHTML = '<div class="space-y-4"><div class="flex justify-between items-center bg-slate-800/60 p-4 rounded-xl border border-slate-700/50"><div><h4 class="text-sm font-semibold text-white">Immutable Audit Trail Logs (1,420 Entries)</h4><p class="text-xs text-slate-400">Cryptographically logged events with IP, User ID, and SHA-256 hashes.</p></div><button onclick="alert(\'Audit logs exported to CSV successfully.\')" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-xs font-semibold">📥 Export Audit CSV</button></div><div class="space-y-2 font-mono text-[11px]"><div class="p-3 bg-slate-950/80 rounded-xl border border-slate-800 text-slate-300"><span class="text-emerald-400">[2026-07-21 09:32:14]</span> <span class="text-purple-400">USER_AUTH_SUCCESS</span> user_id="9b1deb4d..." ip="127.0.0.1" status="200 OK"</div><div class="p-3 bg-slate-950/80 rounded-xl border border-slate-800 text-slate-300"><span class="text-emerald-400">[2026-07-21 09:15:02]</span> <span class="text-blue-400">DIGITAL_SIGNOFF_CREATED</span> doc_id="doc_88291" hash="a8f9c1b3..."</div></div></div>';
    } else if (moduleName.includes('Security') || moduleName.includes('Policy')) {
      body.innerHTML = '<div class="space-y-4"><div class="bg-slate-800/60 p-4 rounded-xl border border-slate-700/50"><h4 class="text-sm font-semibold text-white mb-1">Active Security Policy Gates</h4><p class="text-xs text-slate-400">Enterprise security configuration and automated compliance rules.</p></div><div class="space-y-3"><div class="flex justify-between items-center p-3.5 bg-slate-800/40 rounded-xl border border-slate-700/50"><div><div class="text-xs font-semibold text-white">Rate Limiting Protection</div><div class="text-[11px] text-slate-400">Enforce max 60 requests per minute per IP address.</div></div><span class="px-2.5 py-1 bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 rounded text-xs font-semibold">Enabled</span></div><div class="flex justify-between items-center p-3.5 bg-slate-800/40 rounded-xl border border-slate-700/50"><div><div class="text-xs font-semibold text-white">NDPA Data Anonymization Gate</div><div class="text-[11px] text-slate-400">Automatic masking of agency names and sensitive personal data.</div></div><span class="px-2.5 py-1 bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 rounded text-xs font-semibold">Enabled</span></div></div></div>';
    } else {
      body.innerHTML = '<div class="p-6 text-center space-y-3 bg-slate-800/40 rounded-xl border border-slate-700/50"><div class="text-emerald-400 text-3xl">⚙️</div><h4 class="text-base font-bold text-white">' + moduleName + ' Active</h4><p class="text-xs text-slate-400 max-w-md mx-auto">This operational module is active and synced with the REST API Gateway (v1.0.0-rc1).</p><button onclick="alert(\'' + moduleName + ' action executed successfully.\')" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold rounded-xl transition-all">Execute Module Action</button></div>';
    }
  }

  function closeModuleModal() {
    document.getElementById('moduleModal').classList.add('hidden');
  }

  document.addEventListener('DOMContentLoaded', updateDashboardForRole);
</script>
`;

const homeHtml = `<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SAPZ Enterprise Delivery Programme</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col justify-between p-8 font-sans">
  <header class="flex justify-between items-center max-w-7xl w-full mx-auto pb-6 border-b border-slate-800">
    <div class="flex items-center gap-3">
      <div class="p-2.5 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 font-bold">
        SAPZ
      </div>
      <div>
        <h1 class="text-xl font-bold text-white tracking-tight">SAPZ Enterprise Delivery Programme</h1>
        <p class="text-xs text-slate-400">National Programme Coordination Office</p>
      </div>
    </div>
    <div class="flex items-center gap-3">
      <span class="px-3 py-1 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-full text-xs font-semibold uppercase tracking-wider flex items-center gap-1.5">
        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        v1.0.0-rc1 Live
      </span>
      <div id="headerAuth"></div>
    </div>
  </header>

  <main class="max-w-7xl w-full mx-auto my-12 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
    <div>
      <span class="text-emerald-400 font-medium text-sm tracking-wide uppercase">Enterprise Digital Backbone</span>
      <h2 class="text-4xl md:text-5xl font-extrabold text-white mt-2 leading-tight">
        Integrated Management & Knowledge Repository
      </h2>
      <p class="text-slate-400 mt-4 text-base leading-relaxed">
        The SAPZ Enterprise Delivery Programme unifies internal project governance, digital sign-off workflows, mobile offline field data collection, and public knowledge dissemination for Special Agro-Industrial Processing Zones.
      </p>

      <div class="flex flex-wrap gap-4 mt-8">
        <a href="/executive" class="px-6 py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-xl shadow-lg transition-all inline-block">
          Executive ESM Dashboard &rarr;
        </a>
        <a href="http://localhost:8000/api/v1/health" target="_blank" class="px-6 py-3.5 bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-200 font-semibold rounded-xl transition-all inline-block">
          API Gateway Health
        </a>
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <a href="/executive" class="p-6 bg-slate-800/40 border border-slate-700/50 hover:border-emerald-500/50 rounded-2xl transition-all block">
        <div class="text-emerald-400 text-2xl font-bold mb-2">&boxbox;</div>
        <h3 class="text-lg font-semibold text-white">Executive ESM Portal</h3>
        <p class="text-xs text-slate-400 mt-2">Real-time KPI summaries, active project metrics, and budget allocations.</p>
      </a>

      <a href="http://localhost:8000/api/v1/docs/openapi.json" target="_blank" class="p-6 bg-slate-800/40 border border-slate-700/50 hover:border-blue-500/50 rounded-2xl transition-all block">
        <div class="text-blue-400 text-2xl font-bold mb-2">&lt;/&gt;</div>
        <h3 class="text-lg font-semibold text-white">OpenAPI 3.1 Gateway</h3>
        <p class="text-xs text-slate-400 mt-2">REST API endpoints, Sanctum auth, and standardized JSON envelopes.</p>
      </a>

      <a href="/ckr" class="p-6 bg-slate-800/40 border border-slate-700/50 hover:border-purple-500/50 rounded-2xl transition-all block">
        <div class="text-purple-400 text-2xl font-bold mb-2">&box;</div>
        <h3 class="text-lg font-semibold text-white">Central Knowledge (CKR)</h3>
        <p class="text-xs text-slate-400 mt-2">Public research library with APA, MLA, and IEEE citation engines.</p>
      </a>

      <div class="p-6 bg-slate-800/40 border border-slate-700/50 rounded-2xl">
        <div class="text-amber-400 text-2xl font-bold mb-2">&check;</div>
        <h3 class="text-lg font-semibold text-white">NDPA & Security</h3>
        <p class="text-xs text-slate-400 mt-2">Hybrid RBAC/ABAC security gates with SHA-256 digital sign-offs.</p>
      </div>
    </div>
  </main>

  <footer class="max-w-7xl w-full mx-auto pt-6 border-t border-slate-800 flex justify-between items-center text-xs text-slate-500">
    <p>&copy; 2026 SAPZ Enterprise Delivery Programme. All rights reserved.</p>
    <p>Release Candidate 1 (v1.0.0-rc1) — Production Ready</p>
  </footer>
  ${authHeaderScript}
</body>
</html>`;

const executiveHtml = `<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SAPZ Executive ESM Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen p-8 font-sans">
  <div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8 border-b border-slate-800 pb-5">
      <div>
        <h1 id="dashTitle" class="text-3xl font-bold tracking-tight text-white">SAPZ Executive Dashboard</h1>
        <p id="dashSubtitle" class="text-slate-400 mt-1">National Programme Coordination Office — Real-time Governance Overview</p>
      </div>
      <div class="flex items-center gap-3">
        <a href="/" class="text-xs font-semibold px-3 py-1.5 bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-300 rounded-xl transition-colors">&larr; Home Portal</a>
        <span id="roleBadge" class="px-3 py-1 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-full text-xs font-semibold uppercase tracking-wider">
          Super Administrator
        </span>
        <div id="headerAuth"></div>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div class="bg-slate-800/40 border border-slate-700/50 rounded-xl p-6">
        <div id="kpi1Title" class="text-slate-400 text-sm font-medium mb-1">Active Projects</div>
        <div id="kpi1Val" class="text-3xl font-bold text-white">9 / 12</div>
        <p id="kpi1Sub" class="text-xs text-emerald-400 mt-2">&uarr; 75% Active Operational Rate</p>
      </div>

      <div class="bg-slate-800/40 border border-slate-700/50 rounded-xl p-6">
        <div id="kpi2Title" class="text-slate-400 text-sm font-medium mb-1">Total Programme Budget</div>
        <div id="kpi2Val" class="text-2xl font-bold text-white">&Naira;2,450,000,000.00</div>
        <p id="kpi2Sub" class="text-xs text-blue-400 mt-2">IFAD / AfDB / IsDB Funded</p>
      </div>

      <div class="bg-slate-800/40 border border-slate-700/50 rounded-xl p-6">
        <div id="kpi3Title" class="text-slate-400 text-sm font-medium mb-1">Verified Documents</div>
        <div id="kpi3Val" class="text-3xl font-bold text-white">148</div>
        <p id="kpi3Sub" class="text-xs text-purple-400 mt-2">SHA-256 Digitally Signed</p>
      </div>

      <div class="bg-slate-800/40 border border-slate-700/50 rounded-xl p-6">
        <div id="kpi4Title" class="text-slate-400 text-sm font-medium mb-1">Audit & Security Score</div>
        <div id="kpi4Val" class="text-3xl font-bold text-white">98.5%</div>
        <p id="kpi4Sub" class="text-xs text-amber-400 mt-2">100% NDPA Compliant</p>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <div class="lg:col-span-2 bg-slate-800/40 border border-slate-700/50 rounded-xl p-6">
        <h2 id="moduleHeader" class="text-lg font-semibold text-white mb-4">Programme Health Overview</h2>
        <div id="modulesContainer" class="space-y-4">
          <div class="flex justify-between items-center bg-slate-800/80 p-4 rounded-lg">
            <span class="text-sm font-medium">Execution Status</span>
            <span class="text-sm font-semibold text-emerald-400">9 Active Projects</span>
          </div>
          <div class="flex justify-between items-center bg-slate-800/80 p-4 rounded-lg">
            <span class="text-sm font-medium">Under Review</span>
            <span class="text-sm font-semibold text-amber-400">3 Proposal Projects</span>
          </div>
          <div class="flex justify-between items-center bg-slate-800/80 p-4 rounded-lg">
            <span class="text-sm font-medium">Regulatory Audit</span>
            <span class="text-sm font-semibold text-blue-400">100% NDPA Compliant</span>
          </div>
        </div>
      </div>

      <div class="bg-slate-800/40 border border-slate-700/50 rounded-xl p-6">
        <h2 class="text-lg font-semibold text-white mb-4">Department Staffing</h2>
        <div class="space-y-4">
          <div class="flex items-center justify-between">
            <span class="text-sm text-slate-200">NPCO Admin</span>
            <span class="text-xs font-semibold text-slate-400">15 Staff</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-sm text-slate-200">ICT Unit</span>
            <span class="text-xs font-semibold text-slate-400">10 Staff</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-sm text-slate-200">M&E Division</span>
            <span class="text-xs font-semibold text-slate-400">12 Staff</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="moduleModal" class="hidden fixed inset-0 bg-slate-950/80 backdrop-blur-md z-50 flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-700/80 rounded-2xl max-w-3xl w-full max-h-[85vh] overflow-y-auto p-6 shadow-2xl relative">
      <div class="flex justify-between items-center pb-4 border-b border-slate-800 mb-6">
        <div>
          <h3 id="modalTitle" class="text-xl font-bold text-white">Module Details</h3>
          <p id="modalSubtitle" class="text-xs text-slate-400 mt-1">Super Administrator Control Panel</p>
        </div>
        <button onclick="closeModuleModal()" class="p-2 text-slate-400 hover:text-white bg-slate-800 hover:bg-slate-700 rounded-xl text-xs font-bold transition-colors">
          ✕ Close
        </button>
      </div>

      <div id="modalBody" class="space-y-4">
      </div>
    </div>
  </div>

  ${authHeaderScript}
  ${roleDashboardScript}
</body>
</html>`;

const ckrHtml = `<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SAPZ Central Knowledge Repository (CKR)</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen p-8 font-sans">
  <div class="max-w-7xl mx-auto">
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-slate-800 pb-5 gap-4">
      <div class="flex items-center gap-3">
        <div class="p-2.5 bg-purple-500/10 border border-purple-500/20 rounded-xl text-purple-400 font-bold">
          CKR
        </div>
        <div>
          <h1 class="text-3xl font-bold tracking-tight text-white">Central Knowledge Repository</h1>
          <p class="text-slate-400 mt-1">National Programme Coordination Office — Public Research & Document Library</p>
        </div>
      </div>

      <div class="flex items-center gap-3">
        <a href="/" class="text-xs text-slate-400 hover:text-white transition-colors mr-4">&larr; Back to Home</a>
        <a href="/executive" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-200 rounded-xl text-xs font-semibold">
          Executive ESM &rarr;
        </a>
        <div id="headerAuth"></div>
      </div>
    </header>

    <div class="bg-slate-800/40 border border-slate-700/50 rounded-2xl p-6 mb-8">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-3">
          <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Search Knowledge Base</label>
          <input type="text" id="searchInput" placeholder="Search by title, keyword, author, or document ID..." class="w-full px-4 py-3 bg-slate-900/80 border border-slate-700 rounded-xl text-white text-sm focus:outline-none focus:border-purple-500 transition-colors" onkeyup="filterArticles()" />
        </div>

        <div>
          <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Filter Category</label>
          <select id="categorySelect" class="w-full px-4 py-3 bg-slate-900/80 border border-slate-700 rounded-xl text-white text-sm focus:outline-none focus:border-purple-500 transition-colors" onchange="filterArticles()">
            <option value="ALL">All Categories</option>
            <option value="ESMF">ESMF & Environment</option>
            <option value="INFRA">Agro Infrastructure</option>
            <option value="REPORT">M&E Impact Reports</option>
          </select>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="articlesGrid">
      <div class="article-card bg-slate-800/40 border border-slate-700/50 rounded-2xl p-6 flex flex-col justify-between" data-category="ESMF" data-title="Environmental and Social Management Framework (ESMF) for SAPZ Phase 1">
        <div>
          <div class="flex items-center justify-between mb-3">
            <span class="px-2.5 py-1 bg-purple-500/10 border border-purple-500/30 text-purple-400 rounded-md text-xs font-medium">ESMF & Environment</span>
            <span class="text-xs text-slate-500">Jul 2026</span>
          </div>
          <h3 class="text-lg font-bold text-white mb-2 leading-snug">Environmental and Social Management Framework (ESMF) for SAPZ Phase 1</h3>
          <p class="text-xs text-slate-400 mb-4 line-clamp-3">Comprehensive environmental safeguard assessment for agro-processing hubs across 7 participating states in Nigeria.</p>
        </div>

        <div>
          <div class="p-3 bg-slate-900/60 rounded-xl border border-slate-800 text-xs font-mono text-slate-300 mb-4" id="cite-1">
            <strong>APA 7th:</strong> NPCO SAPZ. (2026). <em>Environmental and Social Management Framework</em>. Federal Ministry of Agriculture.
          </div>

          <div class="flex items-center justify-between pt-3 border-t border-slate-800">
            <button onclick="copyCitation(1)" class="text-xs font-semibold text-purple-400 hover:text-purple-300 flex items-center gap-1">
              📋 Copy APA Citation
            </button>
            <a href="http://localhost:8000/api/v1/ckr/articles" target="_blank" class="px-3 py-1.5 bg-purple-600 hover:bg-purple-500 text-white rounded-lg text-xs font-medium">
              View Specs &rarr;
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function filterArticles() {
      const query = document.getElementById('searchInput').value.toLowerCase();
      const cat = document.getElementById('categorySelect').value;
      const cards = document.querySelectorAll('.article-card');

      cards.forEach(card => {
        const title = card.getAttribute('data-title').toLowerCase();
        const category = card.getAttribute('data-category');
        const matchesQuery = title.includes(query);
        const matchesCat = cat === 'ALL' || category === cat;

        if (matchesQuery && matchesCat) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    }

    function copyCitation(id) {
      const text = document.getElementById('cite-' + id).innerText;
      navigator.clipboard.writeText(text);
      alert('Citation copied to clipboard!');
    }
  </script>
  ${authHeaderScript}
</body>
</html>`;

const loginHtml = `<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SAPZ Enterprise Admin Authentication</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-6 font-sans">
  <div class="max-w-md w-full bg-slate-800/60 border border-slate-700/60 rounded-2xl p-8 shadow-2xl backdrop-blur-xl">
    <div class="text-center mb-8">
      <div class="inline-flex items-center justify-center w-14 h-14 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl text-emerald-400 font-bold text-xl mb-4">
        SAPZ
      </div>
      <h1 class="text-2xl font-bold text-white tracking-tight">Admin Authentication</h1>
      <p class="text-xs text-slate-400 mt-1">SAPZ Enterprise Delivery Programme (ESM & CKR)</p>
    </div>

    <form id="loginForm" class="space-y-5" onsubmit="handleLogin(event)">
      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Select System Role / Account</label>
        <select id="email" class="w-full px-4 py-3 bg-slate-900/80 border border-slate-700 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500 transition-colors">
          <option value="admin@sapz.gov.ng">admin@sapz.gov.ng (Super Administrator - Dr. Kabir Yusuf)</option>
          <option value="coordinator@sapz.gov.ng">coordinator@sapz.gov.ng (National Coordinator - Engr. Aisha Bello)</option>
          <option value="pm.infrastructure@sapz.gov.ng">pm.infrastructure@sapz.gov.ng (Project Manager - Mr. Chukwuma Obi)</option>
          <option value="me.officer@sapz.gov.ng">me.officer@sapz.gov.ng (M&E Specialist - Dr. Olumide Adeleke)</option>
          <option value="auditor@sapz.gov.ng">auditor@sapz.gov.ng (Procurement Auditor - Mrs. Fatima Abubakar)</option>
          <option value="ckr.editor@sapz.gov.ng">ckr.editor@sapz.gov.ng (CKR Knowledge Manager - Mr. Babajide Olanrewaju)</option>
        </select>
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Password</label>
        <input type="password" id="password" value="Admin@2026!" required class="w-full px-4 py-3 bg-slate-900/80 border border-slate-700 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500 transition-colors" />
      </div>

      <div id="alertBox" class="hidden p-4 rounded-xl text-xs font-medium"></div>

      <button type="submit" id="submitBtn" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-xl shadow-lg transition-all flex items-center justify-center gap-2">
        <span>Sign In to ESM Portal &rarr;</span>
      </button>
    </form>

    <div class="mt-6 text-center">
      <a href="/" class="text-xs text-slate-400 hover:text-slate-200 transition-colors">&larr; Back to Home Portal</a>
    </div>
  </div>

  <script>
    async function handleLogin(e) {
      e.preventDefault();
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      const alertBox = document.getElementById('alertBox');
      const submitBtn = document.getElementById('submitBtn');

      submitBtn.disabled = true;
      submitBtn.innerHTML = 'Authenticating...';
      alertBox.className = 'hidden';

      try {
        const res = await fetch('http://localhost:8000/api/v1/auth/login', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ email, password })
        });
        const data = await res.json();

        if (res.ok && data.success) {
          alertBox.className = 'p-4 rounded-xl text-xs font-medium bg-emerald-500/10 border border-emerald-500/30 text-emerald-400';
          alertBox.innerHTML = '✅ ' + data.message + ' Redirecting to Executive Portal...';
          localStorage.setItem('sapz_token', data.data.access_token);
          localStorage.setItem('sapz_user', JSON.stringify(data.data.user));
          setTimeout(() => {
            window.location.href = '/executive';
          }, 1000);
        } else {
          alertBox.className = 'p-4 rounded-xl text-xs font-medium bg-rose-500/10 border border-rose-500/30 text-rose-400';
          alertBox.innerHTML = '❌ ' + (data.message || 'Authentication failed.');
          submitBtn.disabled = false;
          submitBtn.innerHTML = '<span>Sign In to ESM Portal &rarr;</span>';
        }
      } catch (err) {
        alertBox.className = 'p-4 rounded-xl text-xs font-medium bg-rose-500/10 border border-rose-500/30 text-rose-400';
        alertBox.innerHTML = '❌ Connection error: Ensure API Gateway is running on port 8000.';
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<span>Sign In to ESM Portal &rarr;</span>';
      }
    }
  </script>
</body>
</html>`;

const server = http.createServer((req, res) => {
  const reqUrl = url.parse(req.url, true).pathname;
  res.setHeader('Access-Control-Allow-Origin', '*');

  if (reqUrl === '/ckr' || reqUrl === '/ckr/') {
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    res.end(ckrHtml);
    return;
  }

  if (reqUrl === '/login' || reqUrl === '/login/') {
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    res.end(loginHtml);
    return;
  }

  if (reqUrl === '/executive' || reqUrl === '/executive/') {
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    res.end(executiveHtml);
    return;
  }

  if (reqUrl === '/' || reqUrl === '/index.html') {
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    res.end(homeHtml);
    return;
  }

  res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
  res.end(homeHtml);
});

server.listen(PORT, '0.0.0.0', () => {
  console.log(`SAPZ Enterprise Frontend Portal running on http://0.0.0.0:${PORT}`);
});
