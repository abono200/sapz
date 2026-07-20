# ADR-015: Search Engine & AI RAG Assistant Architecture
**Status:** APPROVED  
**Date:** 2026-07-20  
**Context:**  
The SAPZ ESM & CKR platform requires hybrid semantic search capabilities and an AI RAG Assistant to query technical manuals, document registries, and research publications with zero hallucination and source citation mappings.

**Decision:**  
1. **Document Chunking & Embeddings:** Create `document_chunks` table storing content chunks and vector embeddings (`embedding_json`).
2. **AI Conversation Persistence:** Create `ai_conversations` and `ai_messages` tables tracking chat history and document citation sources (`sources_json`).
3. **AI REST API Suite:** Expose `/api/v1/search/semantic` and `/api/v1/ai/assistant/chat`.

**Consequences:**  
- Delivers instant AI knowledge retrieval across thousands of SAPZ technical pages with complete source transparency.
