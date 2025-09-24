# UC05 - Solicitar Repuesto

- Actor principal: Técnico
- Propósito: Registrar una solicitud de ítems de inventario para un ticket.
- Disparador: Técnico ingresa cantidad en Mis Repuestos.

## Flujo básico
1. El sistema muestra inventario filtrable, paginado.
2. El técnico ingresa cantidad para un ítem y envía la solicitud.
3. El sistema valida propiedad del ticket y stock disponible.
4. El sistema descuenta stock y registra en `item_ticket` el total (cantidad x precio unitario).
5. El sistema registra en historial.

## Observaciones
- La solicitud sólo la puede realizar el técnico asignado al ticket.
- El precio unitario se toma del inventario en el servidor (no desde el cliente).
- Si ya existe mano de obra definida para el ticket, al agregar ítems el sistema puede mover el ticket a "En espera" y opcionalmente dejar registro en el historial.

## Reglas de negocio
- Sólo el técnico asignado puede solicitar para ese ticket.
- Rechazar cantidades <= 0 o mayores al stock.

## Validaciones
- Ticket asignado al técnico solicitante.
- Stock suficiente.

## Excepciones
- E1: Stock insuficiente → denegar.
- E2: Ticket sin supervisor → bloquear hasta asignación.

## Flujos alternativos
- FA1: Múltiples ítems
	1. El técnico puede solicitar más de un ítem en diferentes operaciones.
	2. El sistema acumula líneas en `item_ticket`.
- FA2: Sin resultados en inventario
	1. Filtros devuelven vacío.
	2. Se informa y se mantiene la vista.

## Postcondiciones
- Stock actualizado.
- Línea creada en `item_ticket` y, opcionalmente, trazabilidad en historial.

## Restricciones
- Sólo rol "Tecnico" con ticket asignado puede ejecutar la acción.
- La operación debe afectar stock de forma atómica y registrar historial.