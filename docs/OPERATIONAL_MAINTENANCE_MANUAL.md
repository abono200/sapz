# SAPZ ESM & CKR Platform Operational Maintenance Manual
**Document Version:** 1.0.0  
**Target Audience:** System Administrators, DevOps Engineers, & ICT Operations  

---

## 1. Routine System Maintenance

### 1.1 Database Backup Protocol
Daily automated PostgreSQL database backups are executed via `pg_dump` at 01:00 UTC and mirrored to encrypted offsite MinIO object storage:
```bash
docker exec -t sapz-platform-db-1 pg_dump -U sapz_admin sapz_platform | gzip > /backups/sapz_db_$(date +%Y%m%d).sql.gz
```

### 1.2 Database Migration & Rollback
To execute pending database migrations on production:
```bash
docker exec -it sapz-platform-app-1 php artisan migrate --force
```

---

## 2. Platform Monitoring & Telemetry
- **Health Endpoint:** `GET /api/v1/health`
- **Prometheus Metrics:** `GET /api/v1/metrics`
- **OpenAPI Gateway Documentation:** `GET /api/v1/docs/openapi.json`
