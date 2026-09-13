# 🎬 GUION TÉCNICO DE EXPOSICIÓN - EXAMEN VENTASFIX

> **Asignatura:** Desarrollo de Software Web 1  
> **Estudiante:** Ain Cortés Catoni  
> **Caso de Estudio:** Modernización del Sistema Comercial VentasFix a Microservicios con Backoffice y API RESTful para ERP Softland  
> **Entorno:** Laravel 11 / PHP 8.4 / MySQL 8.0 / Laravel Herd (`http://ventasfix.test`)

---

## 📋 Entregables de Video Exigidos por la Rúbrica

| Video | Nombre Exacto del Archivo | Enfoque | Duración Máxima |
|---|---|---|:---:|
| **Video 1** | `ExF_Sistema_cortes_ain.mp4` | Arquitectura, Seguridad, Dashboard y Mantenedores Web | 10:00 min (Recomendado: 8:00) |
| **Video 2** | `EXF_API_cortes_ain.mp4` | API RESTful, Tokens Sanctum, Códigos HTTP y Postman | 10:00 min (Recomendado: 7:30) |

---

# 📹 VIDEO 1: Arquitectura y Backoffice Web (`ExF_Sistema_cortes_ain.mp4`)

### 🎯 Preparación previa antes de dar "Grabar":
- Tener abierto el navegador en `http://ventasfix.test/login`.
- Tener abierto el editor de código (VS Code / PHPStorm) con los archivos clave:
  - `routes/web.php`
  - `app/Services/SoftlandService.php`
  - `app/Services/ProductoService.php`
  - `app/Models/User.php`

---

### [00:00 - 01:30] Introducción, Stack y Patrón Arquitectónico
* **Qué mostrar en pantalla:** Editor de código mostrando el árbol de carpetas del proyecto y la pantalla de Login en el navegador.
* **Qué decir:**
  > "Estimado profesor, mi nombre es Ain Cortés Catoni y a continuación expongo la solución técnica desarrollada para el examen final de Desarrollo de Software Web 1, correspondiente a la modernización del sistema **VentasFix**.
  >
  > El desafío planteaba migrar el modelo monolítico tradicional hacia una **arquitectura desacoplada**, orientada a servicios, capaz de integrarse bidireccionalmente con el ERP empresarial Softland y suministrar un Backoffice administrativo intuitivo y seguro.
  >
  > El stack tecnológico implementado comprende:
  > - **Laravel 11** sobre **PHP 8.4** y motor relacional **MySQL 8.0** gestionado en entorno local con Laravel Herd.
  > - **Arquitectura MVC extendida mediante Capa de Servicios (`Service Layer Pattern`)**: esto desacopla la lógica de negocio de los controladores HTTP, favoreciendo el principio de responsabilidad única (SRP) y permitiendo que tanto las vistas web como los endpoints de la API consuman la misma lógica de negocio centralizada.
  > - **Frontend:** Blade, SCSS y JavaScript moderno empaquetados mediante **Vite 5**, basados en la plantilla corporativa **Approx**."

---

### [01:30 - 03:00] Seguridad, Autenticación y Cifrado
* **Qué mostrar en pantalla:** Archivo `app/Models/User.php`, la migración de usuarios, y luego iniciar sesión en el navegador con `admin@ventasfix.cl`.
* **Qué decir:**
  > "En el ámbito de la seguridad y el modelo de datos:
  > - La persistencia se gestiona a través de **migraciones de base de datos** y el ORM Eloquent.
  > - **Cifrado de contraseñas:** Siguiendo las directrices del encargo, ninguna contraseña se almacena en texto plano; todas están cifradas de forma unidireccional con el algoritmo **Bcrypt** mediante `Hash::make()`.
  > - **Validación de dominio:** Se restringió el acceso estrictamente a cuentas pertenecientes al dominio corporativo `@ventasfix.cl`.
  >
  > Procedo a iniciar sesión con el usuario administrador predeterminado `admin@ventasfix.cl` con contraseña `password123`. El sistema verifica el hash criptográfico, establece la sesión con protección contra ataques CSRF y nos redirige al panel principal."

---

### [03:00 - 04:30] Dashboard y Componente Reutilizable (ERP Softland)
* **Qué mostrar en pantalla:** Vista del Dashboard en `http://ventasfix.test/dashboard` y en el editor el archivo `app/Services/SoftlandService.php`.
* **Qué decir:**
  > "Ya dentro del Backoffice observamos el Dashboard:
  > 1. **Métricas en tiempo real:** Se muestran las tarjetas resumen con conteos dinámicos de Usuarios, Catálogo de Productos y Clientes Empresa, calculados eficientemente mediante agregaciones de Eloquent.
  > 2. **Componente Reutilizable con Servicio Externo:** Cumpliendo el criterio de la rúbrica sobre reutilización y consumo de servicios externos, diseñé la clase `SoftlandService`. Este servicio encapsula la lógica de sincronización con el ERP Softland, simulando endpoints de verificación de salud, latencia y sincronización de catálogo.
  > 3. En la barra superior y en el widget central podemos apreciar el badge de estado activo que reporta la conexión con el microservicio del ERP."

---

### [04:30 - 08:30] Demostración de Mantenedores CRUD y Reglas de Negocio
* **Qué mostrar en pantalla:** Navegar por cada uno de los 3 mantenedores y realizar operaciones en vivo.

#### 1. CRUD de Usuarios (`/usuarios`)
* **Qué decir:**
  > "En el módulo de Usuarios:
  > - Voy a crear un nuevo usuario. Noten que si intento ingresar un correo genérico como `vendedor@gmail.com`, el sistema intercepta el formulario y no lo permite, ya que el Form Request exige obligatoriamente el sufijo `@ventasfix.cl`.
  > - Ahora ingreso `mario.vendedor@ventasfix.cl`, selecciono rol de Vendedor y contraseña. El registro se almacena de inmediato en MySQL con su clave cifrada."

#### 2. CRUD de Productos (`/productos`)
* **Qué decir:**
  > "En el módulo de Productos observamos el cumplimiento de dos reglas de negocio críticas:
  > - **Regla Tributaria del 19% IVA:** Al abrir el modal de nuevo producto, implementé un listener reactivo en JavaScript. Si digito en el precio neto el valor `$100.000`, el sistema calcula automáticamente en pantalla el precio de venta en `$119.000`. Adicionalmente, el backend en `ProductoService` vuelve a calcular y auditar este 19% antes de persistir, evitando cualquier alteración por parte del cliente.
  > - **Semáforo de Inventario:** El sistema evalúa el `stock_actual` en función de los umbrales de stock mínimo, bajo y alto, desplegando insignias de color rojo y amarillo para aquellos artículos que requieren reabastecimiento urgente."

#### 3. CRUD de Clientes B2B (`/clientes`)
* **Qué decir:**
  > "En el módulo de Clientes gestionamos empresas comerciales B2B:
  > - Se valida que el RUT tributario sea único en el sistema.
  > - Se capturan razón social, giro/rubro comercial, teléfonos de contacto y dirección física.
  > - Las operaciones de actualización y baja lógica o física se procesan a través de `ClienteService`."

---

### [08:30 - 09:30] Cierre del Video 1
* **Qué decir:**
  > "Para finalizar este primer video, destacamos que la interfaz cuenta con soporte responsivo para dispositivos móviles y tablets con menú colapsable automático, soporte nativo de modo claro y oscuro, y un botón de cierre de sesión seguro por método POST.
  >
  > A continuación, en el Video 2, revisaremos exhaustivamente la API RESTful y el consumo mediante Postman."

---
---

# 📹 VIDEO 2: API RESTful, Tokens Sanctum y Postman (`EXF_API_cortes_ain.mp4`)

### 🎯 Preparación previa antes de dar "Grabar":
- Tener abierta la aplicación **Postman**.
- Importar la colección: `docs/VentasFix_API_Postman_Collection.json`.
- En Postman verificar que la colección tenga la variable `base_url = http://ventasfix.test/api/v1`.
- Tener la terminal abierta con el comando `php artisan test` listo para disparar.

---

### [00:00 - 01:30] Fundamentos de la API RESTful y Estándares
* **Qué mostrar en pantalla:** Postman con las carpetas de la colección y en el editor el archivo `routes/api.php`.
* **Qué decir:**
  > "Continuando con la evaluación, en este segundo video analizaremos la **API RESTful** de VentasFix diseñada para la integración con sistemas satélites y el ERP Softland.
  >
  > Principios arquitectónicos de nuestra API:
  > 1. **Versionamiento de API:** Todas las rutas residen bajo el prefijo `/api/v1/`, asegurando que futuras modificaciones no rompan los contratos de integración existentes.
  > 2. **Arquitectura Stateless con Laravel Sanctum:** A diferencia de la web, la API es sin estado; la autenticación se delega en **Bearer Tokens** emitidos en cada login exitoso.
  > 3. **Transformadores con API Resources:** Implementamos clases `JsonResource` (`UsuarioResource`, `ProductoResource`, `ClienteResource`) que serializan la salida en una estructura predecible y ocultan campos críticos como el hash del password.
  > 4. **Códigos de Estado HTTP Estándar:** La API implementa rigurosamente los códigos `200 OK`, `201 Created`, `401 Unauthorized`, `404 Not Found` y `422 Unprocessable Entity`."

---

### [01:30 - 03:00] Autenticación y Demostración del Código `401 Unauthorized`
* **Qué mostrar en pantalla:** Pestaña `0.2 Petición sin Token` y pestaña `0.1 Login Exitoso` en Postman.
* **Qué decir:**
  > "Comencemos demostrando la protección de acceso:
  >
  > **Prueba 1: Intento de acceso no autorizado (`401 Unauthorized`)**
  > - Ejecuto la petición `GET /api/v1/productos` sin cabecera de autorización.
  > - Al presionar Send, observamos que el middleware `auth:sanctum` intercepta la solicitud y retorna de inmediato el código **`401 Unauthorized`** con el mensaje `Unauthenticated`.
  >
  > **Prueba 2: Autenticación exitosa (`200 OK`) y emisión de token**
  > - Ahora invocamos `POST /api/v1/login` enviando las credenciales corporativas en JSON: `admin@ventasfix.cl` y su password.
  > - Al enviar, el servidor responde con **`200 OK`**, indicando 'Autenticación exitosa' y entregándonos el token Bearer generado por Sanctum.
  > - Además, la colección de Postman tiene un script de tests que captura y guarda automáticamente este token en la variable `{{token}}`, propagándolo a todos los endpoints protegidos."

---

### [03:00 - 06:00] Operaciones CRUD y Verificación de Códigos de Estado

#### 1. Consulta de Catálogo (`200 OK`)
* **Petición en Postman:** `2.1 Listar Todos los Productos`
* **Qué decir:**
  > "Con el Bearer token activo, ejecutamos `GET /api/v1/productos`. Recibimos un código **`200 OK`** con el arreglo de productos en formato JSON estandarizado por `ProductoResource`."

#### 2. Creación con regla de cálculo de 19% IVA (`201 Created`)
* **Petición en Postman:** `2.3 Crear Producto (201 Created)`
* **Qué decir:**
  > "Probamos la creación mediante `POST /api/v1/productos`. Enviamos los datos del producto: código, nombre y definimos un `precio_neto` de `$150.000`.
  > - Presionamos Send y vemos que el servidor responde con el código **`201 Created`**.
  > - En el JSON devuelto verificamos que el atributo `precio_venta` fue calculado por el backend exactamente en `$178.500`, lo que demuestra el cálculo automatizado del 19% de IVA."

#### 3. Validación de regla de negocio rechazada (`422 Unprocessable Entity`)
* **Petición en Postman:** `1.4 Rechazo de Dominio Fuera de @ventasfix.cl`
* **Qué decir:**
  > "Demostraremos ahora el manejo de errores de validación de negocio. En `POST /api/v1/usuarios` intentamos registrar un usuario con el correo `usuario.externo@gmail.com`.
  > - Al enviar, el Form Request valida la regla regex del dominio `@ventasfix.cl` y rechaza la inserción con el código HTTP **`422 Unprocessable Entity`**, devolviendo un JSON con la descripción exacta del error sin provocar fallas en el servidor."

#### 4. Recurso no encontrado (`404 Not Found`)
* **Petición en Postman:** `2.6 Consultar Producto Inexistente`
* **Qué decir:**
  > "Si realizamos una consulta por un ID que no existe, como `GET /api/v1/productos/9999`, la API responde con el código **`404 Not Found`**, capturando la excepción `ModelNotFoundException` de Eloquent."

#### 5. Eliminación de recurso (`200 OK`)
* **Petición en Postman:** `3.5 Eliminar Cliente por ID`
* **Qué decir:**
  > "Finalmente, en el módulo de clientes ejecutamos `DELETE /api/v1/clientes/2`. El servidor procesa la baja y confirma la operación con el código **`200 OK`** y el mensaje de éxito."

---

### [06:00 - 07:30] Suite de Pruebas Automatizadas y Cierre
* **Qué mostrar en pantalla:** Abrir la terminal y ejecutar `php artisan test`.
* **Qué decir:**
  > "Para certificar la robustez y calidad del software, creamos una **suite de pruebas automatizadas de integración** con PHPUnit / Pest en `tests/Feature/VentasFixApiTest.php`.
  >
  > Ejecuto el comando:
  > ```bash
  > php artisan test
  > ```
  > *(Dejar que corran y se vean los 8 tests en verde en pantalla)*
  >
  > Como se aprecia en la consola, **las 8 pruebas pasan satisfactoriamente con 20 aserciones**, validando el login, la protección 401, el cálculo de IVA 201 y el rechazo 422.
  >
  > Con esto demostramos el cumplimiento total de los requisitos de arquitectura, patrones de diseño, componentes reutilizables, códigos HTTP y seguridad estipulados en la rúbrica.
  >
  > Muchas gracias."

---

## 🧭 Resumen Rápido de Códigos HTTP para el Video

| Código HTTP | Significado | En qué Endpoint Demostrarlo en Postman |
|:---:|---|---|
| **200** | OK | `GET /api/v1/productos` o `POST /api/v1/login` |
| **201** | Created | `POST /api/v1/productos` (destacar cálculo de 19% IVA) |
| **401** | Unauthorized | `GET /api/v1/productos` (sin token) o login con clave errónea |
| **404** | Not Found | `GET /api/v1/productos/9999` (ID inexistente) |
| **422** | Unprocessable Entity | `POST /api/v1/usuarios` (correo con `@gmail.com`) |
