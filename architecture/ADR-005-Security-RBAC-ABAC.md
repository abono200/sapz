# ADR-005: Security & Access Control Architecture (RBAC / ABAC)
**Status:** APPROVED  
**Date:** 2026-07-20  
**Context:**  
The SAPZ ESM & CKR platform requires role-based access control (RBAC) and attribute-based security boundaries (ABAC) to enforce Least Privilege access across departments and document classification levels (PUBLIC, INTERNAL, RESTRICTED, CONFIDENTIAL).

**Decision:**  
1. **Hybrid RBAC/ABAC Framework:** Combine role-permission assignments with runtime attribute evaluation (`RbacService::canAccessResource`) checking user department and document security classification.
2. **Security Audit Logging:** Log all role creations, permission syncs, and user role assignments to the immutable `audit_logs` table via `SecurityAuditService`.
3. **Least Privilege API Guard:** Enforce Sanctum bearer token authentication and `CheckRoleAndPermissions` middleware on all administrative security routes.

**Consequences:**  
- Guarantees full NDPA / NDPR compliance for confidential data protection.
- Prevents unauthorized cross-department data access.
