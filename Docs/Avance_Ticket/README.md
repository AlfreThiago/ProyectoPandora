# Avance de Proyecto - Módulo Ticket/Solicitud

Este documento presenta el avance del diseño funcional y dinámico del módulo de Ticket/Solicitud del proyecto "ProyectoPandora".

## 1. Objetivos del avance
- Evidenciar el diseño funcional mediante casos de uso.
- Mostrar el comportamiento dinámico con diagramas de secuencia.
- Documentar reglas de negocio, roles, estados y validaciones.

## 2. Alcance
Incluye los procesos: creación de ticket, listado y visualización, asignación de técnico, gestión de estados, solicitud de repuestos y cierre del ticket.

## 3. Actores
- Cliente: crea y consulta tickets de sus dispositivos.
- Supervisor: administra asignación de técnicos, inventario y seguimiento.
- Técnico: gestiona sus tickets asignados y solicita repuestos.
- Sistema de Autenticación: valida credenciales y roles.

## 4. Estados del Ticket
- Abierto (creado)
- Asignado (tiene técnico y supervisor)
- En reparación (trabajo en curso)
- En espera de repuesto (si aplica)
- Resuelto / Cerrado

## 5. Reglas y Validaciones Clave
- Un ticket se crea con estado inicial "Abierto".
- Un ticket asignado debe registrar `tecnico_id` y `supervisor_id`.
- Solicitudes de repuestos sólo para tickets asignados al técnico solicitante.
- Reducción de stock al registrar la solicitud de repuesto; se valida stock disponible.
- Historial de acciones: crear, asignar técnico/supervisor, mover estado, solicitar repuestos, cerrar.
 - La disponibilidad del técnico (Disponible/Ocupado) la gestiona el propio técnico desde su perfil; no cambia automáticamente al asignar tickets.

## 6. Casos de Uso (resumen)
- UC01 Crear Ticket (Cliente)
- UC02 Listar/Ver Ticket (Cliente)
- UC03 Gestionar Tickets (Supervisor)
- UC04 Asignar Técnico (Supervisor)
- UC05 Cambiar Estado (Supervisor/Técnico)
- UC06 Ver Tickets Asignados (Técnico)
- UC07 Solicitar Repuesto (Técnico
- UC08 Cerrar Ticket (Supervisor/Técnico)

Ver planillas detalladas y diagramas en `diagramas/` y `planillas/`.

## 7. Trazabilidad con Código
- Controladores: `Controllers/TicketController.php`, `SupervisorController.php`, `TecnicoController.php`, `InventarioController.php`.
- Modelos: `Models/Ticket.php`, `Models/ItemTicket.php`, `Models/Inventario.php`.
- Vistas: `Views/Ticket/*`, `Views/Supervisor/*`, `Views/Tecnicos/MisRepuestos.php`.