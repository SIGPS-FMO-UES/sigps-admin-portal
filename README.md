# SIGPS - Portal Administrativo (sigps-admin-portal)

Módulo de Gestión Académica y Portal Administrativo de la Unidad de Proyección Social (UPS) de la Facultad Multidisciplinaria Oriental - UES.

Desarrollado con **Laravel 13**, **PostgreSQL 16**, **Redis**, **Mailpit** y **Tailwind CSS**.

---

## 🐳 Entorno de Desarrollo Local con Docker

El proyecto incluye configuración de Docker para desarrollo y pruebas locales con recarga en vivo de código y assets:
- `docker-compose.dev.yml` / `docker/dev/`

### 🚀 Servicios disponibles en desarrollo

| Servicio | Imagen | Puerto Host / URL |
| :--- | :--- | :--- |
| **`app`** | PHP 8.4-FPM + Nginx | [http://localhost:8000](http://localhost:8000) |
| **`vite`** | Vite HMR | [http://localhost:5173](http://localhost:5173) |
| **`postgres`** | PostgreSQL 16 Alpine | `localhost:5433` (interno: `5432`) |
| **`mailpit`** | Mailpit Web UI y SMTP | Web UI: [http://localhost:8025](http://localhost:8025) (SMTP: `1025`) |
| **`redis`** | Redis Alpine | `localhost:6379` |

---

### 🛠️ Puesta en marcha rápida

1. **Preparar variables de entorno**:
   ```bash
   cp .env.dev.example .env
   ```

2. **Construir e iniciar los servicios**:
   ```bash
   docker compose -f docker-compose.dev.yml up -d --build
   ```

3. **Verificar el estado**:
   ```bash
   docker compose -f docker-compose.dev.yml ps
   docker compose -f docker-compose.dev.yml logs -f
   ```

4. **Ejecutar migraciones (cuando sea necesario)**:
   ```bash
   docker compose -f docker-compose.dev.yml exec app php artisan migrate
   ```

5. **Detener los servicios**:
   ```bash
   docker compose -f docker-compose.dev.yml down
   ```
