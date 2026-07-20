# ADR-016: Multi-Channel Real-Time Notifications Architecture
**Status:** APPROVED  
**Date:** 2026-07-20  
**Context:**  
The SAPZ ESM & CKR platform requires multi-channel notification dispatch (In-App real-time, Email queues, SMS alerts) and user notification channel preferences.

**Decision:**  
1. **Notification Schema:** Create `notifications` and `user_notification_preferences` tables.
2. **Multi-Channel Dispatch Engine:** Implement `NotificationService` handling preferences and multi-channel queues.
3. **Notifications API Suite:** Expose `/api/v1/notifications` and `/api/v1/notifications/preferences`.

**Consequences:**  
- Solves real-time workflow alert delivery across mobile and web platforms for executive approvals.
