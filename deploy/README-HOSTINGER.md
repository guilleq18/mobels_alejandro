# Despliegue en Hostinger

Este paquete está pensado para hosting compartido con esta estructura:

- `public_html/`
- `laravel_app/`

`public_html` contiene solo los archivos públicos y `laravel_app` contiene el resto del proyecto Laravel.

## Requisitos

- PHP `8.2` o superior
- Base de datos MySQL creada en Hostinger
- Acceso al Administrador de Archivos o FTP
- Idealmente acceso a Terminal / SSH de Hostinger

## Subida

1. Subí `hostinger-package.zip` al directorio raíz de tu hosting.
2. Extraelo de forma que queden dos carpetas al mismo nivel:
   - `public_html`
   - `laravel_app`
3. Entrá a `laravel_app` y renombrá `.env.hostinger.example` a `.env`.
4. Editá `.env` con:
   - `APP_URL`
   - `DB_DATABASE`
   - `DB_USERNAME`
   - `DB_PASSWORD`
   - `STORE_WHATSAPP_NUMBER`

## Inicialización

Si tenés Terminal / SSH en Hostinger, ejecutá:

```bash
cd ~/laravel_app
php artisan migrate --force
php artisan db:seed --force
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## Permisos

Las carpetas que deben poder escribir son:

- `laravel_app/storage`
- `laravel_app/bootstrap/cache`

## Qué esperar

- Sitio público: `https://tu-dominio.com`
- Admin: `https://tu-dominio.com/admin/login`
- Usuario demo: `alejandro@example.com`
- Contraseña demo: `password`

## Notas

- Este despliegue usa MySQL en producción, no SQLite.
- La configuración de producción usa `CACHE_STORE=file`, `SESSION_DRIVER=file` y `QUEUE_CONNECTION=sync` para evitar complejidad extra en hosting compartido.
- Si Hostinger no te da Terminal / SSH, avisame y te preparo una vía segura de inicialización sin consola.
