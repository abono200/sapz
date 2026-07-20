# ADR-011: Digital Sign-off & Proxy Delegation Architecture
**Status:** APPROVED  
**Date:** 2026-07-20  
**Context:**  
The SAPZ ESM & CKR platform requires executive digital sign-offs with SHA-256 cryptographic verification (`signature_hash`), revision loop capabilities, and temporary proxy delegations during executive travel.

**Decision:**  
1. **Cryptographic Sign-off Schema:** Create `approval_signoffs` storing SHA-256 hashes generated from request IDs, user IDs, and timestamps.
2. **Approval Proxy Delegations:** Create `approval_delegations` allowing temporary proxy assignments during specified date windows.
3. **Approval Inbox API:** Expose `/api/v1/approvals/inbox`, `/api/v1/approvals/{id}/signoff`, and `/api/v1/approvals/delegations`.

**Consequences:**  
- Guarantees non-repudiation and executive security for all platform sign-offs.
