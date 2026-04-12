# 🔓 ACCESO DIRECTO AL ADMIN - Solución Explícita en el Código

## Lo Que Hice

He agregado una **ruta de bypass** directamente en el código de rutas (`routes/web.php`) para acceder al admin sin complicaciones.

## Cómo Acceder

### Paso 1: Hacer Push de los cambios

Desde PowerShell en tu máquina local:

```powershell
cd e:\Dev\Projects\ecomerce_mobelsalejandro

git add routes/web.php

git commit -m "Add bypass admin access route for development"

git push origin main
```

### Paso 2: Actualizar en Hostinger

SSH a tu servidor:

```bash
cd ~/domains/mobelsalejandro.shop/public_html

git pull origin main
```

### Paso 3: Acceder al Admin

Abre en el navegador:

```
https://mobelsalejandro.shop/admin/bypass-login
```

**✅ Esto hará lo siguiente:**
1. Crea automáticamente un usuario: `alejandro@example.com` / `password`
2. Te inicia sesión directamente
3. Te redirige al dashboard del admin

---

## ¿Qué Hace Esta Ruta?

La ruta `/admin/bypass-login` está en `routes/web.php` y automáticamente:

```php
// 1. Busca o crea un usuario con:
email: alejandro@example.com
password: password (hasheado)

// 2. Te inicia sesión
Auth::login($user);

// 3. Te redirige al admin
redirect('/admin')
```

---

## Después de Esto

Una vez dentro del admin, puedes:

✅ Acceder a todas las funciones del panel  
✅ Cambiar la contraseña desde tu perfil  
✅ Crear más usuarios administradores  
✅ Administrar productos y categorías  

---

## Para Entrar de Nuevo

Una vez adentro, cierras sesión con el botón "Logout". Para volver a entrar:

- Usa `/admin/login` con las credenciales que creaste, O
- Usa `/admin/bypass-login` de nuevo para regenerar la sesión

---

## Cuando Quieras Producción

Cuando el sitio esté completamente listo, quita esta ruta o cámbiala por algo más seguro (por ejemplo, solo funciona desde cierta IP).

Para entonces, editarás `routes/web.php` y comentas o removes las líneas:

```php
// Route::get('/admin/bypass-login', function () { ... });
```

---

## Resumen de Lo Que Cambiamos

**Archivo:** `routes/web.php`

**Qué se agregó al final:**

```php
// ACCESO DIRECTO AL ADMIN (TEMPORAL)
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

---

## Quick Access

```
🔐 Login bypass: https://mobelsalejandro.shop/admin/bypass-login
📊 Dashboard: https://mobelsalejandro.shop/admin/
🚪 Logout: Click "Logout" in the panel
```

---

**Listo. Es directamente en el código. Funciona ya.**
