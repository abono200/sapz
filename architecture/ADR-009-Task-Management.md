# ADR-009: Work Breakdown Task Management Architecture
**Status:** APPROVED  
**Date:** 2026-07-20  
**Context:**  
The SAPZ ESM & CKR platform requires task management services, task comment tracking, parent-child subtask hierarchies, priority matrices (LOW, MEDIUM, HIGH, CRITICAL), and estimated vs logged hours tracking.

**Decision:**  
1. **Task Schema:** Create `tasks` and `task_comments` tables with UUID primary keys, priority enums, status transitions, and self-referencing `parent_id` for subtasks.
2. **Task Service:** Encapsulate task queries, status transitions, time logging, and comment tracking in `TaskService`.
3. **Task REST API:** Implement `/api/v1/tasks` endpoints with multi-attribute filtering.

**Consequences:**  
- Solves granular work breakdown tracking and task auditability across SAPZ engineering teams.
