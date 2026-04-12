# Guía para desplegar en Hostinger

Esta guía te ayudará a subir tu proyecto Laravel (MÖBELS Alejandro) a Hostinger.

## Paso 1: Preparar el archivo .env

1. Copiá el archivo `.env.example` y renombralo a `.env`
2. Editá el archivo `.env` con los datos de tu hosting en Hostinger:

```env
APP_NAME="MÖBELS Alejandro"
APP_ENV=production
APP_KEY=  # Lo generarás en el paso 4
APP_DEBUG=false
APP_TIMEZONE=America/Argentina/Buenos_Aires
APP_URL=https://tudominio.com

APP_LOCALE=es
APP_FALLBACK_LOCALE=es
APP_FAKER_LOCALE=es_AR

LOG_CHANNEL=errorlog
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_base_datos
DB_USERNAME=usuario_base_datos
DB_PASSWORD=contraseña_base_datos

SESSION_DRIVER=file
SESSION_LIFETIME=120

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=public
QUEUE_CONNECTION=sync
CACHE_STORE=file

MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=tu@tudominio.com
MAIL_PASSWORD=tu_contraseña_email
MAIL_FROM_ADDRESS=info@tudominio.com
MAIL_FROM_NAME="MÖBELS Alejandro"

STORE_INSTAGRAM_URL=https://www.instagram.com/mobels_alejandro/
STORE_WHATSAPP_NUMBER=+549XXXXXXXXXX
STORE_WHATSAPP_DEFAULT_MESSAGE="Hola MÖBELS Alejandro, quiero pedir un presupuesto."
```

## Paso 2: Subir archivos a Hostinger

### Opción A: Usando el Administrador de Archivos de cPanel

1. Iniciá sesión en tu cuenta de Hostinger
2. Andá a **Hosting** → **Administrar** → **Administrador de Archivos**
3. Navegá a la carpeta `public_html` (o la carpeta de tu dominio principal)
4. Subí **todos los archivos** del proyecto (excepto `.env`, `node_modules`, `vendor`)

### Opción B: Usando FTP (FileZilla)

1. Conectate a tu hosting via FTP con los datos de Hostinger
2. Navegá a `public_html`
3. Subí todos los archivos del proyecto

## Paso 3: Estructura de carpetas en Hostinger

Después de subir los archivos, la estructura debería verse así:

```
public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
│   ├── .htaccess
│   ├── index.php
│   ├── uploads/
│   └── ...
├── resources/
├── routes/
├── storage/
├── tests/
├── vendor/
├── .env
├── .htaccess
├── artisan
├── composer.json
├── package.json
└── ...
```

## Paso 4: Configurar la carpeta pública

En Hostinger, el dominio apunta por defecto a `public_html`. Para Laravel, necesitás que apunte a `public_html/public`.

### Opción A: Modificar el .htaccess principal

Creá o editá el archivo `.htaccess` en `public_html/` (fuera de public) con:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^$ public/ [L]
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### Opción B: Cambiar el Document Root (recomendado)

1. En cPanel de Hostinger, andá a **Sitios Web** → **Configuración**
2. Cambiá el **Document Root** para que apunte a `public_html/public`

## Paso 5: Instalar dependencias

Hostinger en planes compartidos no permite ejecutar Composer directamente. Tenés dos opciones:

### Opción A: Subir vendor desde tu computadora local

1. En tu computadora, ejecutá: `composer install --no-dev --optimize-autoloader`
2. Subí la carpeta `vendor` completa a Hostinger

### Opción B: Usar SSH (si tu plan lo permite)

1. Conectate via SSH a Hostinger
2. Ejecutá: `composer install --no-dev --optimize-autoloader`

## Paso 6: Generar APP_KEY

### Opción A: Generar localmente

1. En tu computadora, ejecutá: `php artisan key:generate`
2. Copiá el valor de `APP_KEY` del archivo `.env` generado
3. Pegalo en el `.env` de Hostinger

### Opción B: Usar SSH (si tu plan lo permite)

1. Conectate via SSH
2. Ejecutá: `php artisan key:generate`

## Paso 7: Configurar base de datos

1. En cPanel de Hostinger, andá a **Bases de Datos MySQL**
2. Creá una nueva base de datos
3. Creá un usuario y asignale todos los privilegios a esa base de datos
4. Actualizá el archivo `.env` con estos datos

## Paso 8: Ejecutar migraciones

### Opción A: Exportar e importar SQL

1. En tu computadora, exportá la base de datos SQLite o MySQL
2. En Hostinger, andá a **phpMyAdmin**
3. Importá el SQL en tu base de datos

### Opción B: Usar SSH (si tu plan lo permite)

1. Conectate via SSH
2. Ejecutá: `php artisan migrate --force`

## Paso 9: Permisos de carpetas

Asegurate de que las siguientes carpetas tengan permisos de escritura (755 o 775):

- `storage/`
- `storage/app/`
- `storage/framework/`
- `storage/framework/cache/`
- `storage/framework/sessions/`
- `storage/framework/views/`
- `storage/logs/`
- `bootstrap/cache/`

## Paso 10: Configurar SSL

1. En Hostinger, andá a **SSL** en el panel de control
2. Activá el certificado SSL gratuito (Let's Encrypt)
3. Forzá el redireccionamiento HTTPS

## Paso 11: Optimizaciones finales

### Caché de configuración

Si tenés acceso SSH, ejecutá:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Compilar assets (opcional)

Si modificaste CSS/JS:
1. En tu computadora: `npm run build`
2. Subí la carpeta `public/build` a Hostinger

## Verificación

1. Visitá tu dominio: `https://tudominio.com`
2. Verificá que la página de inicio cargue correctamente
3. Probá navegar por los productos
4. Verificá el panel de administración

## Solución de problemas comunes

### Error 500

1. Revisá el archivo `storage/logs/laravel.log`
2. Verificá que el `.env` esté correctamente configurado
3. Asegurate de que `APP_DEBUG=false` en producción

### Error de permisos

Asegurate de que las carpetas `storage` y `bootstrap/cache` tengan permisos de escritura.

### Error de base de datos

Verificá que los datos de conexión en `.env` sean correctos.

### Assets no cargan

1. Verificá que `APP_URL` en `.env` sea correcto
2. Si usaste Vite, aseguráte de haber compilado los assets (`npm run build`)

## Notas importantes

- **Nunca compartas tu archivo `.env`** - contiene información sensible
- **Mantené actualizado** - Laravel y sus dependencias reciben actualizaciones de seguridad
- **Backups** - Configura backups automáticos en Hostinger
- **Monitoreo** - Revisá los logs regularmente

## Soporte

Si tenés problemas específicos con Hostinger, contactá su soporte técnico. Para problemas con Laravel, consultá la documentación oficial en [laravel.com](https://laravel.com/docs).