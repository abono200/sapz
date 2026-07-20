# ADR-003: DevSecOps Pipeline & Kubernetes Infrastructure Architecture
**Status:** APPROVED  
**Date:** 2026-07-20  
**Context:**  
The SAPZ ESM & CKR platform requires production-grade Kubernetes orchestration, automated zero-downtime deployment capabilities, continuous security scanning (DevSecOps), and Prometheus/Grafana observability.

**Decision:**  
1. **Kubernetes Orchestration:** Deploy stateless backend API pods with 3 replicas, liveness/readiness HTTP probes on `/api/v1/health`, and resource limits (512MB RAM, 0.5 vCPU).
2. **Automated Security Scanning:** Integrate Trivy container vulnerability scanner and Symfony Security Checker into GitHub Actions.
3. **Prometheus Metrics Exporter:** Expose Prometheus metric endpoint `/api/v1/metrics` for real-time observability of user counts, project metrics, and document volume.

**Consequences:**  
- Guarantees 99.9% uptime SLA through Kubernetes auto-healing and zero-downtime rolling updates.
- Prevents container vulnerability deployment to production servers.
