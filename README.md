

## ✈️ Sistema de Gestión de Reservaciones de Viajes (Agencia)

### 📝 Descripción del Proyecto

Este proyecto es un sistema web robusto diseñado para la gestión de reservaciones de viajes para una empresa de turismo (aéreo/terrestre). La aplicación utiliza PHP en el backend, MySQL para la persistencia de datos y TailwindCSS para un diseño moderno y responsivo.

El sistema aplica tres niveles de seguridad mediante roles para controlar el acceso a las funcionalidades:

  * **Administrador:** Gestión total de usuarios, roles, viajes y auditoría de reservas.
  * **Usuario:** Gestión y consulta de reservaciones.
  * **Cliente (Usuario/Invitado):** Realización de reservaciones y consulta de sus propios viajes.

### 🚀 Características Principales

  * **Seguridad Basada en Roles:** Tres niveles de acceso definidos (`administrador`, `usuario`, `cliente invitado`).
  * **Autenticación Segura:** Módulos de registro (`registrar.php`) e inicio de sesión (`login.php`).
  * **Reservas de Viajes:** Funcionalidad para que los clientes creen nuevas reservas (`reservar.php`).
  * **Diseño Moderno:** Uso de **TailwindCSS** para las interfaces de usuario.

### 🛠️ Requisitos Técnicos

El proyecto ha sido desarrollado utilizando las siguientes tecnologías y herramientas:

| Categoría | Tecnología/Herramienta | Versión Requerida |
| :--- | :--- | :--- |
| **Lenguaje Backend** | PHP | 8.0+ |
| **Base de Datos** | MySQL |
| **Framework CSS** | TailwindCSS|
| **Servidor Local** | XAMPP   |
| **Control de Versiones** | Git / GitHub | [samuelcastr/agencia] |

### 📂 Estructura del Proyecto

El código fuente sigue una estructura lógica para mantener el patrón MVC y la separación por roles:

```
AGENCIA/
├── viajes/
│   ├── admi/                 # Lógica y Vistas del Administrador (CRUD Usuarios, etc.)
│   ├── invitado/             # Vistas y Lógica para Clientes Invitados (Reservar, Perfil)
│   └── usuario/              # Vistas y Lógica para Usuarios Registrados / Empleados
├── php/
│   ├── conexion.php          # Conexión a la base de datos
│   ├── login.php             # Lógica de inicio de sesión
│   ├── registrar.php         # Lógica de registro de nuevos usuarios
│   └── ...
├── index.html                # Punto de entrada y página principal
├── inicio_registro.html      # Página para Login/Registro
└── README.md
```

### Lista de chequeo


1	Diagrama entidad-relación (DER).	si			
2	Mockups y mapa de navegación diseñados.	si			
3	Diagrama de caso de uso elaborado.	si			
4	Código documentado e indexado.	si			
5	Interfaz moderna con TailwindCSS.	si			
6	Coherencia entre backend, frontend y BD.	si			
7	Aplicación de principios UX/UI (paleta, favicon, logo, imágenes libres).	si			
8	Mensajes de confirmación implementados (guardado, eliminado, etc).	si			
9	Archivo README.md (o LÉAME.md) completo.	si			
					
					
					
1	El sistema permite registro e inicio de sesión de usuarios.			si	
2	El cliente puede crear nuevas reservas de viaje.			si	
3	El usuario puede consultar y modificar reservas.			si	
4	El administrador gestiona viajes, usuarios y roles.			si	
5	Vistas diseñadas con TailwindCSS.			si	
					


### 👤 Autores

  * Samuel Castro Zuñiga
  * Cielo Alexandra Rodriguez Pardo 
