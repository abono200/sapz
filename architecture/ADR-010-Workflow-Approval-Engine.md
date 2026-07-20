# ADR-010: Multi-Stage Workflow & Approval State Machine Architecture
**Status:** APPROVED  
**Date:** 2026-07-20  
**Context:**  
The SAPZ ESM & CKR platform requires multi-level workflow approvals for project allocations, procurement documents, and technical proposals.

**Decision:**  
1. **Workflow State Machine:** Implement `workflow_steps`, `approval_requests`, and `approval_histories` tables enforcing ordered step transitions (`step_order`).
2. **Approval History Tracking:** Record immutable history entries (`action`, `approver_id`, `comments`) for every approval or rejection decision.
3. **Workflow API Suite:** Expose `/api/v1/workflows` and `/api/v1/approvals/*` endpoints.

**Consequences:**  
- Guarantees 100% auditability and state transition security for executive approvals.
