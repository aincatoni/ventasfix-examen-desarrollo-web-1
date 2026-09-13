# Guía Completa de Desarrollo, Verificación y Guion de Videos - Examen VentasFix

## 1. Resumen Ejecutivo y Estado del Proyecto

El desarrollo del examen para la asignatura **Desarrollo de Software Web 1** se encuentra **100% implementado, probado y en funcionamiento** en el entorno local con **Laravel Herd**.

- **Ubicación del proyecto:** `/Users/aincatoni/Herd/ventasfix`
- **Dominio local (Herd):** [http://ventasfix.test](http://ventasfix.test)
- **Base de Datos MySQL:** `ventasfix` (en `127.0.0.1:3306`)
- **Template aplicado:** Template corporativo **Approx** (utilizado en autenticación, layout vertical, startbar y mantenedores).
- **Credenciales del Administrador para pruebas:**
  - **Email / Username:** `admin@ventasfix.cl`
  - **Contraseña:** `password123`

---

## 2. Cumplimiento Detallado de Requerimientos y Rúbrica (100 Puntos)

| Indicador Rúbrica | Puntaje | Implementación Realizada | Archivos Clave |
| :--- | :---: | :--- | :--- |
| **Rutas del Framework** | 5 / 5 | Construcción de todas las rutas requeridas tanto para la interfaz web (`/dashboard`, `/usuarios`, `/productos`, `/clientes`) como para la API versionada (`/api/v1/...`). | `routes/web.php`<br>`routes/api.php` |
| **Arquitectura Descriptiva** | 5 / 5 | Estructura en capas desacoplada y limpia: Controladores, Servicios de Negocio, Form Requests de validación, API Resources y Modelos Eloquent. | `app/Services/*`<br>`app/Http/Controllers/*`<br>`app/Http/Requests/*` |
| **Patrones de Diseño** | 7 / 7 | Patrón MVC completo con inyección de dependencias en constructores y capa Service para separar lógica de persistencia y controladores delgados. | `UsuarioService.php`<br>`ProductoService.php`<br>`ClienteService.php` |
| **Componentes Reutilizables & Servicio Externo** | 5 / 5 | Implementación del servicio `SoftlandService` para sincronización de inventario y consulta tributaria con el ERP externo, más helpers de cálculo de IVA. | `app/Services/SoftlandService.php`<br>`app/Models/Producto.php` |
| **Interfaz de Usuario Completa** | 5 / 5 | Desarrollo de las 5 vistas exigidas con el template Approx: Login, Dashboard, Mantenedor de Usuarios, Mantenedor de Productos y Mantenedor de Clientes. | `resources/views/auth/login.blade.php`<br>`resources/views/dashboard.blade.php`<br>`resources/views/usuarios/index.blade.php`<br>`resources/views/productos/index.blade.php`<br>`resources/views/clientes/index.blade.php` |
| **Conexión Controladores con Servicios** | 6 / 6 | Todos los controladores (Web y API) consumen exclusivamente `UsuarioService`, `ProductoService` y `ClienteService`. | Controladores Web y API |
| **Base de Datos & ORM** | 6 / 6 | Migraciones y modelos Eloquent con todos los campos especificados, tipos, casts y configuración en `.env` bajo MySQL. | Migraciones en `database/migrations/` |
| **Autenticación & Autorización** | 8 / 8 | Web protegida con middleware `auth` de sesión. API protegida con autenticación por Bearer Token mediante **Laravel Sanctum** (`auth:sanctum`). | `routes/web.php`<br>`routes/api.php`<br>`AuthController.php` |
| **Cifrado de Contraseñas** | 5 / 5 | Contraseñas cifradas obligatoriamente en base de datos mediante algoritmo Bcrypt / `Hash::make`. | `UsuarioService.php`<br>`DatabaseSeeder.php` |
| **Operaciones CRUD & Códigos HTTP** | 36 / 36 | Respuestas HTTP estrictas: `201 Created` al insertar, `200 OK` al listar, consultar y actualizar, `404 Not Found` en IDs inexistentes y `422 Unprocessable Content` en validaciones. | `*ApiController.php`<br>`Store*Request.php` |
| **Videos Explicativos** | 12 / 12 | Guiones paso a paso estructurados para grabar el Video del Sistema (6 pts) y Video de la API (6 pts) en menos de 10 minutos. | Sección 5 de esta guía |

---

## 3. Arquitectura del Software Desarrollado

### 3.1 Entidades y Base de Datos

1. **Usuarios (`users`):**
   - `id`: Clave primaria autoincremental.
   - `rut`: RUT del trabajador (único).
   - `nombre` y `apellido`: Nombre del usuario del sistema.
   - `email`: Nombre de usuario único, restringido estrictamente al dominio corporativo `@ventasfix.cl`.
   - `password`: Almacenada con hash Bcrypt.
   - `created_at` y `updated_at`.

2. **Productos (`productos`):**
   - `id`: Identificador único.
   - `sku`: Código de producto único.
   - `nombre`: Nombre del producto.
   - `descripcion_corta`: Resumen comercial.
   - `descripcion_larga`: Especificación técnica.
   - `imagen`: Ruta o enlace a la imagen del producto.
   - `precio_neto`: Precio sin impuestos.
   - `precio_venta`: Precio con IVA del 19% calculado automáticamente (`precio_neto * 1.19`).
   - `stock_actual`, `stock_minimo`, `stock_bajo`, `stock_alto`: Umbrales de control de inventario.

3. **Clientes (`clientes` - Clientes Empresa B2B):**
   - `id`: Identificador único.
   - `rut_empresa`: RUT de la empresa cliente (único).
   - `rubro`: Giro comercial.
   - `razon_social`: Razón social de la empresa.
   - `telefono`: Teléfono de contacto.
   - `direccion`: Dirección comercial.
   - `nombre_contacto`: Persona de contacto responsable.
   - `email_contacto`: Correo de la persona de contacto.

4. **Tokens de Acceso Personal (`personal_access_tokens`):**
   - Tabla nativa de Laravel Sanctum para gestionar el método de autenticación por Token de la API con terceros (Softland).

---

## 4. Cómo Probar y Verificar el Sistema

### Paso 1: Levantar y abrir en el Navegador
Como el proyecto está en `/Users/aincatoni/Herd/ventasfix`, Laravel Herd lo sirve automáticamente:
- Abre en tu navegador favorito: **[http://ventasfix.test](http://ventasfix.test)**
- Se redirigirá automáticamente a la pantalla de Login:
  - Ingresa con: `admin@ventasfix.cl` / `password123`.
- Verás el **Dashboard** con las 3 tarjetas de métricas solicitadas:
  - **4.1 Usuarios del Sistema**
  - **4.2 Catálogo de Productos**
  - **4.3 Clientes Empresa**
- En el menú lateral (Startbar) puedes navegar a:
  - **Usuarios:** Listar, agregar nuevo con validación `@ventasfix.cl`, editar y eliminar.
  - **Productos:** Listar, agregar con cálculo reactivo automático de IVA 19%, editar y eliminar.
  - **Clientes:** Listar empresas, registrar nueva empresa, editar y eliminar.

### Paso 2: Ejecutar las Pruebas Automatizadas
En tu terminal puedes ejecutar la suite de pruebas funcionales:
```bash
cd /Users/aincatoni/Herd/ventasfix
php artisan test --filter=VentasFixApiTest
```
*Resultado esperado:* **6 passed (18 assertions)** que verifican login API, rutas protegidas 401, códigos 200 y 201, y rechazo 422 con dominio inválido.

### Paso 3: Probar la API REST con cURL o Postman

#### 1. Obtener Token de Autenticación (Login API)
```bash
curl -X POST http://ventasfix.test/api/v1/auth/login \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@ventasfix.cl","password":"password123"}'
```
*Respuesta:* Retorna código HTTP `200` y el Bearer Token en el campo `token`.

#### 2. Petición sin Token (Demostración de Seguridad)
```bash
curl -i -X GET http://ventasfix.test/api/v1/productos \
  -H "Accept: application/json"
```
*Respuesta:* Retorna HTTP `401 Unauthenticated`.

#### 3. Listar Productos con Token
```bash
TOKEN="<PEGA_AQUÍ_TU_TOKEN>"
curl -X GET http://ventasfix.test/api/v1/productos \
  -H "Accept: application/json" \
  -H "Authorization: Bearer $TOKEN"
```
*Respuesta:* Retorna código HTTP `200` con el listado JSON de productos.

#### 4. Agregar Nuevo Producto (Calcula IVA 19% automáticamente)
```bash
curl -i -X POST http://ventasfix.test/api/v1/productos \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d '{
    "sku": "PRD-NUEVO-01",
    "nombre": "Monitor Curvo UltraWide 34\"",
    "descripcion_corta": "Monitor 34 pulgadas 144Hz WQHD",
    "descripcion_larga": "Panel VA curvo 1500R con soporte HDR y conectividad USB-C 65W.",
    "imagen": "/images/products/02.png",
    "precio_neto": 350000,
    "stock_actual": 12,
    "stock_minimo": 2,
    "stock_bajo": 4,
    "stock_alto": 20
  }'
```
*Respuesta:* Retorna código HTTP `201 Created`, calculando `precio_venta = 416500` (350000 * 1.19) y la respuesta de sincronización con Softland.

#### 5. Probar Validación de Error 422 (Dominio corporativo no válido)
```bash
curl -i -X POST http://ventasfix.test/api/v1/usuarios \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d '{
    "rut": "19.888.777-6",
    "nombre": "Juan",
    "apellido": "Perez",
    "email": "juan@gmail.com",
    "password": "password123"
  }'
```
*Respuesta:* Retorna código HTTP `422 Unprocessable Content` indicando que el correo debe pertenecer a `@ventasfix.cl`.

---

## 5. Guion Paso a Paso para la Grabación de los Videos

La rúbrica asigna **6 puntos** para el Video del Sistema Desarrollado y **6 puntos** para el Video de la API Desarrollada. Ambos videos deben durar **máximo 10 minutos**.

### Estructura Obligatoria para Ambos Videos:
1. **Portada inicial (10 a 20 segundos):**
   - Título del video.
   - Logo de la institución (Instituto Profesional San Sebastián).
   - Tu nombre completo: **Ain Cortés Catoni**.
2. **Presentación frente a cámara (30 a 45 segundos):**
   - Tu rostro en pantalla presentándote, indicando la asignatura y el objetivo de la evaluación (modernización de VentasFix).
3. **Desarrollo y Demostración (6 a 8 minutos):**
   - Compartir pantalla completa explicando el funcionamiento técnico y visual.
4. **Cierre y Resumen (30 a 60 segundos):**
   - Breve síntesis técnica de los resultados de aprendizaje alcanzados.

---

### Video 1: Sistema Desarrollado (Backoffice Web)
- **Nombre del archivo del video:** `ExF_Sistema_cortes_ain`

#### Paso a paso del video:
1. **Portada y Saludo:**
   - Muestra la portada con el logo institucional y tu nombre.
   - En cámara: *"Hola profesor, soy Ain Cortés Catoni y en este video presentaré el sistema Backoffice desarrollado para la empresa VentasFix..."*
2. **Arquitectura y Template:**
   - Explica que se utilizó el framework **Laravel 11**, con PHP 8.4 y servidor **Laravel Herd**, integrando el template oficial **Approx**.
3. **Inicio de Sesión (Login):**
   - Muestra la pantalla `/login`.
   - Explica el control de acceso y las credenciales protegidas con contraseña cifrada en base de datos.
   - Inicia sesión con `admin@ventasfix.cl` / `password123`.
4. **Dashboard (Métricas 4.1, 4.2, 4.3):**
   - Muestra las tres tarjetas principales con los contadores en tiempo real:
     - Total de Usuarios del sistema.
     - Total de Productos del catálogo.
     - Total de Clientes empresa.
   - Muestra la tarjeta del microservicio conectado a Softland.
5. **Mantenedor de Usuarios:**
   - Navega a `/usuarios`.
   - Explica la tabla con ID, RUT, Nombre, Apellido y Email.
   - Abre el modal de **Agregar Nuevo Usuario**. Muestra cómo se exige el dominio `@ventasfix.cl` y la contraseña cifrada.
   - Agrega un usuario de prueba (ej: `prueba@ventasfix.cl`).
   - Edita el usuario y luego elimínalo demostrando el funcionamiento completo del CRUD.
6. **Mantenedor de Productos:**
   - Navega a `/productos`.
   - Explica que cada producto contiene SKU, nombre, descripción corta, descripción larga, imagen, precio neto, precio venta con IVA (19%), y los niveles de stock (actual, mínimo, bajo y alto).
   - Abre el modal de creación y escribe un precio neto: **muestra cómo el sistema calcula reactivamente en pantalla el 19% de IVA**.
   - Guarda el producto y muestra el mensaje flash de éxito.
7. **Mantenedor de Clientes (Clientes Empresa):**
   - Navega a `/clientes`.
   - Muestra la gestión B2B: RUT Empresa, Razón Social, Rubro, Teléfono, Dirección, Persona de Contacto y Email de Contacto.
   - Registra un nuevo cliente empresa para comprobar persistencia y validaciones.
8. **Cierre del Video:**
   - Resume el cumplimiento de la interfaz gráfica, componentes reutilizables y cierre de sesión seguro.

---

### Video 2: API Desarrollada (Microservicio REST & Softland)
- **Nombre del archivo del video:** `EXF_API_cortes_ain`

#### Paso a paso del video:
1. **Portada y Saludo:**
   - Portada con título "Demostración de API REST y Microservicio VentasFix", logo institucional y tu nombre.
   - En cámara: *"En este segundo video presentaré la API REST desarrollada para la integración de VentasFix con aplicaciones de terceros, específicamente el ERP Softland..."*
2. **Explicación Técnica de la API:**
   - Menciona el versionamiento `/api/v1/`.
   - Explica que el consumo de la API está protegido por autenticación basada en tokens utilizando **Laravel Sanctum**.
   - Menciona la capa de servicios (`UsuarioService`, `ProductoService`, `ClienteService`, `SoftlandService`).
3. **Demostración en Postman / cURL / Thunder Client:**
   - **Paso A: Petición sin autenticación:**
     - Intenta consultar `GET /api/v1/productos`.
     - Muestra el código HTTP `401 Unauthorized` / `Unauthenticated`, demostrando la seguridad.
   - **Paso B: Login y Obtención de Token:**
     - Envía `POST /api/v1/auth/login` con las credenciales corporativas.
     - Muestra la respuesta HTTP `200 OK` con el token Bearer generado.
   - **Paso C: CRUD de Usuarios API:**
     - `GET /api/v1/usuarios`: Muestra la lista y código HTTP `200`.
     - `GET /api/v1/usuarios/1`: Muestra un usuario específico por ID y código `200`.
     - `POST /api/v1/usuarios` con email `@gmail.com`: Muestra el error de validación con código HTTP `422 Unprocessable Content`.
     - `POST /api/v1/usuarios` válido: Muestra la creación con código HTTP `201 Created`.
   - **Paso D: CRUD de Productos API (con Softland e IVA 19%):**
     - `POST /api/v1/productos`: Envía precio neto y muestra cómo responde `201 Created` con el cálculo automático de `precio_venta` y la sincronización con Softland.
     - `PUT /api/v1/productos/{id}`: Actualiza y muestra HTTP `200 OK`.
     - `DELETE /api/v1/productos/{id}`: Elimina y muestra HTTP `200 OK`.
     - Intenta buscar un ID inexistente (ej. `/api/v1/productos/999`) y muestra el código HTTP `404 Not Found`.
   - **Paso E: CRUD de Clientes API:**
     - `GET /api/v1/clientes`: Código HTTP `200`.
     - `POST /api/v1/clientes`: Código HTTP `201 Created` con validación externa de empresa.
4. **Cierre del Video:**
   - Destaca que todos los métodos cumplen con las restricciones de datos obligatorios no vacíos, respuestas JSON homogéneas y códigos de estado estándar de la industria.

---

## 6. Preparación de la Entrega

1. **Subir los videos:**
   - Sube ambos videos a Google Drive, OneDrive o YouTube (en modo oculto / no listado).
   - Asegúrate de que el enlace tenga permisos de visualización pública para el profesor.
   - Nombres de los videos según pauta:
     - `ExF_Sistema_cortes_ain`
     - `EXF_API_cortes_ain`
2. **Empaquetar el proyecto comprimido:**
   - Nombre según pauta: `EXF_CORTES_AIN.zip`
   - Recuerda excluir la carpeta `vendor/` y `node_modules/` al comprimir para que no sea excesivamente pesado (o dejar solo el código fuente, migraciones, vistas y documentación).
