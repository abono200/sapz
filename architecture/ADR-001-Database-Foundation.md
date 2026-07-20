# ADR-001: Platform Database Foundation & Relational Schema
**Status:** APPROVED  
**Date:** 2026-07-20  
**Context:**  
The SAPZ ESM & CKR Platform requires a secure, high-performance database schema capable of handling multi-tenant projects, workflow approvals, document registries, and audit logs.

**Decision:**  
1. **UUID Primary Keys:** Adopt `UUIDv4` across all relational database entities to ensure zero-collision offline synchronization and data portability.
2. **Audit Standardization:** Include `created_at`, `updated_at`, `deleted_at` (soft deletes) on all domain entities.
3. **Audit Logging:** Implement a immutable `audit_logs` table recording event type, user ID, JSON payload changes (`old_values`, `new_values`), and IP metadata.

**Consequences:**  
- Solves key collisions for offline field collection (mobile app).
- Guarantees full NDPR regulatory compliance and audit traceability.
