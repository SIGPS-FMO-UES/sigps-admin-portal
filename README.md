# SIGPS - Portal Administrativo

> [!IMPORTANT]
> **Las especificaciones de este repositorio no coinciden necesariamente con las especificaciones generales del proyecto SIGPS.** Las versiones y pasos de este README son específicos para arrancar el Portal Administrativo; no reemplazan ni actualizan las especificaciones generales.

Módulo de Gestión Académica y Portal Administrativo de la Unidad de Proyección Social (UPS) de la Facultad Multidisciplinaria Oriental - UES.

## Versiones de este portal

| Componente | Versión o imagen | Fuente |
| --- | --- | --- |
| PHP | 8.4 (`php:8.4-fpm`; el proyecto requiere `^8.3`) | `docker/dev/Dockerfile`, `composer.json` |
| Laravel | 13.38.0 (`composer.lock`; `composer.json` requiere `^13.17`) | Composer |
| PostgreSQL | 16 (`postgres:16-alpine`; verificado con 16.15) | `docker-compose.dev.yml` |
| Node.js | 20 LTS | `docker/dev/Dockerfile` |
| Vite | 8.3.4 | `package-lock.json` |
| Redis | `redis:alpine` (verificado con 8.10.2; la etiqueta puede actualizarse) | `docker-compose.dev.yml` |
| Mailpit | `axllent/mailpit:latest` | `docker-compose.dev.yml` |

Docker instala PHP, Node.js, Composer, PostgreSQL, Redis y Mailpit; no es necesario instalarlos directamente en Windows.

## Arranque local con Docker

### Requisitos

- Docker Desktop iniciado con Docker Compose v2.
- Git para clonar el repositorio.

### Primera instalación

Clona el repositorio y entra a su carpeta:

```powershell
git clone https://github.com/SIGPS-FMO-UES/sigps-admin-portal.git
cd sigps-admin-portal
```

Crea el archivo local de entorno:

```powershell
Copy-Item .env.dev.example .env
```

En macOS o Linux, usa `cp .env.dev.example .env`.

Antes de levantar la aplicación, instala las dependencias PHP y JavaScript en los contenedores. El primer comando también construye la imagen PHP:

```powershell
docker compose -f docker-compose.dev.yml run --build --rm --no-deps --entrypoint composer app install --prefer-dist --no-interaction
docker compose -f docker-compose.dev.yml run --rm --no-deps --entrypoint npm app ci
```

Construye e inicia los servicios:

```powershell
docker compose -f docker-compose.dev.yml up -d --build
```

El contenedor de la aplicación genera `APP_KEY`, ejecuta las migraciones y prepara los assets al iniciar.

### Direcciones y puertos predeterminados

| Servicio | Dirección local | Puerto interno |
| --- | --- | --- |
| Portal | [http://localhost:8000](http://localhost:8000) | 80 |
| Vite / HMR | `http://localhost:5173` | 5173 |
| PostgreSQL | `localhost:5433` | 5432 |
| Redis | `localhost:6379` | 6379 |
| Mailpit SMTP | `localhost:1025` | 1025 |
| Mailpit Web UI | [http://localhost:8025](http://localhost:8025) | 8025 |

Si un puerto local ya está ocupado, cambia el valor correspondiente en `.env` antes de ejecutar Compose: `APP_PORT`, `FORWARD_DB_PORT`, `FORWARD_REDIS_PORT`, `FORWARD_MAILPIT_PORT` o `FORWARD_MAILPIT_DASHBOARD_PORT`. Si cambias el puerto de Vite, actualiza también `server.hmr.clientPort` en `vite.config.js`. En este entorno, PostgreSQL usa el puerto local `5434` porque `5433` ya está ocupado.

### Comandos útiles

Ver el estado y los registros:

```powershell
docker compose -f docker-compose.dev.yml ps
docker compose -f docker-compose.dev.yml logs -f app vite postgres
```

Ejecutar migraciones o pruebas:

```powershell
docker compose -f docker-compose.dev.yml exec app php artisan migrate
docker compose -f docker-compose.dev.yml exec app php artisan test --compact
```

Detener los servicios sin borrar los datos de PostgreSQL o Redis:

```powershell
docker compose -f docker-compose.dev.yml down
```
