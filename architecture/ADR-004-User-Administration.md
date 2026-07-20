# ADR-004: User Administration & Profile Management Architecture
**Status:** APPROVED  
**Date:** 2026-07-20  
**Context:**  
The SAPZ ESM & CKR platform requires user management services, organizational department hierarchies, and user profile management capabilities.

**Decision:**  
1. **Service Layer Pattern:** Encapsulate business logic inside `UserService` and `DepartmentService` to maintain clean controller interfaces.
2. **Form Request Validation:** Separate validation logic into dedicated Form Request classes (`CreateUserRequest`, `UpdateUserRequest`, `UpdateProfileRequest`, `UpdatePasswordRequest`).
3. **Hierarchical Departments:** Implement parent-child relationships on `departments` (`parent_id`) allowing multi-tier SAPZ organizational structures.

**Consequences:**  
- Ensures clean separation of concerns and high testability.
- Simplifies user filtering and administration.
