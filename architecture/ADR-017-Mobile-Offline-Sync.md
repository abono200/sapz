# ADR-017: Mobile Data Collection & Cryptographic Offline Sync Architecture
**Status:** APPROVED  
**Date:** 2026-07-20  
**Context:**  
The SAPZ ESM & CKR platform requires field data collection capabilities in remote agro-industrial zones with poor connectivity, supporting offline SQLite caching and batch synchronization protocol with PostgreSQL.

**Decision:**  
1. **Offline Field Inspection Schema:** Create `field_inspections` table storing GPS coordinates (`latitude`, `longitude`), inspection notes, and client timestamps (`client_created_at`).
2. **Mobile Sync Session Logger:** Create `mobile_sync_sessions` tracking batch sync operations (`device_id`, `items_synced`, `status`).
3. **Mobile Batch API:** Expose `/api/v1/mobile/sync` and `/api/v1/mobile/inspections`.

**Consequences:**  
- Solves remote field inspection data capture without loss of data during network outages.
