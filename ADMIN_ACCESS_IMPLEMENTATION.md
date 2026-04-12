# 🎯 ACCESO ADMIN - IMPLEMENTACIÓN PASO A PASO

## Status: ✅ EL CÓDIGO YA ESTÁ MODIFICADO

He agregado la ruta de bypass directamente en `routes/web.php`. Ahora solo necesitas:

---

## PASO 1️⃣: Hacer Commit en Local

Abre PowerShell y ejecuta este comando:

```powershell
cd e:\Dev\Projects\ecomerce_mobelsalejandro
git add routes/web.php
git commit -m "Add admin bypass access route"
git push origin main
```

**O simplemente ejecuta el script:**

```powershell
.\push-admin-changes.ps1
```

---

## PASO 2️⃣: Actualizar en Hostinger

SSH a tu servidor:

```bash
ssh u519347385@br-asc-web1663.hostinger.mx
```

Luego:

```bash
cd ~/domains/mobelsalejandro.shop/public_html
git pull origin main
```

---

## PASO 3️⃣: Acceder al Admin

Abre en tu navegador:

```
https://mobelsalejandro.shop/admin/bypass-login
```

**Qué sucede:**

✅ Se crea el usuario `alejandro@example.com`  
✅ Te inicia sesión automáticamente  
✅ Redirige al dashboard (`/admin`)  

---

## 🔍 ¿Qué Cambió Exactamente?

### Archivo: `routes/web.php`

Se agregó al final esta ruta:

```php
// 🔴 ACCESO DIRECTO AL ADMIN (TEMPORAL - Solo en desarrollo/host)
// Para entrar: https://mobelsalejandro.shop/admin/bypass-login
Route::get('/admin/bypass-login', function () {
    $user = \App\Models\User::firstOrCreate(
        ['email' => 'alejandro@example.com'],
        [
            'name' => 'Alejandro',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]
    );
    
    \Illuminate\Support\Facades\Auth::login($user);
    
    return redirect('/admin')->with('status', '✅ Acceso al admin activado');
});
```

**Lo que hace:**

1. **firstOrCreate** → Busca el usuario con email `alejandro@example.com`. Si no existe, lo crea.
2. **Hash::make('password')** → La contraseña se guarda hasheada en la BD
3. **Auth::login** → Te inicia sesión automáticamente
4. **redirect('/admin')** → Te lleva al dashboard

---

## ✅ Opciones de Acceso

### Entrar por Primera Vez:
```
https://mobelsalejandro.shop/admin/bypass-login
```
→ Se crea el usuario y te logea automáticamente

### Entrar de Nuevo (Después de Logout):
**Opción A (Rápido):**
```
https://mobelsalejandro.shop/admin/bypass-login
```

**Opción B (Login Normal):**
```
https://mobelsalejandro.shop/admin/login
```
Email: `alejandro@example.com`  
Password: `password`

---

## 🔐 Credenciales

```
Email: alejandro@example.com
Password: password
```

Puedes cambiar la contraseña dentro del admin para algo más seguro.

---

## Para Producción

Cuando el sitio esté en producción, **quita o protege esta ruta**. Opciones:

### Opción 1: Comentar la ruta

```php
// Route::get('/admin/bypass-login', function () { ... });
```

### Opción 2: Proteger por IP

```php
Route::get('/admin/bypass-login', function () {
    if (request()->ip() !== '123.45.67.89') {
        abort(404);
    }
    // ... resto del código
});
```

### Opción 3: Proteger con contraseña

```php
Route::get('/admin/bypass-login/{token}', function ($token) {
    if ($token !== env('ADMIN_BYPASS_TOKEN')) {
        abort(404);
    }
    // ... resto del código
});
```

---

## 📋 Resumen Rápido

| Paso | Comando | Resultado |
|------|---------|-----------|
| 1 | `git add routes/web.php` | Archivo listo para commit |
| 2 | `git commit -m "..."` | Cambios guardados |
| 3 | `git push origin main` | Enviado a GitHub |
| 4 | `git pull` (en host) | Recibido en Hostinger |
| 5 | Visita `/admin/bypass-login` | ✅ Logueado en admin |

---

## ⚡ TL;DR

```bash
# Paso 1: Local
git add routes/web.php && git commit -m "Admin bypass" && git push origin main

# Paso 2: Hostinger SSH
cd ~/domains/mobelsalejandro.shop/public_html && git pull origin main

# Paso 3: Navegador
https://mobelsalejandro.shop/admin/bypass-login
```

✅ **¡Acceso garantizado al admin!**
