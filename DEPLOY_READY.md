# ✅ PROYECTO LISTO PARA DEPLOY AUTOMÁTICO

Tu proyecto **MOBELS ALEJANDRO** está completamente configurado para produción con deploy automático desde GitHub.

---

## 📊 Estado Actual

✅ **Proyecto en vivo:** https://mobelsalejandro.shop  
✅ **Repositorio:** https://github.com/guilleq18/mobels_alejandro  
✅ **Base de datos:** Creada y poblada en Hostinger  
✅ **SSL/HTTPS:** Habilitado  

---

## 🚀 Configurar Deploy Automático (5 minutos)

### Paso 1️⃣: Generar clave SSH (en tu computadora)

Abre PowerShell y ejecuta:

```powershell
cd e:\Dev\Projects\ecomerce_mobelsalejandro
powershell -ExecutionPolicy Bypass -File scripts/generate-ssh-key.ps1
```

Esto generará dos archivos:
- `C:\Users\TuUsuario\.ssh\hostinger_key` (PRIVADA)
- `C:\Users\TuUsuario\.ssh\hostinger_key.pub` (PÚBLICA)

### Paso 2️⃣: Agregar Secrets en GitHub

1. Ve a: https://github.com/guilleq18/mobels_alejandro/settings/secrets/actions
2. Crea 4 secretos:

```
HOSTINGER_HOST = 147.79.84.18
HOSTINGER_PORT = 65002
HOSTINGER_USER = u519347385
HOSTINGER_SSH_KEY = [Contenido completo de hostinger_key]
```

Para `HOSTINGER_SSH_KEY`:
- Abre `C:\Users\TuUsuario\.ssh\hostinger_key`
- Copia TODO el contenido (desde `-----BEGIN` hasta `-----END`)
- Pégalo en el Secret

### Paso 3️⃣: Agregar clave pública a Hostinger

1. Ve a tu panel Hostinger: https://panel.hostinger.com/
2. Avanzado → Acceso SSH
3. Sección **Claves SSH** → "Agregar clave SSH"
4. Pega el contenido de `C:\Users\TuUsuario\.ssh\hostinger_key.pub`

### Paso 4️⃣: Configurar Git en Hostinger (SSH)

Conecta a Hostinger:

```bash
ssh -p 65002 u519347385@147.79.84.18
```

Luego ejecuta:

```bash
cd ~/public_html/laravel_app

git config user.email "tu@email.com"
git config user.name "Tu Nombre"

git remote set-url origin https://github.com/guilleq18/mobels_alejandro.git

git pull origin master
```

### Paso 5️⃣: Hacer un push de prueba

Desde tu computadora:

```bash
cd e:\Dev\Projects\ecomerce_mobelsalejandro

git add .
git commit -m "Deploy automático configurado y listo"
git push origin master
```

## ✅ Verificar que funciona

1. Ve a GitHub → Actions
2. Verás un workflow "Deploy to Hostinger" ejecutándose
3. Espera a que termine (debe salir verde ✅)
4. Ve a https://mobelsalejandro.shop
5. ¡Los cambios están en vivo!

---

## 📝 De aquí en adelante

**Cada vez que hagas `git push`:**

```bash
git add .
git commit -m "Mi cambio descriptivo"
git push origin master
```

**Automáticamente:**
- GitHub Actions se ejecuta
- Conecta a Hostinger vía SSH
- Trae los cambios (`git pull`)
- Instala las dependencias (`composer install`)
- Limpia caché y regenera configuración
- **¡Tu sitio se actualiza sin hacer nada!** 🚀

---

## 📁 Archivos importantes

- **`.github/workflows/deploy.yml`** - El workflow que hace el deploy automático
- **`GITHUB_ACTIONS_SETUP.md`** - Guía detallada de configuración
- **`scripts/generate-ssh-key.ps1`** - Script para generar claves SSH
- **`database.sql`** - SQL de la base de datos

---

## 🆘 Problemas comunes

| Problema | Solución |
|----------|----------|
| "Permission denied (publickey)" | Verifica que la clave SSH pública esté en Hostinger |
| "Connection refused" | Puerto debe ser `65002`, no 22 |
| "Key is not valid" | La clave privada en el Secret está incompleta |
| Workflow nunca se ejecuta | Verifica que `HOSTINGER_SSH_KEY` tenga `-----BEGIN` y `-----END` |

---

## 📚 Documentos de referencia

- [GITHUB_ACTIONS_SETUP.md](GITHUB_ACTIONS_SETUP.md) - Guía completa
- [HOSTINGER_QUICK_START.md](HOSTINGER_QUICK_START.md) - Guía inicial de Hostinger
- [database.sql](database.sql) - SQL de la base de datos

---

## 🎉 ¡Listo!

Tu proyecto está completamente preparado. Solo sigue los 5 pasos y tendrás deploy automático.

**¿Alguna pregunta o necesitas ayuda?** Revisa los documentos de referencia.
