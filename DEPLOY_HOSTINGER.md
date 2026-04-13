# Deploy en Hostinger

Este repo queda preparado para desplegarse completo dentro de `public_html` por Git. No hace falta mover archivos manualmente: el `.htaccess` de la raíz reescribe todo hacia `public/` y Laravel sigue arrancando desde `public/index.php`.

## `.env`

El repo debe versionar `.env.example`. En Hostinger debes crear un archivo `.env` real a partir de ese ejemplo y completarlo con tus credenciales.

Si tienes terminal:

```bash
cp .env.example .env
```

Si no tienes terminal, crea `.env` manualmente en la raíz del proyecto usando `.env.example` como base.

Configura al menos estas variables en producción:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com
APP_KEY=base64:TU_CLAVE

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=tu_base
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password

STORE_WHATSAPP_NUMBER=
STORE_INSTAGRAM_URL=https://www.instagram.com/mobels_alejandro/
```

Notas:

- `APP_URL` debe ser el dominio final, sin `/public`.
- El `.env` no debe versionarse.
- Si falta `APP_KEY`, genera una con `php artisan key:generate`.

## Permisos

Estas rutas deben tener permiso de escritura:

- `storage/`
- `bootstrap/cache/`
- `public/uploads/`

Si tienes terminal:

```bash
chmod -R 775 storage bootstrap/cache public/uploads
```

## Migraciones

Después del primer deploy, ejecuta:

```bash
php artisan migrate --force
```

Si quieres migrar los datos que hoy están en SQLite:

```bash
mysql -u TU_USUARIO -p TU_BASE < database/mysql_data_from_sqlite.sql
```

Si no necesitas conservar la base actual y te alcanza con los datos semilla:

```bash
php artisan db:seed --force
```

## Verificación post deploy

Comprueba estos puntos:

1. `https://tu-dominio.com/` responde la home.
2. `https://tu-dominio.com/admin/login` responde el login.
3. `https://tu-dominio.com/assets/brand/hero-workshop.svg` carga sin mostrar `/public` en la URL.
4. Si algo falla, revisa `storage/logs/laravel.log`.

## Observaciones

- `public/index.php` ya apunta correctamente a `../vendor/autoload.php` y `../bootstrap/app.php` para esta estructura.
- Las URLs generadas por la app deben usar el dominio raíz, por eso `APP_URL` tiene que quedar bien configurado.
- El repo incluye `scripts/export_sqlite_to_mysql.py` para regenerar `database/mysql_data_from_sqlite.sql` a partir de `database/database.sqlite` cuando haga falta.
- Si tu despliegue Git no instala dependencias automáticamente y aparece un error sobre `vendor/autoload.php`, ejecuta una vez:

```bash
composer2 install --no-dev --optimize-autoloader
```
