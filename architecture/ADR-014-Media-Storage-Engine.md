# ADR-014: Enterprise Media & Object Storage Architecture
**Status:** APPROVED  
**Date:** 2026-07-20  
**Context:**  
The SAPZ ESM & CKR platform requires multi-driver object storage (MinIO, S3, Local) for managing images, video storyboards, CAD blueprints, and geospatial shapefiles.

**Decision:**  
1. **Media Assets Schema:** Create `media_assets` storing SHA-256 hashes, MIME types, file sizes, image dimensions (width/height), and storage disk drivers.
2. **Pre-Signed Temporary URLs:** Implement `MediaStorageService::generateSignedUrl` for secure temporary access (30-minute expiration) to private object storage buckets.
3. **Media API Gateway:** Expose `/api/v1/media` and `/api/v1/media/upload` endpoints.

**Consequences:**  
- Solves secure multi-cloud asset storage and prevents unauthorized direct bucket access.
