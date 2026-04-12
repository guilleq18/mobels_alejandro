# Muebles Alejandro

Base inicial de ecommerce en Laravel 11 para una empresa especializada en muebles de melamina.

## Estado actual

- Proyecto Laravel 11 generado en esta carpeta.
- Home comercial personalizada para la marca.
- Modelos y migraciones base para `categories`, `products`, `orders` y `order_items`.
- Seed inicial con categorias y productos demo.
- Panel admin con login, CRUD de categorias y productos, y listado de presupuestos.
- Base local funcionando con SQLite para desarrollo.

## Stack actual

- Laravel 11
- PHP 8.4 portable local en `.tools/php/runtime`
- SQLite para desarrollo
- Blade Templates

## Puesta en marcha

Levantar el servidor local:

```powershell
.\.tools\php\runtime\php.exe artisan serve
```

Recrear la base con datos demo:

```powershell
.\.tools\php\runtime\php.exe artisan migrate:fresh --seed
```

Ejecutar tests:

```powershell
.\.tools\php\runtime\php.exe artisan test
```

## Acceso admin

- URL: `http://127.0.0.1:8000/admin/login`
- Usuario demo: `alejandro@example.com`
- Contrasena demo: `password`

## Notas

- `php` y `composer` quedaron preparados de forma portable dentro de `.tools`, sin depender de instalaciones globales.
- El proyecto arranca hoy con SQLite para facilitar desarrollo local.
- La carga de imagenes desde admin se guarda en `public/uploads`.
- Si queres, la siguiente iteracion puede enfocarse en carrito, checkout o gestion interna de presupuestos.
