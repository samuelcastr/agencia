## Indexado y Documentación del Código

Este índice describe la estructura jerárquica del sistema web de gestión de reservaciones, organizado según el patrón de diseño MVC y la segmentación por roles.

```
AGENCIA/
├── viajes/
│   ├── admi/                             # Módulo del Administrador (id_rol = 1)
│   │   ├── actualizar_usuario.php      # [C-Controlador/M-Modelo] Lógica para actualizar los datos de un usuario.
│   │   ├── agregar_usuario.php         # [C/M] Lógica para insertar un nuevo usuario.
│   │   ├── configuraciones.php         # [V-Vista/C] Interfaz para configuraciones generales del perfil.
│   │   ├── editar_usuario.php          # [V/C/M] Interfaz y lógica para mostrar y editar datos de un usuario específico.
│   │   ├── eliminar_usuario.php        # [C/M] Lógica para eliminar un usuario.
│   │   ├── estadisticas.html           # [V] Vista para mostrar métricas y estadísticas (Dashboard).
│   │   ├── estadisticas.js             # [J] Script JavaScript para manejar interacciones o carga dinámica de gráficos en estadisticas.html.
│   │   ├── index_admi.php              # [V/C] Dashboard o página principal del Administrador.
│   │   └── usuarios.php                # [V/C/M] Interfaz para listar y gestionar todos los usuarios del sistema.
│   │
│   ├── invitado/                         # Módulo del Cliente Invitado (id_rol = 3)
│   │   ├── destinos.php                # [V/C/M] Muestra la lista de destinos disponibles (provincias).
│   │   ├── panel_invitado.php          # [V/C] Dashboard o página principal para el cliente que accede como invitado.
│   │   ├── perfil_invitado.php         # [V/C/M] Interfaz para ver su información básica.
│   │   ├── reservar.php                # [V/C/M] Formulario y lógica para crear una nueva reserva de viaje.
│   │   └── reservas_invitado.php       # [V/C/M] Muestra el historial de reservaciones realizadas por el cliente invitado.
│   │
│   └── usuario/                          # Módulo del Usuario Registrado (id_rol = 2, Empleado/Cliente)
│       ├── agregar_provincia.php       # [C/M] Lógica para insertar un nuevo destino/provincia.
│       ├── agregar_reserva.php         # [C/M] Lógica para procesar y guardar una nueva reserva.
│       ├── configuracion_usuario.php   # [V/C] Interfaz para que el usuario o empleado ajuste su configuración personal.
│       ├── editar_provincia.php        # [V/C/M] Interfaz y lógica para modificar un destino/provincia existente.
│       ├── editar_reserva.php          # [V/C/M] Interfaz y lógica para modificar una reserva (clave para el rol Empleado).
│       ├── eliminar_provincia.php      # [C/M] Lógica para eliminar un destino/provincia.
│       ├── eliminar_reserva.php        # [C/M] Lógica para eliminar una reserva.
│       ├── panel_usuario.php           # [V/C] Dashboard o página principal del usuario registrado/Empleado.
│       ├── provincias.php              # [V/C/M] Interfaz para listar y gestionar los destinos/provincias.
│       └── reservas.php                # [V/C/M] Interfaz para listar todas las reservas (clave para el rol Empleado).
│
├── php/                                  # Archivos de Lógica y Núcleo del Sistema (Modelos y Controladores Centrales)
│   ├── actualizar_configuracion.php    # [C/M] Lógica para actualizar la configuración general del sistema.
│   ├── conexion.php                    # [M] Script fundamental para establecer la conexión a la base de datos (MySQL).
│   ├── login.php                       # [C/M] Lógica que procesa la autenticación de usuarios y gestión de sesiones.
│   ├── obtener_estadisticas.php        # [M/C] Script que consulta y prepara datos para las estadísticas (usado por estadisticas.js).
│   └── registrar.php                   # [C/M] Lógica que procesa el formulario de registro y crea nuevos usuarios en la BD.
│
├── almacen.sql                           # Script de la base de datos (DDL y DML) con la estructura de tablas y datos iniciales.
├── index.html                            # [V] Página de aterrizaje o landing page principal del proyecto.
├── inicio_registro.html                  # [V] Interfaz que contiene los formularios de inicio de sesión y registro.
├── indexado.md                           # El presente documento de indexado.
└── README.md                             # Documentación general del proyecto.
```