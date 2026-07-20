# ADR-006: Executive Management & Dashboard Analytics Architecture
**Status:** APPROVED  
**Date:** 2026-07-20  
**Context:**  
The SAPZ ESM & CKR platform requires executive dashboard capabilities for National Programme Coordinators, Ministry Leadership, and DFI oversight representatives (IFAD, AfDB, IsDB).

**Decision:**  
1. **Aggregated Analytics Engine:** Implement `ExecutiveDashboardService` summarizing project budgets, document counts, active user volumes, and compliance scores in SQL queries.
2. **Executive REST Endpoints:** Expose `/api/v1/executive/summary`, `/api/v1/executive/programmes`, `/api/v1/executive/departments`, and `/api/v1/executive/activity`.
3. **Responsive Next.js Portal UI:** Build modern, accessible Executive Dashboard UI (`app/executive/page.tsx`) with KPI cards, project health breakdowns, and department staff metrics.

**Consequences:**  
- Delivers real-time executive visibility into programme budget utilization and regulatory compliance.
- Enables rapid executive decision-making.
