# Avance de Proyecto - Módulo Ticket/Solicitud

Este documento presenta el avance del diseño funcional y dinámico del módulo de Ticket/Solicitud del proyecto "ProyectoPandora".

## 1. Objetivos del avance
- Evidenciar el diseño funcional mediante casos de uso.
- Mostrar el comportamiento dinámico con diagramas de secuencia.
- Documentar reglas de negocio, roles, estados y validaciones.

## 2. Alcance
Incluye: creación de ticket, visualización, asignación de técnico, flujo de presupuesto (definición de mano de obra, publicación y decisión del cliente), solicitud de repuestos, cambios de estado y cierre.

## 3. Actores
- Cliente: crea y consulta tickets de sus dispositivos.
- Supervisor: administra asignación de técnicos, inventario, publicación de presupuestos y seguimiento.
- Técnico: gestiona sus tickets asignados, realiza diagnóstico, define mano de obra y solicita repuestos.
- Sistema de Autenticación: valida credenciales y roles.

## 4. Estados del Ticket (máquina de estados)
- Nuevo: estado inicial.
- Diagnóstico: técnico analiza; aquí define mano de obra (una sola vez, inmutable luego).
- En espera: presupuesto listo para publicar (items + mano de obra listos).
- Presupuesto: supervisor publica; cliente revisa y decide.
- En reparación: tras aprobación del cliente, trabajo en curso.
- En pruebas: pruebas finales.
 - Listo para retirar: previo a la entrega.
- Finalizado: ticket concluido.
- Cancelado: si el cliente rechaza o por decisión administrativa

Transiciones permitidas (resumen):
- Nuevo → Diagnóstico | En espera | Cancelado
- Diagnóstico → Presupuesto | En espera
- Presupuesto → (sin cambios por técnico; supervisor publica y cliente decide)
- En espera → (sin cambios manuales; supervisor publica a Presupuesto)
- En reparación → En pruebas | Listo para retirar
- En pruebas → Listo para retirar | Finalizado
- Listo para retirar → Finalizado
- Finalizado/Cancelado → (terminales)

## 5. Reglas y Validaciones Clave
- El ticket se crea con estado inicial "Nuevo".
- Asignación: un ticket asignado registra `tecnico_id` y `supervisor_id`.
- Mano de obra: la define el técnico únicamente en Diagnóstico y no se modifica después.
- Preparación de presupuesto: cuando hay ítems y mano de obra, el sistema puede mover el ticket a "En espera".
- Publicación: el supervisor publica y el estado queda en "Presupuesto".
- Decisión del cliente: 
    -> Aprobar → el sistema cambia automáticamente a "En reparación".
    -> Rechazar → el sistema cambia a "Cancelado".  

- Cierre: retiro y pago confirmados por Supervisor
    -> El Supervisor puede marcar "Listo para retirar" cuando corresponde.
    -> Al registrar "Pagado y Finalizado", el sistema pasa automáticamente a "Finalizado" y se muestra overlay "PAGADO" en la vista del ticket.

- Solicitud de repuestos: sólo para tickets asignados al técnico solicitante; se valida y descuenta stock.
- Visibilidad al cliente: no se muestran valores unitarios; se muestran subtotal de ítems, mano de obra y total.
- Disponibilidad del técnico: la gestiona el propio técnico (informativa, no bloqueante).
- Auditoría/Historial: opcional según configuración del entorno.

## 6. Casos de Uso (resumen)
- UC01 Crear Ticket (Cliente)
- UC03 Asignar Técnico (Supervisor)
- UC05 Solicitar Repuesto (Técnico)
- (Recomendados) Publicar Presupuesto (Supervisor), Aprobar/Rechazar Presupuesto (Cliente), Cambiar Estado (Técnico)
 - (Cierre) Marcar Listo para Retirar y Pagado (Supervisor)

## 7. Trazabilidad con Código
- Controladores: `Controllers/TicketController.php`, `SupervisorController.php`, `TecnicoController.php`, `InventarioController.php`.
- Modelos: `Models/Ticket.php`, `Models/ItemTicket.php`, `Models/Inventario.php`, `Models/TicketLabor.php`, `Models/TecnicoStats.php`.
- Vistas: `Views/Ticket/*`, `Views/Supervisor/*`, `Views/Tecnicos/MisRepuestos.php`.
- Rutas relevantes: `Ticket/MarcarListoParaRetirar`, `Ticket/MarcarPagadoYFinalizar` (solo Supervisor).