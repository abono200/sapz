# SAPZ ESM & CKR Platform Hypercare Support Runbook
**Document Version:** 1.0.0  
**Effective Period:** Weeks 1–12 Post-Go-Live  
**Governance:** Master Engineering Knowledge Base (MEKB Part 08)  

---

## 1. Overview
The Hypercare phase provides 24/7 dedicated engineering support, incident escalation protocols, performance monitoring, and daily health checks for the SAPZ Enterprise Management System (ESM) and Central Knowledge Repository (CKR) platform following production cutover.

---

## 2. Incident Severity Classification & SLAs

| Severity Level | Response SLA | Resolution SLA | Description | Escalation Path |
| :--- | :---: | :---: | :--- | :--- |
| **Severity 1 (Critical)** | 15 Minutes | 2 Hours | Complete platform outage, database failure, or security breach. | Lead DevOps Engineer -> Technical Director |
| **Severity 2 (High)** | 30 Minutes | 4 Hours | Core module degradation (e.g. Workflow approvals blocked). | Senior Backend Engineer -> Team Lead |
| **Severity 3 (Medium)** | 2 Hours | 12 Hours | Non-critical feature bug, minor UI glitch, or report export delay. | Support Engineer |
| **Severity 4 (Low)** | 4 Hours | 24 Hours | Feature enhancement request or cosmetic documentation update. | Helpdesk Desk Analyst |

---

## 3. Daily Operational Health Checklist
1. **Prometheus / Grafana Alert Review:** Verify zero `5xx` error spikes on `/api/v1/health` and `/api/v1/metrics`.
2. **Database Replication Health:** Check PostgreSQL primary write latency and WAL sync status.
3. **Queue Worker Status:** Ensure Redis queue workers for notifications and document indexing are running (`php artisan queue:status`).
4. **Storage Utilization:** Audit MinIO / S3 bucket capacity and disk usage.
