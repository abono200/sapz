# ADR-007: Programme Management & Multi-Zone Coordination Architecture
**Status:** APPROVED  
**Date:** 2026-07-20  
**Context:**  
The SAPZ ESM & CKR platform requires multi-programme coordination capabilities for managing donor allocations (IFAD, AfDB, IsDB) and tracking milestone achievements across state-level Special Agro-Industrial Processing Zones.

**Decision:**  
1. **Programme Schema:** Create `programmes` and `programme_milestones` tables with UUID primary keys and funder allocation metadata.
2. **Programme Service:** Encapsulate programme creation, milestone tracking, and donor reporting in `ProgrammeService`.
3. **REST Endpoints:** Expose `/api/v1/programmes` and `/api/v1/programmes/{id}/milestones`.

**Consequences:**  
- Ensures complete transparency over DFI funding allocations and milestone delivery.
