# UC05 - Solicitar Repuesto

- Actor principal: Técnico
- Propósito: Registrar una solicitud de ítems de inventario para un ticket.
- Disparador: Técnico ingresa cantidad en Mis Repuestos.

## Observaciones
- La solicitud sólo la puede realizar el técnico asignado al ticket.
- El precio unitario se toma del inventario en el servidor.
- Si ya existe mano de obra definida para el ticket, al agregar ítems el sistema puede mover el ticket a "En espera" y dejar registro en el historial.

## Precondiciones 
- Usuario autenticado con rol "Técnico".
- Ticket existente y asignado al técnico que ejecuta la acción.
- Ticket en estado que permite preparar presupuesto: preferentemente "Diagnóstico".
- Si al agregar ítems ya existe mano de obra (> 0), el sistema podrá mover el ticket a "En espera" automáticamente.
- El ticket no debe estar en estados terminales: "Finalizado" o "Cancelado".
- Catálogo de inventario disponible y conexión a base de datos operativa.
- Cantidad solicitada debe ser un entero positivo (validación del formulario).
- Ticket con supervisor asociado; de lo contrario, se bloquea hasta asignación (ver Excepción E2).

## Postcondiciones
- Stock actualizado.
- Línea creada en `item_ticket` y, opcionalmente, trazabilidad en historial.

## Flujo básico
1. El sistema muestra inventario filtrable, paginado.
2. El técnico ingresa cantidad para un ítem y envía la solicitud.
3. El sistema valida propiedad del ticket y stock disponible.
4. El sistema descuenta stock y registra en `item_ticket` el total (cantidad x precio unitario).

## Flujos alternativos
- FA1: Múltiples ítems
	1. El técnico puede solicitar más de un ítem en diferentes operaciones.
	2. El sistema acumula líneas en `item_ticket`.
- FA2: Sin resultados en inventario
	1. Filtros devuelven vacío.
	2. Se informa y se mantiene la vista.

## Excepciones
- E1: Stock insuficiente → denegar.
- E2: Ticket sin supervisor → bloquear hasta asignación

## Restricciones
- Sólo rol "Tecnico" con ticket asignado puede ejecutar la acción.
- La operación debe afectar stock de forma atómica y registrar historial.