# ADR-018: Analytics, Reporting & Chart Visualization Architecture
**Status:** APPROVED  
**Date:** 2026-07-20  
**Context:**  
The SAPZ ESM & CKR platform requires executive KPI aggregations, custom report generation (PDF, CSV, XLSX), and chart metric APIs for portal dashboards.

**Decision:**  
1. **Analytics Reports Schema:** Create `analytics_reports` storing report parameters, output file paths, export formats, and generation status.
2. **Chart Data Connectors:** Implement `AnalyticsReportService::getBudgetChartData` for time-series chart rendering.
3. **Analytics API Suite:** Expose `/api/v1/analytics/kpi-summary`, `/api/v1/analytics/charts/project-budget`, and `/api/v1/analytics/reports/generate`.

**Consequences:**  
- Solves executive report export generation and delivers real-time KPI data visualization.
