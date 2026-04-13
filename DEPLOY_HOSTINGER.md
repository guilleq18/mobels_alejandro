# 📋 Guía de Despliegue en Hostinger

Este documento describe los pasos y configuraciones necesarias para desplegar correctamente el e-commerce de MOBELS Alejandro en Hostinger shared hosting con despliegue automático por Git.

## ✅ Requisitos Previos

- Git configurado en Hostinger
- SSH/SFTP acceso a la cuenta
- PHP 8.2+
- MySQL (o SQLite para desarrollo)
- Acceso al panel de control de Hostinger

## 🔧 Configuración Inicial (Primera vez)

### 1. Variables de Entorno `.env`

Actualiza el archivo `.env` en la raíz del proyecto con los valores de producción en Hostinger:

```bash
# Copia el archivo de plantilla
cp .env.example .env

# Edita con tus valores:
APP_NAME="MOBELS ALEJANDRO"
APP_ENV=production
APP_KEY=base64:KVWaKh6F7sKlqd9zxL0p2mN3jKvBqY5rU8tW9xP0qY1=
APP_DEBUG=false
APP_URL=https://tu-dominio.com

# Base de datos (MySQL en Hostinger)
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=tu_base_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña

# Caché y sesión
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

# Mail (si necesitas envíos)
MAIL_MAILER=smtp
MAIL_HOST=tu-servidor-smtp
MAIL_PORT=587
MAIL_USERNAME=tu-email
MAIL_PASSWORD=tu-contraseña
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@tu-dominio.com
MAIL_FROM_NAME="MOBELS Alejandro"
```

**❗ IMPORTANTE**: Guarda el `.env` de forma segura. Nunca haga commit de este archivo (debe estar en `.gitignore`).

### 2. Generar Clave de Aplicación

```bash
php artisan key:generate
```

Si ya tienes una clave válida en `.env.production`, usala en `.env`.

### 3. Permisos de Carpetas Críticas

Asegúrate de que estas carpetas tengan permisos de escritura (755 o 775):

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod -R 755 public/uploads
```

**En Hostinger File Manager (UI)**:
- Navega a `storage/` → Click derecho → Permisos → 755
- Navega a `bootstrap/cache/` → Click derecho → Permisos → 755
- Navega a `public/uploads/` → Click derecho → Permisos → 755

### 4. Base de Datos

#### Opción A: MySQL (Recomendado para Hostinger)

```bash
# Ejecuta las migraciones
php artisan migrate --force

# (Opcional) Carga datos de prueba
php artisan db:seed --class=DatabaseSeeder
```

#### Opción B: SQLite

Si prefieres SQLite durante desarrollo:

```bash
php artisan migrate --force
# El archivo database.sqlite se creará en database/
```

## 🚀 Despliegue Automático (Cada push a main/master)

Hostinger ejecutará automáticamente estos pasos:

1. ✅ Git pull del repositorio
2. ✅ `.htaccess` en raíz redirige a `public/` automáticamente
3. ✅ Laravel responde desde `public/index.php` sin mover archivos

**No requiere intervención manual.**

### Validar que el despliegue funcionó

1. Abre tu dominio: `https://tu-dominio.com`
2. Deberías ver la página de inicio del e-commerce
3. Revisa los logs si algo falla:
   ```bash
   tail storage/logs/laravel.log
   ```

## 📝 Acciones Post-Deploy

Después de cada despliegue importante:

```bash
# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Recompilar autoload si hay cambios en composer.json
composer install --no-dev --optimize-autoloader
```

(Estos comandos pueden ejecutarse manualmente desde SSH o agregarse a un webhook de Hostinger)

## 🐛 Solución de Problemas

### "Sitio vacío" o "Error 404"

- ✅ Verifica que `.htaccess` existe en `/public_html/` (en la raíz)
- ✅ Comprueba que `mod_rewrite` está habilitado en Apache:
  ```bash
  php -m | grep -i rewrite
  # O desde SSH: apache2ctl -M | grep rewrite
  ```
- ✅ Revisa el archivo `storage/logs/laravel.log`

### "Error de permisos" en storage/

```bash
chmod -R 755 storage bootstrap/cache
```

### "Error: Class not found" o "Base de datos no existe"

- Ejecuta: `php artisan migrate --force`
- Verifica las credenciales en `.env`
- Asegúrate de que la base de datos MySQL existe en Hostinger

### Assets no cargan (`/css/`, `/js/`, `/images/`)

- Vite compila a `public/build/`
- Asegúrate de ejecutar: `npm run build` antes de hacer commit
- Verifica que `public/` está accesible y tiene permisos 755

## 📂 Estructura de Despliegue

Cuando Hostinger despliega, el repositorio va a `public_html/`:

```
public_html/
├── .htaccess          ← Redirecciona a public/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
│   ├── .htaccess      ← Reglas de Laravel
│   ├── index.php      ← Punto de entrada
│   ├── build/         ← Assets compilados por Vite
│   ├── css/
│   ├── js/
│   ├── images/
│   └── uploads/
├── resources/
├── routes/
├── storage/           ← DEBE tener permisos 755
├── vendor/
├── .env               ← Variables privadas
├── composer.json
└── ... (resto de archivos)
```

## 🔐 Seguridad

- ✅ `.env` nunca en Git (ya en `.gitignore`)
- ✅ `APP_DEBUG=false` en producción
- ✅ `storage/logs/` accesible solo a ti (chmod 755)
- ✅ `public/uploads/` monitoreado para ataques
- ✅ Desactiva el `welcome.blade.php` en producción si queda expuesto

## 📞 Contacto y Support

Si algo no funciona:
1. Revisa `storage/logs/laravel.log`
2. Ejecuta: `php artisan tinker` para debuggear
3. Contacta a Hostinger support si es problema de servidor

---

**Última actualización**: Abril 2026  
**Versión de Laravel**: 11.31  
**Versión de PHP**: 8.2+
