# Appendix A — Glossary & Acronyms

## A.1 Executive Overview
In large-scale, multi-stakeholder enterprise systems development—such as the Special Agro-Industrial Processing Zones (SAPZ) programme—establishing an unambiguous, unified terminology is critical. The SAPZ programme involves a complex ecosystem comprising national governments, international development finance institutions (DFIs) including the International Fund for Agricultural Development (IFAD), the African Development Bank (AfDB), and the Islamic Bank of Development (IsDB), alongside multiple systems integrators and engineering teams. 

This reference chapter defines the official glossary of terms, abbreviations, acronyms, and technical definitions used throughout the design, development, deployment, governance, and operation of the SAPZ Enterprise System Management (ESM) Platform and Central Knowledge Repository (CKR). It serves as the authoritative, single source of truth to ensure absolute alignment across all technical documentation, software source code, database structures, APIs, and operational runbooks.

---

## A.2 Purpose
The key objectives of this reference chapter are to:
1. **Establish a Common Vocabulary:** Align business analysts, developers, enterprise architects, quality assurance engineers, operations teams, and donor stakeholders on a single set of definitions.
2. **Eliminate Ambiguity:** Clear up common misunderstandings between overlapping domains (e.g., distinguishing between a "Release" in project management and a "Release" in DevSecOps).
3. **Promote Technical Consistency:** Enforce consistency across database schemas, API schemas, and functional specifications.
4. **Accelerate Onboarding:** Provide new engineers and external contractors with an immediate reference to understand the technical context of the SAPZ platform.
5. **Support Compliance and Audit Audits:** Ensure that regulatory, security, and data protection terminologies match national standards (e.g., NDPA) and international frameworks (e.g., ISO/IEC 27001).

---

## A.3 Scope
This glossary spans both the technical and business domains of the SAPZ Enterprise Platform, categorizing terms across the following disciplines:
*   Programme and Business Operations
*   Project Management and Delivery Life Cycle
*   System Architecture and Software Engineering
*   API and Integration Architecture
*   Identity and Access Management (IAM) and Information Security
*   Database and Data Engineering
*   Artificial Intelligence and Knowledge Services
*   DevSecOps, Infrastructure, and Systems Operations
*   Quality Assurance and Software Quality Engineering
*   Business Intelligence and Reporting Services
*   Business Continuity and Operations
*   Compliance and International Standards

---

## A.4 Intended Audience
This reference manual chapter is written for:
*   **Solution Architects and Systems Engineers:** To ensure system blueprints use correct terminology.
*   **Software Engineers and Database Administrators:** To align code, API schemas, and data dictionary entities with official names.
*   **QA Engineers:** To map test cases and defect reports to consistent technical terms.
*   **Project Managers and Business Analysts:** To align business requirements documents (BRDs) and product definition documents (PDDs) with engineering realities.
*   **Governance and Compliance Officers:** To evaluate standard compliance (NDPA, ISO/IEC 27001).

---

## A.5 When to Use This Reference
This document must be consulted in the following circumstances:
*   **During Architecture and Design Review:** Prior to signing off on any Architecture Decision Record (ADR) or System Design Document.
*   **During Code Reviews and Pull Requests:** To verify that variable names, database tables, and API endpoints conform to standard definitions.
*   **During Requirements Definition:** When writing functional specs to prevent the introduction of ad-hoc terminology.
*   **During Technical Authoring:** When drafting user guides, system manuals, or training materials.

---

## A.6 Main Reference Content

### A.6.1 Programme & Business Acronyms

> **Operational Note:** These acronyms define the administrative, funding, and governmental agencies coordinating the SAPZ programme.

Table A-1
*Programme and Business Acronyms*
| Acronym | Meaning | Description |
| :--- | :--- | :--- |
| **SAPZ** | Special Agro-Industrial Processing Zones | National agricultural industrialization programme. |
| **NPCO** | National Programme Coordination Office | Federal coordination office for the SAPZ programme. |
| **FMARD** | Federal Ministry of Agriculture and Rural Development | Parent ministry for SAPZ (now Federal Ministry of Agriculture and Food Security). |
| **FMAFS** | Federal Ministry of Agriculture and Food Security | Parent ministry for SAPZ. |
| **IFAD** | International Fund for Agricultural Development | Co-funder of the SAPZ programme. |
| **AfDB** | African Development Bank | Co-funder of the SAPZ programme. |
| **IsDB** | Islamic Development Bank | Co-funder of the SAPZ programme. |
| **ESM** | Enterprise System Management | Internal enterprise management platform for SAPZ. |
| **CKR** | Central Knowledge Repository | External knowledge repository and CMS for SAPZ. |
| **SLA** | Service Level Agreement | Agreed service performance targets. |
| **SOP** | Standard Operating Procedure | Documented operational procedure. |
| **RACI** | Responsible, Accountable, Consulted, Informed | Responsibility assignment matrix. |

---

### A.6.2 Project Management Acronyms

Table A-2
*Project Management Acronyms*
| Acronym | Meaning |
| :--- | :--- |
| **BRD** | Business Requirements Document |
| **PDD** | Product Definition Document |
| **SRS** | Software Requirements Specification |
| **RTM** | Requirements Traceability Matrix |
| **WBS** | Work Breakdown Structure |
| **UAT** | User Acceptance Testing |
| **SIT** | System Integration Testing |
| **FAT** | Factory Acceptance Testing |
| **SAT** | Site Acceptance Testing |
| **MVP** | Minimum Viable Product |
| **Epic** | Large body of work comprising multiple features |
| **Feature** | Functional capability delivering business value |
| **User Story** | Requirement expressed from an end-user perspective |
| **Backlog** | Prioritized list of work items |
| **Sprint** | Time-boxed development iteration |
| **Increment** | Working software delivered during a sprint |
| **Release** | Deployable collection of completed increments |

---

### A.6.3 Architecture & Engineering Terms

Table A-3
*Architecture and Engineering Terms*
| Acronym/Term | Meaning/Definition |
| :--- | :--- |
| **ADR** | Architecture Decision Record |
| **DoR** | Definition of Ready |
| **DoD** | Definition of Done |
| **DDD** | Domain-Driven Design |
| **SOLID** | Five object-oriented design principles |
| **DRY** | Don't Repeat Yourself |
| **KISS** | Keep It Simple, Stupid |
| **YAGNI** | You Aren't Gonna Need It |
| **MVC** | Model-View-Controller |
| **CQRS** | Command Query Responsibility Segregation |
| **RAG** | Retrieval-Augmented Generation |
| **Event Bus** | Infrastructure for event-driven communication |
| **Message Queue** | Middleware for asynchronous processing |
| **Service Layer** | Business logic abstraction layer |
| **Repository Pattern** | Data access abstraction pattern |

---

### A.6.4 API & Integration Terms

Table A-4
*API and Integration Terms*
| Acronym/Term | Meaning/Definition |
| :--- | :--- |
| **API** | Application Programming Interface |
| **REST** | Representational State Transfer |
| **GraphQL** | Query language for APIs |
| **JSON** | JavaScript Object Notation |
| **XML** | Extensible Markup Language |
| **YAML** | YAML Ain't Markup Language |
| **HTTP** | Hypertext Transfer Protocol |
| **HTTPS** | Hypertext Transfer Protocol Secure |
| **URI** | Uniform Resource Identifier |
| **URL** | Uniform Resource Locator |
| **Webhook** | Event-driven HTTP callback |
| **OAuth 2.0** | Authorization framework |
| **OIDC** | OpenID Connect |
| **JWT** | JSON Web Token |
| **Bearer Token** | Token-based authorization mechanism |

---

### A.6.5 Identity & Security Terms

> **Security Consideration:** All security terms must be aligned with OWASP ASVS and NIST guidelines. Conformance to these definitions is required for security sign-off.

Table A-5
*Identity and Security Terms*
| Acronym/Term | Meaning/Definition |
| :--- | :--- |
| **IAM** | Identity and Access Management |
| **RBAC** | Role-Based Access Control |
| **ABAC** | Attribute-Based Access Control |
| **MFA** | Multi-Factor Authentication |
| **SSO** | Single Sign-On |
| **PKI** | Public Key Infrastructure |
| **TLS** | Transport Layer Security |
| **SSL** | Secure Sockets Layer |
| **AES** | Advanced Encryption Standard |
| **RSA** | Rivest–Shamir–Adleman Encryption |
| **SHA** | Secure Hash Algorithm |
| **OWASP** | Open Worldwide Application Security Project |
| **ASVS** | Application Security Verification Standard |
| **CSP** | Content Security Policy |
| **CSRF** | Cross-Site Request Forgery |
| **XSS** | Cross-Site Scripting |
| **SQL Injection** | Database injection attack |
| **SSRF** | Server-Side Request Forgery |

---

### A.6.6 Database & Data Engineering Terms

Table A-6
*Database and Data Engineering Terms*
| Acronym/Term | Meaning/Definition |
| :--- | :--- |
| **DBMS** | Database Management System |
| **RDBMS** | Relational Database Management System |
| **ERD** | Entity Relationship Diagram |
| **ETL** | Extract, Transform, Load |
| **ELT** | Extract, Load, Transform |
| **PK** | Primary Key |
| **FK** | Foreign Key |
| **UUID** | Universally Unique Identifier |
| **ACID** | Atomicity, Consistency, Isolation, Durability |
| **OLTP** | Online Transaction Processing |
| **OLAP** | Online Analytical Processing |
| **CDC** | Change Data Capture |

---

### A.6.7 Artificial Intelligence Terms

Table A-7
*Artificial Intelligence Terms*
| Term | Definition |
| :--- | :--- |
| **AI** | Artificial Intelligence |
| **ML** | Machine Learning |
| **DL** | Deep Learning |
| **LLM** | Large Language Model |
| **NLP** | Natural Language Processing |
| **OCR** | Optical Character Recognition |
| **Embeddings** | Vector representation of content |
| **Prompt Engineering** | Designing prompts for AI systems |
| **Vector Database** | Database optimized for embeddings |
| **Semantic Search** | Meaning-based search technique |
| **AI Agent** | Autonomous AI workflow component |

---

### A.6.8 DevSecOps & Infrastructure Terms

Table A-8
*DevSecOps and Infrastructure Terms*
| Term | Definition |
| :--- | :--- |
| **CI** | Continuous Integration |
| **CD** | Continuous Delivery / Continuous Deployment |
| **CI/CD** | Continuous Integration and Continuous Delivery |
| **IaC** | Infrastructure as Code |
| **Docker** | Containerization platform |
| **Kubernetes (K8s)** | Container orchestration platform |
| **Helm** | Kubernetes package manager |
| **Terraform** | Infrastructure provisioning tool |
| **Ansible** | Configuration management tool |
| **Nginx** | Web server and reverse proxy |
| **Redis** | In-memory data store |
| **RabbitMQ** | Message broker |
| **MinIO** | Object storage platform |

---

### A.6.9 Quality Assurance Terms

Table A-9
*Quality Assurance Terms*
| Term | Definition |
| :--- | :--- |
| **QA** | Quality Assurance |
| **QC** | Quality Control |
| **Unit Test** | Test of an individual software component |
| **Integration Test** | Test of interactions between components |
| **Regression Test** | Test to ensure existing functionality remains unaffected |
| **Smoke Test** | Basic validation after deployment |
| **Performance Test** | Evaluation under expected load |
| **Load Test** | Performance under increasing user demand |
| **Stress Test** | Behaviour beyond expected operational limits |
| **Accessibility Test** | Validation against accessibility requirements |

---

### A.6.10 Business Intelligence & Reporting Terms

Table A-10
*Business Intelligence and Reporting Terms*
| Term | Definition |
| :--- | :--- |
| **BI** | Business Intelligence |
| **MIS** | Management Information System |
| **Dashboard** | Visual presentation of key metrics |
| **Report** | Structured business information output |
| **Analytics** | Analysis of operational or business data |
| **Data Warehouse** | Central repository for analytical data |
| **Data Lake** | Storage repository for structured and unstructured data |

---

### A.6.11 Business Continuity & Operations

Table A-11
*Business Continuity and Operations Terms*
| Acronym/Term | Meaning/Definition |
| :--- | :--- |
| **DR** | Disaster Recovery |
| **BCP** | Business Continuity Plan |
| **RTO** | Recovery Time Objective |
| **RPO** | Recovery Point Objective |
| **HA** | High Availability |
| **Failover** | Automatic transfer to a standby system |
| **Backup** | Copy of data for recovery purposes |
| **Restore** | Recovery of backed-up data |

---

### A.6.12 Standards & Compliance

Table A-12
*Standards and Compliance Acronyms*
| Acronym/Term | Meaning/Definition |
| :--- | :--- |
| **ISO** | International Organization for Standardization |
| **ISO 27001** | Information Security Management Standard |
| **ISO 9001** | Quality Management Standard |
| **ISO 31000** | Risk Management Standard |
| **ISO 22301** | Business Continuity Standard |
| **NIST** | National Institute of Standards and Technology |
| **WCAG** | Web Content Accessibility Guidelines |
| **GDPR** | General Data Protection Regulation |
| **NDPA** | Nigeria Data Protection Act |
| **NDPC** | Nigeria Data Protection Commission |

---

### A.6.13 General Technical Terms

Table A-13
*General Technical Terms and Definitions*
| Term | Definition |
| :--- | :--- |
| **Enterprise Architecture** | High-level structure defining business, applications, data, and technology across the organization. |
| **Solution Architecture** | Architecture describing how a specific solution satisfies business and technical requirements. |
| **Knowledge Repository** | Centralized system for storing, organizing, retrieving, and sharing institutional knowledge. |
| **Workflow** | Sequence of tasks performed to achieve a business outcome. |
| **Metadata** | Data describing other data, such as author, date, tags, or document classification. |
| **Audit Trail** | Chronological record of system activities and changes. |
| **Version Control** | Management of changes to documents, code, and configuration over time. |
| **Governance** | Framework of policies, processes, and responsibilities guiding decision-making and accountability. |

---

## A.7 Practical Guidance

### A.7.1 Resolving Terminology Conflicts
When writing specifications or writing code, developers and business analysts may encounter overlapping terms. In such scenarios, the following rules apply:
1. **Scope Check:** Determine if the conflict is between a business term and a technical term. If so, use the technical term in code and database schemas, and map it to the business term in the UI layer.
2. **Consult the Repository:** Check the current version of the data dictionary in `04_Database/SAPZ_DDS/` to check naming conventions.
3. **Escalation Path:** If a term's definition is ambiguous, submit a request to the Architecture Review Board (ARB) for clarification.

---

## A.8 Best Practices
*   **Strict Adherence in Code:** Developers must use the acronyms and terms defined in this appendix when naming classes, variables, database tables, and API fields. For example, use `RTM` rather than `TraceabilityMatrix` or `ReqMatrix`.
*   **Single Source of Truth:** Never copy tables from this glossary into separate documents. Always cross-reference this chapter to avoid version fragmentation.
*   **Clear Contextualization:** When writing documentation, if a term could have multiple meanings outside the project, explicitly reference its definition here (e.g., "as defined in Table A-6").
*   **Database Naming Conformity:** Use lowercase alphanumeric snake_case for all schema entities, ensuring standard abbreviations (like `id` or `uuid`) are applied consistently.

---

## A.9 Common Pitfalls
*   **Ad-hoc Abbreviation:** Naming components using custom abbreviations not listed in this glossary (e.g., using `Auth` where `IAM` or `OAuth 2.0` is meant).
*   **Context Collision:** Using terms like "Restore" to mean database recovery while using it elsewhere in user interface actions to mean "Undelete." Use "Undelete" or "Recover Document" for system records, reserving "Restore" for backup restorations.
*   **Outdated Glossary References:** Referring to the parent ministry as "FMARD" in new system documentation. The ministry must be referred to as "FMAFS" in all future specifications.

---

## A.10 Terminology Governance

> **Compliance Requirement:** Any modification to this glossary requires explicit approval from the Solution Architect and must be logged as a revision.

To ensure consistency across the programme:
1.  **Authoritative Source:** This glossary shall be the authoritative source for all terminology used in project deliverables.
2.  **Change Control:** New terms or acronyms shall be reviewed and approved by the Solution Architect or Architecture Review Board (ARB) before adoption.
3.  **Deprecation Policy:** Obsolete terms shall be marked as deprecated rather than removed, preserving historical context.
4.  **Scheduled Reviews:** The glossary shall be reviewed and updated at major project milestones, significant architectural changes, or at least once every quarter.

---

## A.11 Related Chapters
For a complete understanding of how these terms are applied within the system lifecycle, refer to the following reference chapters:
*   **Chapter 6 (Architecture Governance):** Defines the role of the ARB in enforcing terminology standards.
*   **Chapter 7 (Technology Stack Standards):** Standardizes approved reference technologies and versions.
*   **Chapter 8 (Repository & Project Structure):** Applies directory and naming structures.
*   **Chapter 11 (Database Engineering Standards):** Maps data model entities to defined data terms.
*   **Chapter 12 (API Engineering Standards):** Details HTTP, URI, and JSON mapping requirements.
*   **Chapter 16 (Quality Engineering & Testing Standards):** Explains UAT, SIT, and QA implementation boundaries.
*   **Chapter 17 (Documentation Standards):** Outlines documentation hierarchy and compliance.

---

## A.12 References
The glossary terms and standards referenced in this document are aligned with:
1.  **ISO/IEC 27001:** Information security management governance definitions.
2.  **ISO/IEC 25010:** System and software quality models.
3.  **Nigeria Data Protection Act (NDPA) 2023:** Legal definitions of data controllers, processors, and personal data.
4.  **RFC 9110:** HTTP protocol semantics and structure.
5.  **OWASP ASVS v4.0:** Application security standard terms.

---

## A.13 Summary
Defining standard terminology is the foundation of structural integrity on any software development project. By maintaining a single, consistent dictionary of business acronyms, architecture terms, and compliance standards, the SAPZ programme ensures that developers, architects, donor representatives, and program coordinators communicate without friction. This glossary must be treated as a living contract, maintained under strict version control, and checked regularly during QA, code reviews, and system audits.
