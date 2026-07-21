'use client';

import React from 'react';
import Link from 'next/link';
import { Building2, BookOpen, ShieldCheck, Activity, Cpu, ArrowRight } from 'lucide-react';

export default function HomePage() {
  return (
    <div className="min-h-screen bg-slate-900 text-slate-100 flex flex-col justify-between p-8">
      {/* Navigation Header */}
      <header className="flex justify-between items-center max-w-7xl w-full mx-auto pb-6 border-b border-slate-800">
        <div className="flex items-center gap-3">
          <div className="p-2.5 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400">
            <Building2 className="w-6 h-6" />
          </div>
          <div>
            <h1 className="text-xl font-bold text-white tracking-tight">SAPZ Enterprise Delivery Programme</h1>
            <p className="text-xs text-slate-400">National Programme Coordination Office</p>
          </div>
        </div>
        <div className="flex items-center gap-3">
          <span className="px-3 py-1 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-full text-xs font-semibold uppercase tracking-wider flex items-center gap-1.5">
            <span className="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            v1.0.0-rc1 Live
          </span>
        </div>
      </header>

      {/* Main Hero Section */}
      <main className="max-w-7xl w-full mx-auto my-12 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <div>
          <span className="text-emerald-400 font-medium text-sm tracking-wide uppercase">Enterprise Digital Backbone</span>
          <h2 className="text-4xl md:text-5xl font-extrabold text-white mt-2 leading-tight">
            Integrated Management & Knowledge Repository
          </h2>
          <p className="text-slate-400 mt-4 text-base leading-relaxed">
            The SAPZ Enterprise Delivery Programme unifies internal project governance, digital sign-off workflows, mobile offline field data collection, and public knowledge dissemination for Special Agro-Industrial Processing Zones.
          </p>

          {/* Direct CTA Buttons */}
          <div className="flex flex-wrap gap-4 mt-8">
            <Link
              href="/executive"
              className="flex items-center gap-2 px-6 py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-xl shadow-lg transition-all"
            >
              Executive ESM Portal
              <ArrowRight className="w-4 h-4" />
            </Link>

            <a
              href="http://localhost:8000/api/v1/health"
              target="_blank"
              rel="noreferrer"
              className="flex items-center gap-2 px-6 py-3.5 bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-200 font-semibold rounded-xl transition-all"
            >
              <Activity className="w-4 h-4 text-blue-400" />
              API Gateway Health
            </a>
          </div>
        </div>

        {/* Feature Cards Grid */}
        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <Link href="/executive" className="p-6 bg-slate-800/40 border border-slate-700/50 hover:border-emerald-500/50 rounded-2xl transition-all group">
            <div className="p-3 bg-emerald-500/10 text-emerald-400 rounded-xl w-fit mb-4 group-hover:scale-110 transition-transform">
              <Building2 className="w-6 h-6" />
            </div>
            <h3 className="text-lg font-semibold text-white">Executive ESM Portal</h3>
            <p className="text-xs text-slate-400 mt-2">Real-time KPI summaries, active project metrics, and budget allocations.</p>
          </Link>

          <a href="http://localhost:8000/api/v1/docs/openapi.json" target="_blank" rel="noreferrer" className="p-6 bg-slate-800/40 border border-slate-700/50 hover:border-blue-500/50 rounded-2xl transition-all group">
            <div className="p-3 bg-blue-500/10 text-blue-400 rounded-xl w-fit mb-4 group-hover:scale-110 transition-transform">
              <Cpu className="w-6 h-6" />
            </div>
            <h3 className="text-lg font-semibold text-white">OpenAPI 3.1 Gateway</h3>
            <p className="text-xs text-slate-400 mt-2">REST API endpoints, Sanctum auth, and standardized JSON envelopes.</p>
          </a>

          <div className="p-6 bg-slate-800/40 border border-slate-700/50 rounded-2xl">
            <div className="p-3 bg-purple-500/10 text-purple-400 rounded-xl w-fit mb-4">
              <BookOpen className="w-6 h-6" />
            </div>
            <h3 className="text-lg font-semibold text-white">Central Knowledge (CKR)</h3>
            <p className="text-xs text-slate-400 mt-2">Public research library with APA, MLA, and IEEE citation engines.</p>
          </div>

          <div className="p-6 bg-slate-800/40 border border-slate-700/50 rounded-2xl">
            <div className="p-3 bg-amber-500/10 text-amber-400 rounded-xl w-fit mb-4">
              <ShieldCheck className="w-6 h-6" />
            </div>
            <h3 className="text-lg font-semibold text-white">NDPA & RBAC Security</h3>
            <p className="text-xs text-slate-400 mt-2">Hybrid RBAC/ABAC security gates with SHA-256 digital sign-offs.</p>
          </div>
        </div>
      </main>

      {/* Footer */}
      <footer className="max-w-7xl w-full mx-auto pt-6 border-t border-slate-800 flex justify-between items-center text-xs text-slate-500">
        <p>© 2026 SAPZ Enterprise Delivery Programme. All rights reserved.</p>
        <p>Release Candidate 1 (v1.0.0-rc1) — Production Ready</p>
      </footer>
    </div>
  );
}
