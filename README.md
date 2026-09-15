# VentasFix - Sistema Comercial y API REST para ERP

<p align="center">
  <img src="public/images/logo-sm.png" alt="VentasFix Logo" width="80" height="80">
</p>

<p align="center">
  <strong>Modernización del Sistema Comercial a Arquitectura de Microservicios con Backoffice y API RESTful</strong><br>
  <em>Examen Final - Desarrollo de Software Web 1</em><br>
  <strong>Estudiante:</strong> Ain Cortés Catoni
</p>

---

## 📌 Descripción del Proyecto

**VentasFix** es una solución integral diseñada para modernizar la gestión de ventas de la empresa mediante una arquitectura desacoplada. El sistema implementa:

1. **Backoffice Web Administrativo**: Panel de control con diseño corporativo basado en la plantilla Approx, que provee autenticación de usuarios, dashboard de métricas en tiempo real y mantenedores CRUD completos para **Usuarios**, **Productos** y **Clientes**.
2. **API RESTful de Integración**: Conjunto de endpoints protegidos por tokens **Laravel Sanctum** bajo la versión `/api/v1/`, diseñados para comunicar el sistema central con el ERP corporativo (**Softland**) y canales externos de comercio electrónico.
3. **Patrón de Arquitectura MVC + Capa de Servicios (`Service Layer`)**: Desacoplamiento total entre controladores y lógica de negocio mediante servicios reutilizables (`UsuarioService`, `ProductoService`, `ClienteService`, `SoftlandService`).
4. **Componente Reutilizable de ERP Externo**: Servicio de integración que simula la sincronización bidireccional de inventario y estado con Softland ERP.

---

## 🛠️ Tecnologías y Stack Utilizado

- **Backend**: PHP 8.3 / Laravel 11.x
- **Base de Datos**: MySQL 8.0 (ORM Eloquent, Migraciones y Seeders)
- **Frontend**: Blade, SCSS, JavaScript (ES6+), Bootstrap 5.3 (Approx Theme)
- **Compilador de Assets**: Vite 5
- **Autenticación**: Laravel Sanctum (Tokens Bearer para API) y sesiones web con cifrado Bcrypt
- **Entorno de Desarrollo**: Laravel Herd en macOS

---

## 🚀 Requisitos de Negocio Implementados

| Módulo | Reglas de Negocio Implementadas |
|---|---|
| **Usuarios** | Validación estricta de correo corporativo bajo el dominio `@ventasfix.cl`. Contraseñas cifradas mediante `Hash::make()` / `Bcrypt`. Asignación de roles (`administrador`, `vendedor`, `supervisor`). |
| **Productos** | Cálculo automático del 19% de IVA (`precio_venta = precio_neto * 1.19`). Control estricto de niveles de inventario (stock actual, stock mínimo, stock bajo y stock alto) con alertas visuales de reposición. |
| **Clientes** | Gestión de clientes empresa (B2B): validación de RUT chileno con formato único, razón social, rubro/giro comercial, teléfono de contacto y dirección física. |
| **API REST** | Respuestas estandarizadas en JSON utilizando API Resources. Autenticación Bearer Token con Sanctum. Manejo exhaustivo de códigos de estado HTTP (`200 OK`, `201 Created`, `401 Unauthorized`, `404 Not Found`, `422 Unprocessable Entity`). |

---

## 📂 Arquitectura del Proyecto

```text
ventasfix/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/V1/              # Controladores RESTful (Auth, Usuario, Producto, Cliente)
│   │   │   ├── Auth/                # Controladores de Sesión Web
│   │   │   └── ...                  # Controladores Web (Dashboard, CRUDs)
│   │   ├── Requests/                # Form Requests con reglas de validación
│   │   └── Resources/               # Transformadores JSON (API Resources)
│   ├── Models/                      # Modelos Eloquent (User, Producto, Cliente)
│   └── Services/                    # Capa de Servicios (Lógica de negocio y ERP Softland)
├── database/
│   ├── migrations/                  # Definición de esquemas de base de datos
│   └── seeders/                     # Poblado de datos iniciales
├── docs/                            # Colección Postman de integración
│   └── VentasFix_API_Postman_Collection.json
├── resources/
│   ├── views/                       # Vistas Blade (Auth, Dashboard, CRUDs)
│   ├── scss/                        # Estilos SCSS Approx
│   └── js/                          # Scripts y dependencias front-end
├── routes/
│   ├── api.php                      # Rutas de la API v1 protegidas con auth:sanctum
│   └── web.php                      # Rutas web del Backoffice protegidas con auth
└── tests/
    └── Feature/VentasFixApiTest.php # Pruebas automatizadas de integración
```

---

## ⚙️ Instalación y Puesta en Marcha

### 1. Clonar el repositorio
```bash
git clone git@github.com:aincatoni/ventasfix-examen-desarrollo-web-1.git
cd ventasfix-examen-desarrollo-web-1
```

### 2. Instalar dependencias de PHP y Node
```bash
composer install
npm install
npm run build
```

### 3. Configurar variables de entorno
```bash
cp .env.example .env
php artisan key:generate
```
Asegúrate de configurar los parámetros de base de datos en `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ventasfix
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Ejecutar migraciones y datos de prueba
```bash
php artisan migrate:fresh --seed
```

### 5. Iniciar el servidor
Si usas **Laravel Herd**, el sitio estará disponible de forma automática en:
👉 `http://ventasfix.test`

Si usas el servidor embebido de Artisan:
```bash
php artisan serve
```

---

## 🔑 Credenciales de Acceso

- **URL de Acceso**: `http://ventasfix.test/login`
- **Email**: `admin@ventasfix.cl`
- **Contraseña**: `password123`

---

## 📡 Endpoints de la API RESTful (`/api/v1/`)

### Autenticación
| Método | Endpoint | Descripción | Requiere Token |
|---|---|---|:---:|
| `POST` | `/api/v1/login` | Autenticación y obtención de Bearer Token | No |
| `POST` | `/api/v1/logout` | Revocación del token actual | Sí |
| `GET` | `/api/v1/me` | Datos del usuario autenticado | Sí |

### Módulos CRUD
| Recurso | Endpoints | Descripción |
|---|---|---|
| **Usuarios** | `GET/POST /api/v1/usuarios`<br>`GET/PUT/DELETE /api/v1/usuarios/{id}` | Gestión de usuarios corporativos (`@ventasfix.cl`) |
| **Productos** | `GET/POST /api/v1/productos`<br>`GET/PUT/DELETE /api/v1/productos/{id}` | Gestión de catálogo y cálculo de 19% IVA |
| **Clientes** | `GET/POST /api/v1/clientes`<br>`GET/PUT/DELETE /api/v1/clientes/{id}` | Gestión de empresas cliente B2B |

> **Colección Postman**: El archivo listo para importar se encuentra en [`docs/VentasFix_API_Postman_Collection.json`](docs/VentasFix_API_Postman_Collection.json).

---

## 🧪 Pruebas Automatizadas

El proyecto incluye una suite de pruebas para verificar el correcto funcionamiento de los endpoints, autenticación por tokens, cálculo de IVA y validaciones de dominio:

```bash
php artisan test
```

Resultados esperados:
- `✓ login con credenciales correctas retorna token sanctum (200)`
- `✓ login con credenciales invalidas retorna error 422`
- `✓ acceso a endpoints protegidos sin token retorna 401 unauthenticated`
- `✓ listar productos con token retorna codigo 200 y coleccion json`
- `✓ crear producto calcula precio venta con 19 porciento iva (201)`
- `✓ crear usuario con correo fuera de dominio @ventasfix.cl retorna 422`

---

## 📄 Licencia y Entrega Académica

Proyecto desarrollado por **Ain Cortés Catoni** como parte del examen de la asignatura **Desarrollo de Software Web 1** (2026). Todos los derechos reservados.
