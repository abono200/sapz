const http = require('http');
const url = require('url');

const PORT = process.env.PORT || 3000;

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
        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Administrator Email</label>
        <input type="email" id="email" value="admin@sapz.gov.ng" required class="w-full px-4 py-3 bg-slate-900/80 border border-slate-700 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500 transition-colors" />
      </div>

      <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Password</label>
        <input type="password" id="password" value="Admin@2026!" required class="w-full px-4 py-3 bg-slate-900/80 border border-slate-700 rounded-xl text-white text-sm focus:outline-none focus:border-emerald-500 transition-colors" />
      </div>

      <div id="alertBox" class="hidden p-4 rounded-xl text-xs font-medium"></div>

      <button type="submit" id="submitBtn" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-xl shadow-lg transition-all flex items-center justify-center gap-2">
        <span>Sign In to ESM Portal &rarr;</span>
      </button>

      <div class="p-4 bg-slate-900/40 border border-slate-700/40 rounded-xl text-xs text-slate-400 space-y-1.5">
        <p class="font-semibold text-slate-200">🔑 Default Admin Credentials:</p>
        <p><span class="text-slate-500">Email:</span> <code class="text-emerald-400 font-mono">admin@sapz.gov.ng</code></p>
        <p><span class="text-slate-500">Password:</span> <code class="text-emerald-400 font-mono">Admin@2026!</code></p>
        <p><span class="text-slate-500">Role:</span> <span class="text-amber-400">Super Administrator (Dr. Kabir Yusuf)</span></p>
      </div>
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
          }, 1200);
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
    <div>
      <span class="px-3 py-1 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-full text-xs font-semibold uppercase tracking-wider flex items-center gap-1.5">
        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        v1.0.0-rc1 Production Live
      </span>
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
        <a href="/executive" className="px-6 py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-xl shadow-lg transition-all inline-block">
          Executive ESM Dashboard &rarr;
        </a>
        <a href="http://localhost:8000/api/v1/health" target="_blank" className="px-6 py-3.5 bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-200 font-semibold rounded-xl transition-all inline-block">
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
        <h1 class="text-3xl font-bold tracking-tight text-white">SAPZ Executive Dashboard</h1>
        <p class="text-slate-400 mt-1">National Programme Coordination Office — Real-time Governance Overview</p>
      </div>
      <div class="flex items-center gap-3">
        <a href="/" class="text-xs text-slate-400 hover:text-white transition-colors mr-4">&larr; Home</a>
        <span class="px-3 py-1 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-full text-xs font-semibold uppercase tracking-wider">
          System Operational
        </span>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div class="bg-slate-800/40 border border-slate-700/50 rounded-xl p-6">
        <div class="text-slate-400 text-sm font-medium mb-1">Active Projects</div>
        <div class="text-3xl font-bold text-white">9 / 12</div>
        <p class="text-xs text-emerald-400 mt-2">&uarr; 75% Active Operational Rate</p>
      </div>

      <div class="bg-slate-800/40 border border-slate-700/50 rounded-xl p-6">
        <div class="text-slate-400 text-sm font-medium mb-1">Total Programme Budget</div>
        <div class="text-2xl font-bold text-white">&Naira;2,450,000,000.00</div>
        <p class="text-xs text-blue-400 mt-2">IFAD / AfDB / IsDB Funded</p>
      </div>

      <div class="bg-slate-800/40 border border-slate-700/50 rounded-xl p-6">
        <div class="text-slate-400 text-sm font-medium mb-1">Verified Documents</div>
        <div class="text-3xl font-bold text-white">148</div>
        <p class="text-xs text-purple-400 mt-2">SHA-256 Digitally Signed</p>
      </div>

      <div class="bg-slate-800/40 border border-slate-700/50 rounded-xl p-6">
        <div class="text-slate-400 text-sm font-medium mb-1">Audit & Security Score</div>
        <div class="text-3xl font-bold text-white">98.5%</div>
        <p class="text-xs text-amber-400 mt-2">100% NDPA Compliant</p>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <div class="lg:col-span-2 bg-slate-800/40 border border-slate-700/50 rounded-xl p-6">
        <h2 class="text-lg font-semibold text-white mb-4">Programme Health Overview</h2>
        <div class="space-y-4">
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
</body>
</html>`;

const server = http.createServer((req, res) => {
  const reqUrl = url.parse(req.url, true).pathname;
  res.setHeader('Access-Control-Allow-Origin', '*');

    if (reqUrl === '/login' || reqUrl === '/login/') {
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    res.end(loginHtml);
    return;
  }
  
  if (reqUrl === '/' || reqUrl === '/index.html') {
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    res.end(homeHtml);
    return;
  }

  if (reqUrl === '/executive' || reqUrl === '/executive/') {
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    res.end(executiveHtml);
    return;
  }

  if (reqUrl === '/health' || reqUrl === '/api/health') {
    res.writeHead(200, { 'Content-Type': 'application/json' });
    res.end(JSON.stringify({ status: 'healthy', portal: 'frontend', version: 'v1.0.0-rc1' }));
    return;
  }

  // Fallback to Home Portal instead of 404
  res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
  res.end(homeHtml);
});

server.listen(PORT, '0.0.0.0', () => {
  console.log(`SAPZ Enterprise Frontend Portal running on http://0.0.0.0:${PORT}`);
});
