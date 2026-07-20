# ADR-013: Central Knowledge Repository (CKR) Public Engine Architecture
**Status:** APPROVED  
**Date:** 2026-07-20  
**Context:**  
The SAPZ ESM & CKR platform requires a public-facing knowledge repository for research publications, agro-industrial technical reports, multi-format academic citation generation (APA, MLA, IEEE), and public search.

**Decision:**  
1. **Public CMS Schema:** Create `ckr_categories`, `ckr_articles`, `ckr_tags`, and `article_has_tags` tables with URL-safe slugs and view/download analytics counters.
2. **Multi-Format Citation Generator:** Implement `CkrPublicService::generateCitation` supporting APA, MLA, and IEEE citation standards.
3. **Unauthenticated Public API Suite:** Expose `/api/v1/ckr/articles`, `/api/v1/ckr/articles/{slug}`, `/api/v1/ckr/articles/{id}/citation`, and `/api/v1/ckr/categories`.

**Consequences:**  
- Solves public knowledge dissemination and academic citation tracking across donor-funded SAPZ research publications.
