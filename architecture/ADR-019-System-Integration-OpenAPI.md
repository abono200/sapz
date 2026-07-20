# ADR-019: System Integration, Interoperability & Open API Suite
**Status:** APPROVED  
**Date:** 2026-07-20  
**Context:**  
The SAPZ ESM & CKR platform requires external integration interfaces with DFI portals (IFAD, AfDB, IsDB, World Bank), government systems (GIFMIS, IPPIS), webhook event dispatchers, and an OpenAPI 3.1 specification gateway.

**Decision:**  
1. **API Client Schema:** Create `api_clients` storing hashed client secrets (`secret_hash`), rate limit thresholds, and IP restriction rules.
2. **Webhook Dispatcher Engine:** Create `webhook_endpoints` and `webhook_logs` to log event dispatches (`PROJECT_UPDATED`, `DOCUMENT_APPROVED`).
3. **Open API Specification Gateway:** Expose public `/api/v1/docs/openapi.json` and admin endpoints `/api/v1/admin/api-clients`.

**Consequences:**  
- Guarantees seamless interoperability with international financial institutions and national government systems.
