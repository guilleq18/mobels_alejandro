# 🚀 HOSTINGER - GUÍA RÁPIDA DE DESPLIEGUE

## ✅ Preparación completada

Tu proyecto ha sido empaquetado automáticamente. Los siguientes archivos están listos:

- **Archivo ZIP:** `deploy/hostinger-package.zip`
- **Contenido:** Estructura optimizada para Hostinger

---

## 📋 PASOS PARA SUBIR A HOSTINGER

### Paso 1: Descargar el paquete
- Ve a `deploy/hostinger-package.zip`
- Descarga el archivo en tu computadora

### Paso 2: Subir a Hostinger

#### Opción A: Usar Administrador de Archivos (cPanel) ⭐ RECOMENDADO

1. Inicia sesión en tu cuenta de Hostinger
2. Ve a **Hosting** → **Administrar** → **Administrador de Archivos**
3. Abre la carpeta `public_html`
4. Sube el archivo `hostinger-package.zip`
5. Haz clic derecho → **Extraer** → Aceptar
6. Elimina el archivo `.zip` después de extraer

#### Opción B: Usar FTP (FileZilla)

1. Conecta con los credenciales FTP de Hostinger
2. Navega a `public_html`
3. Sube `hostinger-package.zip`
4. Extrae en el servidor

### Paso 3: Configurar el .env

**UBICACIÓN:** `public_html/laravel_app/.env`

Reemplaza estos valores con tus datos de Hostinger:

```env
APP_TIMEZONE=America/Argentina/Buenos_Aires  # Mantén si está OK
APP_URL=https://tu-dominio.com              # 🔴 REEMPLAZA CON TU DOMINIO

# ⚙️ BASE DE DATOS (desde cPanel → MySQL)
DB_HOST=localhost
DB_DATABASE=nombre_de_bd_hostinger          # 🔴 REEMPLAZA
DB_USERNAME=usuario_hostinger               # 🔴 REEMPLAZA 
DB_PASSWORD=contraseña_hostinger            # 🔴 REEMPLAZA

# 📧 EMAIL (opcional pero recomendado)
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=tu@tu-dominio.com             # 🔴 REEMPLAZA
MAIL_PASSWORD=contraseña_email              # 🔴 REEMPLAZA
MAIL_FROM_ADDRESS=info@tu-dominio.com       # 🔴 REEMPLAZA

# 📱 DATOS DE LA TIENDA (opcional)
STORE_WHATSAPP_NUMBER=+5493416000000        # 🔴 REEMPLAZA SI APLICA
```

### Paso 4: Cambiar Document Root (muy importante ⚠️)

En cPanel de Hostinger:

1. Ve a **Sitios Web** o **Addon Domains** (según tu plan)
2. Busca tu dominio principal
3. Haz clic en **Editar Document Root**
4. Cambia la ruta a: `public_html/public_html`

O usa este .htaccess (crear en `public_html/`):

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^$ public/ [L]
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### Paso 5: Crear base de datos

En cPanel de Hostinger:

1. Ve a **Bases de Datos MySQL**
2. Crea una nueva base de datos
3. Crea un usuario y asigna todos los privilegios
4. Anota los datos (DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD)
5. **IMPORTANTE:** Hostinger usa `localhost` para DB_HOST en los mismos servidores

### Paso 6: Importar base de datos

**Opción A: Exportar desde SQLite local**

1. En tu computadora: `php artisan migrate:fresh --seed` (opcional)
2. Exporta la BD desde SQLite o MySQL (dato) en un archivo SQL

**Opción B: Ejecutar migraciones (requiere SSH)**

Si tu plan incluye SSH:
```bash
ssh usuario@hostinger.com
cd public_html/laravel_app
php artisan migrate --force
```

### Paso 7: Configurar permisos

En el **Administrador de Archivos** de cPanel:

1. Haz clic derecho en `laravel_app/storage/` → Permisos
2. Cambia a **755** (o **775**)
3. Marca la opción "Aplicar recursivamente"
4. Haz lo mismo con `laravel_app/bootstrap/cache/`

O por SSH:
```bash
chmod -R 775 public_html/laravel_app/storage
chmod -R 775 public_html/laravel_app/bootstrap/cache
```

### Paso 8: Activar SSL

En tu cPanel de Hostinger:

1. Ve a **SSL/TLS**
2. Haz clic en "Instalar"
3. Forza HTTPS (redireccionar HTTP a HTTPS)

### Paso 9: Optimizaciones (opcional pero recomendado)

Si tienes acceso SSH:

```bash
cd public_html/laravel_app
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🧪 VERIFICACIÓN

Después de completar los pasos anteriores:

1. Abre tu navegador: `https://tu-dominio.com`
2. Verifica que la página principal cargue
3. Prueba navegación de productos
4. Verifica que CSS/JS carguen correctamente

---

## ⚠️ SOLUCIÓN DE PROBLEMAS

### Error 500

- Ve a `public_html/laravel_app/storage/logs/laravel.log`
- Busca el error en el log
- Verifica valores en `.env`

### Error "Base de datos no conecta"

- Verifica en cPanel que la BD existe
- Confirma que el usuario tiene permisos
- Usa `localhost` para DB_HOST (a menos que se indique otro)

### Archivos no se cargan (CSS/JS vacío)

- Asegúrate que APP_URL en `.env` sea correcto
- Verifica Document Root esté apuntando a `public_html/public`

### Permisos rechazados

- Revisa permisos de `storage` y `bootstrap/cache`
- Deben estar en 755 mínimo

---

## 📞 DATOS ÚTILES DE HOSTINGER

| Concepto | Valor | Dónde lo consigues |
|----------|-------|-------------------|
| **Servidor** | hostinger.com | Panel Hostinger |
| **FTP Host** | ftp.tu-dominio.com | Panel → FTP |
| **FTP Usuario** | tu-usuario | Panel → FTP |
| **FTP Puerto** | 21 | Panel → FTP |
| **SSH Host** | tu-dominio.com | Panel → SSH |
| **SSH Usuario** | usuario SSH | Panel → SSH |
| **DB Host** | localhost | Panel → MySQL (generalmente localhost) |

---

## ✨ CHECKLIST FINAL

- [ ] Paquete `hostinger-package.zip` descargado
- [ ] Archivo extraído en `public_html/`
- [ ] `.env` configurado con datos de Hostinger
- [ ] Base de datos creada
- [ ] Document Root cambiado a `public_html/public`
- [ ] Permisos de carpetas ajustados (755/775)
- [ ] SSL activado y HTTPS forzado
- [ ] Sitio accesible en `https://tu-dominio.com`
- [ ] Contenido carga correctamente

---

## 📚 RECURSOS

- **Documentación Laravel:** https://laravel.com/docs
- **Documentación Hostinger:** https://www.hostinger.es/soporte
- **Apache .htaccess:** https://httpd.apache.org/docs/2.4/mod/mod_rewrite.html

---

**¡Tu proyecto está listo para desplegarse! 🎉**
