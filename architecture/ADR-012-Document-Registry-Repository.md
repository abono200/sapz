# ADR-012: ESM Document Registry & Versioning Architecture
**Status:** APPROVED  
**Date:** 2026-07-20  
**Context:**  
The SAPZ ESM & CKR platform requires document registry capabilities, file versioning, security classification enforcement, and download auditing for NDPR compliance.

**Decision:**  
1. **Document Schema & Versioning:** Create `document_versions` storing SHA-256 hashes, semver version numbers, file sizes, and MIME types.
2. **Download Audit Log:** Create `document_downloads` recording every file download attempt with user ID and IP address.
3. **Document Registry API:** Expose `/api/v1/documents` endpoints supporting upload, versioning, and download.

**Consequences:**  
- Guarantees 100% document version traceability and regulatory file auditability.
