# Product Backlog — Sistema Integral de Gestión de Proyección Social (SIGPS)

## Convenciones

La estructura utilizada será:

> Épica → Historia de Usuario → Tareas

### Story Points

| Story Points | Interpretación |
|---:|---|
| 1 | Muy pequeña |
| 2 | Pequeña |
| 3 | Baja |
| 5 | Media |
| 8 | Alta |
| 13 | Muy alta; considerar dividirla |

> [!important]
> Los Story Points se estiman sobre la **Historia de Usuario**, no sobre cada tarea.
>
> Las tareas pueden asignarse posteriormente a los integrantes durante el Sprint Planning.
>
> Los responsables se dejan inicialmente como `Por asignar`.

---

# SISTEMA 1 — SISTEMA INTERNO DE PROYECCIÓN SOCIAL

Sistema utilizado principalmente por el personal de la Unidad de Proyección Social.

Roles principales:

- Administrador.
- Auxiliar de Horas Sociales.

---

# ÉPICA INT-E01 — Infraestructura y persistencia de datos

## INT-HT-01 — Diseñar la estructura de datos del sistema

**Historia técnica**

Como equipo de desarrollo, necesitamos una estructura de datos normalizada que permita almacenar la información del sistema de manera consistente y mantener sus relaciones e historial.

**Story Points:** 8

### Tareas

- [ ] `INT-HT-01-T01` Diseñar el modelo entidad-relación.
  - Responsable: Por asignar
- [ ] `INT-HT-01-T02` Elaborar el diccionario de datos.
  - Responsable: Por asignar
- [ ] `INT-HT-01-T03` Crear las entidades principales del sistema.
  - Responsable: Por asignar
- [ ] `INT-HT-01-T04` Definir claves primarias y foráneas.
  - Responsable: Por asignar
- [ ] `INT-HT-01-T05` Crear migraciones o scripts iniciales.
  - Responsable: Por asignar
- [ ] `INT-HT-01-T06` Crear datos iniciales para pruebas.
  - Responsable: Por asignar

---

# ÉPICA INT-E02 — Autenticación y usuarios internos

## INT-HU-01 — Iniciar sesión

Como administrador o auxiliar de horas sociales, quiero iniciar sesión en el sistema para acceder únicamente a las funciones correspondientes a mi usuario.

**Story Points:** 5

### Tareas

- [ ] `INT-HU-01-T01` Diseñar la pantalla de inicio de sesión.
- [ ] `INT-HU-01-T02` Crear formulario de credenciales.
- [ ] `INT-HU-01-T03` Implementar validación de credenciales.
- [ ] `INT-HU-01-T04` Implementar manejo de sesión.
- [ ] `INT-HU-01-T05` Implementar cierre de sesión.
- [ ] `INT-HU-01-T06` Proteger las rutas privadas.
- [ ] `INT-HU-01-T07` Realizar pruebas de autenticación.

---

## INT-HU-02 — Gestionar usuarios internos

Como administrador, quiero crear, modificar, activar o desactivar usuarios internos para controlar quién puede acceder al sistema.

**Story Points:** 5

### Tareas

- [ ] `INT-HU-02-T01` Diseñar pantalla de usuarios.
- [ ] `INT-HU-02-T02` Crear formulario de registro.
- [ ] `INT-HU-02-T03` Implementar creación de usuarios.
- [ ] `INT-HU-02-T04` Implementar modificación de usuarios.
- [ ] `INT-HU-02-T05` Implementar activación y desactivación.
- [ ] `INT-HU-02-T06` Asignar rol Administrador o Auxiliar.
- [ ] `INT-HU-02-T07` Realizar pruebas de permisos.

---

# ÉPICA INT-E03 — Gestión de estudiantes

## INT-HU-03 — Consultar estudiantes

Como auxiliar de horas sociales, quiero consultar los estudiantes registrados para conocer su información y situación dentro del proceso de servicio social.

**Story Points:** 3

### Tareas

- [ ] `INT-HU-03-T01` Diseñar listado de estudiantes.
- [ ] `INT-HU-03-T02` Implementar consulta de estudiantes.
- [ ] `INT-HU-03-T03` Mostrar información relevante del estudiante.
- [ ] `INT-HU-03-T04` Crear vista de detalle.
- [ ] `INT-HU-03-T05` Realizar pruebas.

---

## INT-HU-04 — Buscar y filtrar estudiantes

Como auxiliar de horas sociales, quiero buscar estudiantes por carnet, nombre, fecha o área de conocimiento para encontrar rápidamente la información que necesito.

**Story Points:** 5

### Tareas

- [ ] `INT-HU-04-T01` Diseñar componente de búsqueda.
- [ ] `INT-HU-04-T02` Implementar búsqueda por carnet.
- [ ] `INT-HU-04-T03` Implementar búsqueda por nombre.
- [ ] `INT-HU-04-T04` Implementar filtro por rango de fechas.
- [ ] `INT-HU-04-T05` Implementar filtro por área de conocimiento.
- [ ] `INT-HU-04-T06` Permitir combinar diferentes filtros.
- [ ] `INT-HU-04-T07` Realizar pruebas.

---

# ÉPICA INT-E04 — Gestión de proyectos

## INT-HU-05 — Registrar proyecto

Como auxiliar de horas sociales, quiero registrar un proyecto para iniciar su seguimiento dentro del sistema.

**Story Points:** 5

### Tareas

- [ ] `INT-HU-05-T01` Definir datos obligatorios del proyecto.
- [ ] `INT-HU-05-T02` Diseñar formulario de registro.
- [ ] `INT-HU-05-T03` Implementar validaciones.
- [ ] `INT-HU-05-T04` Implementar registro en base de datos.
- [ ] `INT-HU-05-T05` Crear vista de detalle.
- [ ] `INT-HU-05-T06` Realizar pruebas.

---

## INT-HU-06 — Asociar estudiantes a un proyecto

Como auxiliar, quiero asociar uno o varios estudiantes a un proyecto para registrar quiénes participan en él.

**Story Points:** 5

### Tareas

- [ ] `INT-HU-06-T01` Crear selector de estudiantes.
- [ ] `INT-HU-06-T02` Mostrar estudiantes disponibles.
- [ ] `INT-HU-06-T03` Implementar asociación estudiante-proyecto.
- [ ] `INT-HU-06-T04` Mostrar participantes del proyecto.
- [ ] `INT-HU-06-T05` Evitar asociaciones duplicadas.
- [ ] `INT-HU-06-T06` Realizar pruebas.

---

## INT-HU-07 — Modificar proyecto

Como auxiliar, quiero modificar la información permitida de un proyecto para mantener sus datos actualizados.

**Story Points:** 5

### Tareas

- [ ] `INT-HU-07-T01` Diseñar interfaz de edición.
- [ ] `INT-HU-07-T02` Definir campos modificables.
- [ ] `INT-HU-07-T03` Implementar actualización.
- [ ] `INT-HU-07-T04` Registrar modificaciones importantes.
- [ ] `INT-HU-07-T05` Realizar pruebas.

---

## INT-HU-08 — Identificar proyectos próximos a vencer

Como auxiliar, quiero visualizar los proyectos próximos a vencer para realizar seguimiento oportunamente.

**Story Points:** 5

### Tareas

- [ ] `INT-HU-08-T01` Definir la regla de "próximo a vencer".
- [ ] `INT-HU-08-T02` Consultar proyectos según fecha límite.
- [ ] `INT-HU-08-T03` Crear indicador visual.
- [ ] `INT-HU-08-T04` Crear listado de proyectos próximos a vencer.
- [ ] `INT-HU-08-T05` Realizar pruebas con fechas límite.

---

# ÉPICA INT-E05 — Ciclo de vida del proyecto

El ciclo general será:

**Inscripción → Anteproyecto → 50 % → Memoria → Certificación → Finalizado**

---

## INT-HU-09 — Gestionar inscripción

Como auxiliar, quiero registrar la inscripción de un proyecto para iniciar formalmente su ciclo de vida.

**Story Points:** 5

### Tareas

- [ ] `INT-HU-09-T01` Definir requisitos de inscripción.
- [ ] `INT-HU-09-T02` Implementar estado "Inscripción".
- [ ] `INT-HU-09-T03` Validar documentación requerida.
- [ ] `INT-HU-09-T04` Registrar aprobación.
- [ ] `INT-HU-09-T05` Registrar fecha de aprobación.
- [ ] `INT-HU-09-T06` Realizar pruebas.

---

## INT-HU-10 — Gestionar anteproyecto

Como auxiliar, quiero registrar la revisión del anteproyecto para permitir que el proyecto continúe con su ejecución.

**Story Points:** 5

### Tareas

- [ ] `INT-HU-10-T01` Implementar etapa de anteproyecto.
- [ ] `INT-HU-10-T02` Mostrar documentación correspondiente.
- [ ] `INT-HU-10-T03` Implementar aprobación.
- [ ] `INT-HU-10-T04` Implementar rechazo.
- [ ] `INT-HU-10-T05` Registrar observaciones.
- [ ] `INT-HU-10-T06` Realizar pruebas.

---

## INT-HU-11 — Gestionar avance del 50 %

Como auxiliar, quiero registrar que un proyecto ha alcanzado la etapa del 50 % para controlar su progreso.

**Story Points:** 5

### Tareas

- [ ] `INT-HU-11-T01` Implementar estado del 50 %.
- [ ] `INT-HU-11-T02` Definir documentos requeridos.
- [ ] `INT-HU-11-T03` Implementar aprobación.
- [ ] `INT-HU-11-T04` Implementar observaciones.
- [ ] `INT-HU-11-T05` Registrar fecha.
- [ ] `INT-HU-11-T06` Realizar pruebas.

---

## INT-HU-12 — Gestionar memoria final

Como auxiliar, quiero revisar y aprobar la memoria final para determinar si el proyecto puede continuar al proceso de certificación.

**Story Points:** 5

### Tareas

- [ ] `INT-HU-12-T01` Implementar recepción de memoria.
- [ ] `INT-HU-12-T02` Validar archivo.
- [ ] `INT-HU-12-T03` Permitir visualización o descarga.
- [ ] `INT-HU-12-T04` Implementar aprobación o rechazo.
- [ ] `INT-HU-12-T05` Registrar observaciones.
- [ ] `INT-HU-12-T06` Realizar pruebas.

---

## INT-HU-13 — Consultar historial del proyecto

Como usuario autorizado, quiero consultar las etapas y cambios realizados sobre un proyecto para mantener su trazabilidad.

**Story Points:** 5

### Tareas

- [ ] `INT-HU-13-T01` Crear modelo de historial.
- [ ] `INT-HU-13-T02` Registrar cambios de estado.
- [ ] `INT-HU-13-T03` Registrar usuario responsable.
- [ ] `INT-HU-13-T04` Registrar fecha y hora.
- [ ] `INT-HU-13-T05` Diseñar timeline del proyecto.
- [ ] `INT-HU-13-T06` Realizar pruebas.

---

# ÉPICA INT-E06 — Procesos extraordinarios

## INT-HU-14 — Retirar estudiante de un proyecto

Como auxiliar, quiero retirar un estudiante de un proyecto sin eliminar su historial para conservar la trazabilidad institucional.

**Story Points:** 5

### Tareas

- [ ] Crear formulario de retiro.
- [ ] Solicitar motivo.
- [ ] Actualizar relación estudiante-proyecto.
- [ ] Registrar responsable.
- [ ] Registrar evento en historial.
- [ ] Realizar pruebas.

---

## INT-HU-15 — Cancelar proyecto

Como usuario autorizado, quiero cancelar un proyecto indicando su motivo para registrar que no continuará su proceso.

**Story Points:** 5

### Tareas

- [ ] Crear estado "Cancelado".
- [ ] Diseñar formulario de cancelación.
- [ ] Solicitar motivo obligatorio.
- [ ] Aplicar permisos.
- [ ] Registrar cancelación en historial.
- [ ] Realizar pruebas.

---

## INT-HU-16 — Registrar ampliación de plazo

Como auxiliar autorizado, quiero ampliar la fecha límite de un proyecto cuando exista una autorización que lo permita.

**Story Points:** 5

### Tareas

- [ ] Crear formulario de ampliación.
- [ ] Registrar fecha anterior.
- [ ] Registrar nueva fecha.
- [ ] Registrar motivo.
- [ ] Asociar documento de respaldo cuando corresponda.
- [ ] Actualizar vencimiento.
- [ ] Registrar historial.

---

## INT-HU-17 — Registrar prórroga

Como auxiliar, quiero registrar una prórroga autorizada para extender excepcionalmente el plazo de un proyecto.

**Story Points:** 5

### Tareas

- [ ] Crear registro de prórroga.
- [ ] Diseñar formulario.
- [ ] Registrar resolución o autorización.
- [ ] Actualizar fecha límite.
- [ ] Registrar historial.
- [ ] Realizar pruebas.

---

# ÉPICA INT-E07 — Gestión documental

## INT-HU-18 — Gestionar documentos del proyecto

Como usuario autorizado, quiero consultar los documentos asociados a un proyecto para revisar su expediente digital desde un único lugar.

**Story Points:** 8

### Tareas

- [ ] Diseñar estructura documental.
- [ ] Implementar almacenamiento.
- [ ] Implementar carga de documentos.
- [ ] Implementar descarga.
- [ ] Categorizar documentos.
- [ ] Crear pantalla del expediente.
- [ ] Implementar validaciones.
- [ ] Realizar pruebas.

---

## INT-HU-19 — Incorporar memoria final

Como usuario autorizado, quiero incorporar la memoria final al expediente del proyecto para mantener completa su documentación.

**Story Points:** 5

### Tareas

- [ ] Crear componente de carga.
- [ ] Validar formato del archivo.
- [ ] Validar tamaño.
- [ ] Guardar documento.
- [ ] Asociar documento con proyecto.
- [ ] Realizar pruebas.

---

# ÉPICA INT-E08 — Áreas de conocimiento

## INT-HU-20 — Administrar áreas de conocimiento

Como administrador, quiero crear, modificar, activar o desactivar áreas de conocimiento para adaptar el sistema a las necesidades institucionales.

**Story Points:** 5

### Tareas

- [ ] Crear estructura de áreas.
- [ ] Crear pantalla de administración.
- [ ] Implementar creación.
- [ ] Implementar modificación.
- [ ] Implementar activación/desactivación.
- [ ] Mostrar áreas dinámicamente en formularios.
- [ ] Realizar pruebas.

---

## INT-HU-21 — Controlar cambios históricos de las áreas

Como administrador, quiero decidir si los cambios de un área afectan proyectos existentes o solamente proyectos futuros para conservar la integridad histórica.

**Story Points:** 8

### Tareas

- [ ] Diseñar estrategia de versionado.
- [ ] Almacenar versiones.
- [ ] Crear opción "Aplicar a proyectos existentes".
- [ ] Crear opción "Aplicar solamente a nuevos proyectos".
- [ ] Implementar actualización correspondiente.
- [ ] Validar integridad histórica.
- [ ] Realizar pruebas.

---

# ÉPICA INT-E09 — Certificación de horas sociales

## INT-HU-22 — Generar certificación

Como auxiliar de horas sociales, quiero generar la certificación de un estudiante que haya completado su proceso para acreditar sus horas sociales.

**Story Points:** 8

### Tareas

- [ ] Validar cumplimiento de requisitos.
- [ ] Diseñar plantilla de certificación.
- [ ] Generar documento.
- [ ] Generar código o número de certificación.
- [ ] Permitir impresión o descarga.
- [ ] Registrar certificación.
- [ ] Realizar pruebas.

---

## INT-HU-23 — Registrar entrega de certificación

Como auxiliar, quiero registrar cuándo se entregó una certificación para mantener control de las certificaciones emitidas.

**Story Points:** 3

### Tareas

- [ ] Crear acción "Registrar entrega".
- [ ] Registrar fecha.
- [ ] Registrar responsable.
- [ ] Cambiar estado de certificación.
- [ ] Mostrar historial de entrega.
- [ ] Realizar pruebas.

---

## INT-HU-24 — Consultar estadísticas de certificaciones

Como usuario autorizado, quiero consultar estadísticas de las certificaciones entregadas para analizar el trabajo realizado por Proyección Social.

**Story Points:** 8

### Debe permitir filtrar por

- Mes.
- Año.
- Fecha específica.
- Rango de fechas.
- Área de conocimiento.

### Tareas

- [ ] Crear consultas estadísticas.
- [ ] Implementar filtros.
- [ ] Crear endpoint o servicio estadístico.
- [ ] Crear tarjetas resumen.
- [ ] Crear tablas o gráficos.
- [ ] Realizar pruebas con diferentes períodos.

---

# ÉPICA INT-E10 — Gestión de plantillas

## INT-HU-25 — Administrar plantillas

Como administrador, quiero administrar las plantillas institucionales para mantener disponibles únicamente sus versiones vigentes.

**Story Points:** 8

### Tareas

- [ ] Crear almacenamiento de plantillas.
- [ ] Crear listado de plantillas.
- [ ] Implementar carga.
- [ ] Implementar actualización/reemplazo.
- [ ] Implementar activación/desactivación.
- [ ] Implementar versionado.
- [ ] Permitir descarga.
- [ ] Aplicar permisos.
- [ ] Realizar pruebas.

---

# SISTEMA 2 — COORDINADORES Y TUTORES

Usuarios principales:

- Coordinador.
- Tutor.

---

# ÉPICA COO-E01 — Acceso y permisos

## COO-HU-01 — Iniciar sesión según rol

Como tutor o coordinador, quiero iniciar sesión para acceder a las funcionalidades correspondientes a mi rol.

**Story Points:** 5

### Tareas

- [ ] Integrar autenticación.
- [ ] Incorporar roles Tutor y Coordinador.
- [ ] Definir permisos.
- [ ] Crear rutas protegidas.
- [ ] Realizar pruebas con cada rol.

---

## COO-HU-02 — Visualizar menú según rol

Como tutor o coordinador, quiero visualizar únicamente las opciones que corresponden a mi rol para evitar acceder a funcionalidades no autorizadas.

**Story Points:** 3

### Tareas

- [ ] Crear matriz rol-permiso.
- [ ] Diseñar menú.
- [ ] Mostrar opciones según rol.
- [ ] Proteger funcionalidades en frontend.
- [ ] Proteger funcionalidades en backend.
- [ ] Realizar pruebas.

---

# ÉPICA COO-E02 — Gestión de tutores

## COO-HU-03 — Asignar tutor

Como coordinador, quiero asignar un tutor a un estudiante o proyecto para definir quién será responsable de su seguimiento.

**Story Points:** 5

### Tareas

- [ ] Crear relación tutor-proyecto.
- [ ] Mostrar tutores disponibles.
- [ ] Crear selector.
- [ ] Implementar asignación.
- [ ] Registrar responsable y fecha.
- [ ] Realizar pruebas.

---

## COO-HU-04 — Reasignar tutor

Como coordinador, quiero cambiar el tutor asignado cuando sea necesario sin perder el historial de asignaciones anteriores.

**Story Points:** 5

### Tareas

- [x] Mostrar tutor actual.
- [x] Seleccionar nuevo tutor.
- [x] Registrar reasignación.
- [x] Conservar tutor anterior en historial.
- [x] Registrar fecha y responsable.
- [x] Realizar pruebas.

---

## COO-HU-05 — Consultar estudiantes asignados

Como tutor, quiero consultar los estudiantes y proyectos que tengo asignados para realizar su seguimiento.

**Story Points:** 3

### Tareas

- [ ] Diseñar listado.
- [ ] Consultar asignaciones del tutor autenticado.
- [ ] Mostrar información del estudiante.
- [ ] Mostrar proyecto y fase actual.
- [ ] Crear acceso al detalle.
- [ ] Realizar pruebas.

---

# ÉPICA COO-E03 — Revisión documental

## COO-HU-06 — Revisar documento como tutor

Como tutor, quiero revisar los documentos que tengo asignados para determinar si cumplen los requisitos correspondientes.

**Story Points:** 8

### Tareas

- [ ] Crear bandeja de documentos.
- [ ] Mostrar información del estudiante.
- [ ] Crear visor o descarga.
- [ ] Mostrar estado.
- [ ] Crear acciones de aprobación y rechazo.
- [ ] Registrar revisión.
- [ ] Realizar pruebas.

---

## COO-HU-07 — Aprobar o rechazar documento como tutor

Como tutor, quiero aprobar o rechazar documentos y registrar observaciones para informar el resultado de mi revisión.

**Story Points:** 5

### Tareas

- [ ] Implementar acción Aprobar.
- [ ] Implementar acción Rechazar.
- [ ] Crear campo de observaciones.
- [ ] Registrar tutor responsable.
- [ ] Registrar fecha.
- [ ] Actualizar estado.
- [ ] Realizar pruebas.

---

## COO-HU-08 — Revisar documento como coordinador

Como coordinador, quiero revisar los documentos previamente aprobados por el tutor para realizar la validación correspondiente.

**Story Points:** 5

### Tareas

- [ ] Crear bandeja del coordinador.
- [ ] Mostrar aprobación previa del tutor.
- [ ] Permitir visualizar documento.
- [ ] Mostrar historial.
- [ ] Crear acciones de aprobación/rechazo.
- [ ] Realizar pruebas.

---

## COO-HU-09 — Aprobar o rechazar documento como coordinador

Como coordinador, quiero aprobar o rechazar un documento para determinar si puede continuar hacia Proyección Social.

**Story Points:** 5

### Tareas

- [ ] Crear acción Aprobar.
- [ ] Crear acción Rechazar.
- [ ] Solicitar observaciones en caso de rechazo.
- [ ] Registrar coordinador responsable.
- [ ] Registrar fecha.
- [ ] Actualizar estado.
- [ ] Realizar pruebas.

---

## COO-HU-10 — Enviar documento aprobado a Proyección Social

Como sistema, quiero registrar que un documento fue aprobado por tutor y coordinador para continuar con el proceso institucional en Proyección Social.

**Story Points:** 5

### Tareas

- [ ] Validar aprobación del tutor.
- [ ] Validar aprobación del coordinador.
- [ ] Cambiar estado a "Enviado a Proyección Social".
- [ ] Registrar fecha.
- [ ] Registrar evento en historial.
- [ ] Realizar pruebas del flujo completo.

---

# ÉPICA COO-E04 — Seguimiento y trazabilidad

## COO-HU-11 — Consultar historial de revisiones

Como tutor o coordinador, quiero consultar el historial de un documento para conocer las acciones realizadas durante su proceso de revisión.

**Story Points:** 5

### Tareas

- [x] Crear modelo de auditoría.
- [x] Registrar aprobaciones.
- [x] Registrar rechazos.
- [x] Registrar observaciones.
- [x] Registrar usuario responsable.
- [x] Registrar fecha y hora.
- [x] Crear timeline visual.
- [x] Realizar pruebas.

---

# SISTEMA 3 — PORTAL ESTUDIANTIL DE DESCARGA DE FORMATOS

> [!important]
> Este sistema es público y autónomo.
>
> No requiere:
>
> - Inicio de sesión.
> - Registro de estudiantes.
> - Base de datos.
> - Carga de documentos.
> - Seguimiento individual de proyectos.
> - Integración directa con los Sistemas 1 y 2.

---

# ÉPICA ALU-E01 — Portal público y navegación

## ALU-HU-01 — Acceder al portal

Como estudiante, quiero acceder libremente al Portal Estudiantil para consultar los recursos disponibles sobre servicio social.

**Story Points:** 3

### Tareas

- [ ] Diseñar estructura general de la landing page.
- [ ] Crear encabezado institucional.
- [ ] Crear sección Hero.
- [ ] Incorporar identificación FMO-UES / UPS.
- [ ] Garantizar acceso sin autenticación.
- [ ] Realizar pruebas.

---

## ALU-HU-02 — Navegar por las secciones del portal

Como estudiante, quiero acceder rápidamente a las distintas secciones del portal para encontrar la información que necesito.

**Story Points:** 3

### Tareas

- [ ] Crear menú de navegación.
- [ ] Crear ancla hacia Formatos.
- [ ] Crear ancla hacia Información.
- [ ] Crear ancla hacia Guía.
- [ ] Crear ancla hacia Checklist.
- [ ] Adaptar navegación a dispositivos móviles.
- [ ] Realizar pruebas de navegación.

---

# ÉPICA ALU-E02 — Repositorio de formatos

## ALU-HU-03 — Consultar formatos disponibles

Como estudiante, quiero visualizar los formatos oficiales F1-F8 para identificar cuál necesito utilizar.

**Story Points:** 5

### Cada formato deberá mostrar

- Código.
- Nombre.
- Descripción.
- Versión vigente.
- Fecha de actualización.

### Tareas

- [ ] Diseñar componente visual de formato.
- [ ] Crear listado F1-F8.
- [ ] Agregar código.
- [ ] Agregar nombre y descripción.
- [ ] Agregar versión.
- [ ] Agregar fecha de actualización.
- [ ] Realizar pruebas responsivas.

---

## ALU-HU-04 — Descargar formato oficial

Como estudiante, quiero descargar directamente un formato oficial para utilizarlo en mi proceso de servicio social.

**Story Points:** 5

### Tareas

- [ ] Crear carpeta `source/`.
- [ ] Incorporar los archivos F1-F8.
- [ ] Crear botones de descarga.
- [ ] Configurar descarga directa.
- [ ] Validar correspondencia entre botón y archivo.
- [ ] Realizar pruebas.

---

## ALU-HU-05 — Utilizar un formato descargado

Como estudiante, quiero completar el formato descargado desde mi navegador para posteriormente imprimirlo o guardarlo como PDF.

**Story Points:** 5

### Tareas

- [ ] Crear formatos HTML autocontenidos.
- [ ] Incorporar estilos necesarios.
- [ ] Implementar campos editables.
- [ ] Implementar validaciones locales cuando corresponda.
- [ ] Verificar funcionamiento sin conexión.
- [ ] Verificar impresión.
- [ ] Verificar "Guardar como PDF".
- [ ] Realizar pruebas en diferentes navegadores.

---

# ÉPICA ALU-E03 — Información y guía del proceso

## ALU-HU-06 — Consultar requisitos y plazos

Como estudiante, quiero consultar los requisitos y plazos vigentes para saber qué debo cumplir durante mi servicio social.

**Story Points:** 3

### Tareas

- [ ] Crear sección de requisitos.
- [ ] Organizar requisitos por etapa.
- [ ] Crear sección de plazos.
- [ ] Mostrar fecha de última actualización.
- [ ] Verificar contenido con la información institucional disponible.

---

## ALU-HU-07 — Consultar guía del proceso

Como estudiante, quiero visualizar una guía paso a paso para comprender las etapas del proceso de servicio social.

**Story Points:** 5

### La guía deberá contemplar

1. Inscripción.
2. Ejecución.
3. Entrega de memoria.

### Tareas

- [ ] Diseñar componente de guía.
- [ ] Incorporar etapa de inscripción.
- [ ] Incorporar etapa de ejecución.
- [ ] Incorporar etapa de memoria.
- [ ] Diseñar navegación visual entre etapas.
- [ ] Realizar pruebas responsivas.

---

## ALU-HU-08 — Consultar preguntas frecuentes y contacto

Como estudiante, quiero consultar preguntas frecuentes y los datos de contacto de Proyección Social para resolver dudas sobre el proceso.

**Story Points:** 3

### Tareas

- [ ] Crear sección FAQ.
- [ ] Incorporar preguntas frecuentes.
- [ ] Crear sección de contacto.
- [ ] Incorporar datos oficiales disponibles.
- [ ] Mostrar fecha de actualización.
- [ ] Realizar pruebas.

---

# ÉPICA ALU-E04 — Checklist del expediente

## ALU-HU-09 — Utilizar checklist de documentos

Como estudiante, quiero utilizar un checklist para verificar que cuento con los documentos necesarios para preparar mi expediente.

**Story Points:** 3

### Tareas

- [ ] Definir elementos del checklist.
- [ ] Diseñar componente visual.
- [ ] Crear casillas de selección.
- [ ] Implementar marcado y desmarcado con JavaScript.
- [ ] Implementar opción para limpiar checklist.
- [ ] Realizar pruebas.

---

## ALU-HU-10 — Conservar temporalmente el checklist

Como estudiante, quiero conservar las selecciones realizadas durante mi sesión para evitar perder el progreso mientras navego por el portal.

**Story Points:** 3

### Tareas

- [ ] Implementar `sessionStorage`.
- [ ] Guardar estado de las casillas.
- [ ] Restaurar estado al navegar.
- [ ] Limpiar información al finalizar la sesión cuando corresponda.
- [ ] Realizar pruebas.

---

## ALU-HU-11 — Imprimir o descargar checklist

Como estudiante, quiero imprimir o descargar mi checklist para utilizarlo como guía mientras preparo mi expediente.

**Story Points:** 3

### Tareas

- [ ] Crear vista preparada para impresión.
- [ ] Implementar botón Imprimir.
- [ ] Generar archivo HTML autocontenido.
- [ ] Implementar descarga del HTML.
- [ ] Verificar funcionamiento local.
- [ ] Realizar pruebas.

---

# RESUMEN GENERAL DEL PRODUCT BACKLOG

## Sistema 1 — Sistema Interno de Proyección Social

| Épica | Descripción |
|---|---|
| INT-E01 | Infraestructura y persistencia |
| INT-E02 | Autenticación y usuarios internos |
| INT-E03 | Gestión de estudiantes |
| INT-E04 | Gestión de proyectos |
| INT-E05 | Ciclo de vida del proyecto |
| INT-E06 | Procesos extraordinarios |
| INT-E07 | Gestión documental |
| INT-E08 | Áreas de conocimiento |
| INT-E09 | Certificación de horas sociales |
| INT-E10 | Gestión de plantillas |

## Sistema 2 — Coordinadores y Tutores

| Épica | Descripción |
|---|---|
| COO-E01 | Acceso y permisos |
| COO-E02 | Gestión de tutores |
| COO-E03 | Revisión documental |
| COO-E04 | Seguimiento y trazabilidad |

## Sistema 3 — Portal Estudiantil

| Épica | Descripción |
|---|---|
| ALU-E01 | Portal público y navegación |
| ALU-E02 | Repositorio de formatos |
| ALU-E03 | Información y guía |
| ALU-E04 | Checklist del expediente |

---

# Flujo recomendado para el Sprint Planning

Durante el Sprint Planning se deberá seguir aproximadamente este orden:

1. Seleccionar las Historias de Usuario prioritarias del Product Backlog.
2. Definir el Sprint Goal.
3. Revisar los Story Points de las historias seleccionadas.
4. Confirmar que las historias puedan completarse durante el Sprint.
5. Revisar las tareas necesarias para completar cada historia.
6. Permitir que los integrantes del equipo tomen o acuerden las tareas.
7. Agregar el correo o responsable a cada tarea.
8. Mover las tareas seleccionadas al Sprint Backlog.

Ejemplo:

ÉPICA
└── INT-E04 — Gestión de proyectos
    └── INT-HU-05 — Registrar proyecto
        ├── T01 — Diseñar formulario
        ├── T02 — Implementar validaciones
        ├── T03 — Implementar backend
        ├── T04 — Guardar proyecto
        ├── T05 — Crear vista de detalle
        └── T06 — Realizar pruebas