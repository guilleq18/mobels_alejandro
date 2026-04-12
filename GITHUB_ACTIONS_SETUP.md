# 🚀 Configuración de Deploy Automático - GitHub Actions

Este documento te guía para configurar el deploy automático desde GitHub a Hostinger.

## ⚠️ IMPORTANTE: Corrección de SSH

**Lo que viste en Hostinger NO era la clave SSH.** Era solo el comando para conectar.

Los datos correctos de Hostinger son:
- **Host:** `147.79.84.18`
- **Puerto:** `65002`
- **Usuario:** `u519347385`

## ✅ Paso 1: Generar clave SSH en tu computadora

Abre PowerShell y ejecuta:

```powershell
powershell -ExecutionPolicy Bypass -File scripts/generate-ssh-key.ps1
```

Esto generará dos archivos en `C:\Users\TuUsuario\.ssh\`:
- `hostinger_key` → **CLAVE PRIVADA** 
- `hostinger_key.pub` → **CLAVE PÚBLICA**

## ✅ Paso 2: Configurar Secrets en GitHub

Ve a tu repositorio: https://github.com/guilleq18/mobels_alejandro

1. **Settings** → **Secrets and variables** → **Actions**

2. Crea 4 secretos:

| Secreto | Valor |
|---------|-------|
| `HOSTINGER_HOST` | `147.79.84.18` |
| `HOSTINGER_PORT` | `65002` |
| `HOSTINGER_USER` | `u519347385` |
| `HOSTINGER_SSH_KEY` | *Tu clave PRIVADA completa* |

### Para el Secret `HOSTINGER_SSH_KEY`:
- Abre el archivo `hostinger_key` (sin extensión)
- Copia TODO el contenido
- Pégalo en el Secret

## ✅ Paso 3: Agregar clave pública a Hostinger

En tu panel de Hostinger:

1. Ve a **Avanzado** → **Acceso SSH**
2. Busca la sección **Claves SSH**
3. Haz clic en **"Agregar clave SSH"**
4. Pega el contenido de `hostinger_key.pub`

## ✅ Paso 4: Configurar Git en Hostinger

En Hostinger, ve a **Acceso SSH** y usa el comando para conectar:

```bash
ssh -p 65002 u519347385@147.79.84.18
```

Una vez conectado, ejecuta:

```bash
cd ~/public_html/laravel_app

# Configurar Git
git config user.email "tu@email.com"
git config user.name "Tu Nombre"

# Configurar remote (si no lo tiene)
git remote add origin https://github.com/guilleq18/mobels_alejandro.git || git remote set-url origin https://github.com/guilleq18/mobels_alejandro.git

# Traer cambios
git pull origin master
```

## ✅ Paso 5: Probar el Deploy

Desde tu computadora:

```bash
cd e:\Dev\Projects\ecomerce_mobelsalejandro

git add .
git commit -m "Actualizar configuración de SSH para GitHub Actions"
git push origin master
```

## 📊 Verificar que funcionó

1. Ve a GitHub → **Actions**
2. Verás un workflow ejecutándose
3. Espera a que termine (debe decir ✅ si fue exitoso)
4. Visita tu sitio: https://mobelsalejandro.shop

## 🆘 Si falla

### Error "Permission denied"
- Verifica que la clave SSH privada en el Secret `HOSTINGER_SSH_KEY` sea COMPLETA
- Incluye líneas `-----BEGIN RSA PRIVATE KEY-----` y `-----END RSA PRIVATE KEY-----`

### Error "Key is not valid"
- El contenido de la clave está incompleto o mal formateado

### Error "port 22: Connection refused"
- Hostinger usa puerto **65002**, no 22
- Verifica que el Secret `HOSTINGER_PORT` sea exactamente `65002`

## 📝 El workflow hace automáticamente:

1. Se ejecuta cada `git push` a rama `master`
2. Conecta vía SSH a Hostinger
3. Ejecuta `git pull` para traer cambios
4. Instala dependencias con Composer
5. Limpia caché y regenera configuración
6. ¡Cambios en vivo!

## ✅ Checklist final

- [ ] Generaste clave SSH con el script
- [ ] Agregaste 4 Secrets en GitHub
- [ ] Copiaste clave pública a Hostinger
- [ ] Conectaste vía SSH y configuraste Git
- [ ] Hiciste push y workflow ejecutó exitosamente
- [ ] Los cambios están visibles en mobelsalejandro.shop

---

¿Necesitas ayuda con algún paso?

