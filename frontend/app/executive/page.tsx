'use client';

import React, { useEffect, useState } from 'react';
import { Building2, FolderKanban, FileText, ShieldCheck, TrendingUp, Users } from 'lucide-react';

interface ExecutiveKpis {
  total_projects: number;
  active_projects: number;
  formatted_budget: string;
  total_documents: number;
  total_users: number;
  total_departments: number;
  compliance_score: number;
}

export default function ExecutiveDashboardPage() {
  const [kpis, setKpis] = useState<ExecutiveKpis>({
    total_projects: 12,
    active_projects: 9,
    formatted_budget: '₦2,450,000,000.00',
    total_documents: 148,
    total_users: 45,
    total_departments: 4,
    compliance_score: 98.5,
  });

  return (
    <div className="min-h-screen bg-slate-900 text-slate-100 p-8">
      {/* Top Header */}
      <div className="flex justify-between items-center mb-8 border-b border-slate-800 pb-5">
        <div>
          <h1 className="text-3xl font-bold tracking-tight text-white">SAPZ Executive Dashboard</h1>
          <p className="text-slate-400 mt-1">National Programme Coordination Office — Real-time Governance Overview</p>
        </div>
        <div className="flex items-center gap-3">
          <span className="px-3 py-1 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-full text-xs font-semibold uppercase tracking-wider">
            System Operational
          </span>
        </div>
      </div>

      {/* KPI Cards Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div className="bg-slate-800/60 border border-slate-700/50 rounded-xl p-6 backdrop-blur">
          <div className="flex items-center justify-between text-slate-400 mb-2">
            <span className="text-xs uppercase font-medium">Programme Budget</span>
            <TrendingUp className="w-5 h-5 text-emerald-400" />
          </div>
          <div className="text-2xl font-bold text-white">{kpis.formatted_budget}</div>
          <p className="text-xs text-emerald-400 mt-2">Active Capital Allocation</p>
        </div>

        <div className="bg-slate-800/60 border border-slate-700/50 rounded-xl p-6 backdrop-blur">
          <div className="flex items-center justify-between text-slate-400 mb-2">
            <span className="text-xs uppercase font-medium">Active Projects</span>
            <FolderKanban className="w-5 h-5 text-blue-400" />
          </div>
          <div className="text-2xl font-bold text-white">{kpis.active_projects} / {kpis.total_projects}</div>
          <p className="text-xs text-blue-400 mt-2">Projects in Execution Phase</p>
        </div>

        <div className="bg-slate-800/60 border border-slate-700/50 rounded-xl p-6 backdrop-blur">
          <div className="flex items-center justify-between text-slate-400 mb-2">
            <span className="text-xs uppercase font-medium">Document Volume</span>
            <FileText className="w-5 h-5 text-purple-400" />
          </div>
          <div className="text-2xl font-bold text-white">{kpis.total_documents}</div>
          <p className="text-xs text-purple-400 mt-2">Registered ESM/CKR Files</p>
        </div>

        <div className="bg-slate-800/60 border border-slate-700/50 rounded-xl p-6 backdrop-blur">
          <div className="flex items-center justify-between text-slate-400 mb-2">
            <span className="text-xs uppercase font-medium">NDPR Audit Score</span>
            <ShieldCheck className="w-5 h-5 text-amber-400" />
          </div>
          <div className="text-2xl font-bold text-white">{kpis.compliance_score}%</div>
          <p className="text-xs text-amber-400 mt-2">Regulatory Security Compliance</p>
        </div>
      </div>

      {/* Main Grid Content */}
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div className="lg:col-span-2 bg-slate-800/40 border border-slate-700/50 rounded-xl p-6">
          <h2 className="text-lg font-semibold text-white mb-4">Programme Health Overview</h2>
          <div className="space-y-4">
            <div className="flex justify-between items-center bg-slate-800/80 p-4 rounded-lg">
              <span className="text-sm font-medium">Execution Status</span>
              <span className="text-sm font-semibold text-emerald-400">9 Active Projects</span>
            </div>
            <div className="flex justify-between items-center bg-slate-800/80 p-4 rounded-lg">
              <span className="text-sm font-medium">Under Review</span>
              <span className="text-sm font-semibold text-amber-400">3 Proposal Projects</span>
            </div>
            <div className="flex justify-between items-center bg-slate-800/80 p-4 rounded-lg">
              <span className="text-sm font-medium">Regulatory Audit</span>
              <span className="text-sm font-semibold text-blue-400">100% NDPA Compliant</span>
            </div>
          </div>
        </div>

        <div className="bg-slate-800/40 border border-slate-700/50 rounded-xl p-6">
          <h2 className="text-lg font-semibold text-white mb-4">Department Metrics</h2>
          <div className="space-y-4">
            <div className="flex items-center justify-between">
              <div className="flex items-center gap-3">
                <Building2 className="w-4 h-4 text-slate-400" />
                <span className="text-sm text-slate-200">NPCO Admin</span>
              </div>
              <span className="text-xs font-semibold text-slate-400">15 Staff</span>
            </div>
            <div className="flex items-center justify-between">
              <div className="flex items-center gap-3">
                <Building2 className="w-4 h-4 text-slate-400" />
                <span className="text-sm text-slate-200">ICT Unit</span>
              </div>
              <span className="text-xs font-semibold text-slate-400">10 Staff</span>
            </div>
            <div className="flex items-center justify-between">
              <div className="flex items-center gap-3">
                <Building2 className="w-4 h-4 text-slate-400" />
                <span className="text-sm text-slate-200">M&E Division</span>
              </div>
              <span className="text-xs font-semibold text-slate-400">12 Staff</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
