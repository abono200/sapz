# ADR-008: Projects Module & State Agro-Industrial Processing Zone Engine
**Status:** APPROVED  
**Date:** 2026-07-20  
**Context:**  
The SAPZ ESM & CKR platform requires project lifecycle tracking, budget execution monitoring (`executed_budget`), contractor tracking, and geographic Agro-Industrial Processing Zone mappings (`project_zones`).

**Decision:**  
1. **Agro-Zone Engine Schema:** Create `project_zones` table tracking state, commodity focus (Rice, Cassava, Livestock, Cocoa), and GPS coordinates.
2. **Project Financial Tracking:** Extend `projects` schema with `executed_budget` and `contractor_name` columns.
3. **Project API Gateway:** Implement `/api/v1/projects` REST endpoints with filtering by status, zone, and search terms.

**Consequences:**  
- Solves state-level zone mapping and real-time capital expenditure tracking across SAPZ projects.
