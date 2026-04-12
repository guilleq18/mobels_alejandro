# 🚀 Configuración de Deploy Automático - GitHub Actions

Este documento te guía para configurar el deploy automático desde GitHub a Hostinger.

## ✅ Paso 1: Generar clave SSH en Hostinger

Ve a tu panel de Hostinger:

1. **Panel → SSH (u OpenSSH)**
2. Asegúrate de que SSH esté **habilitado**
3. Copia tu **usuario SSH** (generalmente: `mobelsalejandro`)
4. **Genera una clave SSH** (si no la tienes) o copia tu clave privada existente

## ✅ Paso 2: Configurar Secrets en GitHub

1. Ve a tu repositorio: https://github.com/guilleq18/mobels_alejandro

2. Ve a **Settings** → **Secrets and variables** → **Actions**

3. Crea 3 secretos:

### Secret 1: `HOSTINGER_HOST`
- **Valor:** `mobelsalejandro.shop`

### Secret 2: `HOSTINGER_USER`
- **Valor:** Tu usuario SSH de Hostinger (ej: `mobelsalejandro`)

### Secret 3: `HOSTINGER_SSH_KEY`
- **Valor:** Tu **clave SSH privada completa**
  - En Hostinger, ve a SSH y descarga/copia la clave privada
  - Si usas clave existente, copia el contenido de `~/.ssh/id_rsa` (en tu computadora)

> ⚠️ **IMPORTANTE:** Esta clave debe ser la clave PRIVADA (la que comienza con `-----BEGIN RSA PRIVATE KEY-----` o similar)

## ✅ Paso 3: Configurar Git en Hostinger

SSH en tu servidor Hostinger y ejecuta:

```bash
ssh mobelsalejandro@mobelsalejandro.shop

# Una vez conectado:
cd public_html/laravel_app

# Configura Git
git config user.email "tu@email.com"
git config user.name "Tu Nombre"

# Genera clave SSH si no la tienes
ssh-keygen -t rsa -b 4096 -N "" -f ~/.ssh/id_rsa

# Muestra la clave pública
cat ~/.ssh/id_rsa.pub
```

Copia la clave pública y agrégala a GitHub:
- Ve a GitHub → Settings → **SSH and GPG keys**
- Click en **New SSH key**
- Pega la clave pública

## ✅ Paso 4: Verificar que Git esté configurado

En Hostinger, aún conectado vía SSH:

```bash
cd ~/public_html/laravel_app
git status
```

¿Ves los cambios? Si no hay errores, está configurado.

## ✅ Paso 5: Push y Deploy

Desde tu computadora:

```bash
git add .
git commit -m "Deploy automático configurado"
git push origin main
```

**GitHub Actions se ejecutará automáticamente:**
- Ve a tu repositorio → **Actions**
- Verás una ejecución con el nombre del commit
- Espera a que termine (green = éxito, red = error)

---

## 🧪 Verificar que funcionó

1. En GitHub, ve a **Actions** y verifica que se ejecutó
2. Ve a tu sitio: `https://mobelsalejandro.shop`
3. Los cambios deberían estar en vivo

## ⚙️ Comandos útiles

### Ver logs del deploy
```bash
ssh mobelsalejandro@mobelsalejandro.shop
cd ~/public_html/laravel_app
git log --oneline -5
```

### Si algo falla, revisa el log de Laravel
```bash
ssh mobelsalejandro@mobelsalejandro.shop
tail -f ~/public_html/laravel_app/storage/logs/laravel.log
```

---

## 📝 Workflow incluido en `.github/workflows/deploy.yml`

El workflow automático:
1. Se ejecuta cada vez que haces `git push` a la rama `main`
2. Conecta vía SSH a Hostinger
3. Ejecuta `git pull` para traer los cambios
4. Instala las dependencias de Composer
5. Limpia y cachea la configuración
6. ¡Listo! Los cambios están en vivo

---

## ✅ Checklist de Configuración

- [ ] SSH habilitado en Hostinger
- [ ] Secretos agregados en GitHub (HOSTINGER_HOST, HOSTINGER_USER, HOSTINGER_SSH_KEY)
- [ ] Git configurado en Hostinger (`git config user.email` y `git config user.name`)
- [ ] Clave SSH agregada a GitHub
- [ ] Primer push realizado
- [ ] Verificado en Actions que se ejecutó sin errores
- [ ] Sitio muestra los cambios

---

## 🆘 Si no funciona

1. **Verifica que SSH esté habilitado en Hostinger:**
   ```bash
   ssh -v mobelsalejandro@mobelsalejandro.shop
   ```

2. **Si sale "Permission denied":**
   - La clave SSH en el Secret no es la correcta
   - Recopia tu clave privada completa (incluyendo BEGIN y END)

3. **Si sale "Repository not found":**
   - Git no está inicializado en `public_html/laravel_app`
   - Haz `git init` y `git remote add origin https://github.com/guilleq18/mobels_alejandro.git`

4. **Ver el error en GitHub:**
   - Go a Actions → el workflow que falló → click en el job
   - Scroll down para ver dónde falló

---

## 📚 Recursos

- [GitHub Actions Documentation](https://docs.github.com/en/actions)
- [SSH Action](https://github.com/appleboy/ssh-action)
- [Hostinger SSH Support](https://www.hostinger.es/soporte)
