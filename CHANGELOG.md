# 📋 Changelog

Todos los cambios notables de la API TechUniverse se documentan en este archivo.

El formato está basado en [Keep a Changelog](https://keepachangelog.com/es/1.0.0/).

---

## [1.1.0]

### ✨ Añadido
- Nuevo endpoint `GET /api/productos/count` que devuelve el total de productos registrados en la base de datos.
- Parámetro opcional `?sort` en `GET /api/productos` para ordenación dinámica:
  - `?sort=precio_asc` → productos más baratos primero
  - `?sort=precio_desc` → productos más caros primero
  - `?sort=novedad_asc` → productos más antiguos primero
  - `?sort=novedad_desc` → productos más nuevos primero

### 🔧 Cambiado
- El endpoint `GET /api/productos` ahora acepta el parámetro `?sort` sin romper el comportamiento por defecto (sin ordenación si no se envía).

---

## [1.0.0]

### ✨ Añadido

#### 🔧 Core del Backend
- CRUD completo para:
  - Productos  
  - Categorías  
  - Especificaciones técnicas  
  - Usuarios
- Relaciones entre entidades totalmente implementadas.
- Validación robusta en endpoints.
- Respuestas JSON estandarizadas.

#### 🔐 Autenticación y Seguridad
- Autenticación basada en tokens con **Laravel Sanctum**.
- Middleware de protección para rutas sensibles.

#### 🛒 Funcionalidades de E‑commerce
- Carrito de compra (Cesta)
- Wishlist (Lista de deseos)
- Gestión de stock y disponibilidad

#### 🧱 Panel de Administración
- Panel admin construido con **FilamentPHP**:
  - Gestión visual de productos, categorías, especificaciones y usuarios
  - Acceso restringido a administradores
  - Formularios y tablas dinámicas

#### 📘 Documentación API
- Documentación completa con **Swagger (OpenAPI 3.0)** usando L5‑Swagger.
- Endpoints documentados con ejemplos de request/response.
- Generación automática del archivo `api-docs.json`.
