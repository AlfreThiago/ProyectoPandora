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

## Reglas de negocio
- Sólo el técnico asignado puede solicitar para ese ticket.
- Rechazar cantidades <= 0 o mayores al stock.

## Validaciones
- Ticket asignado al técnico solicitante.
- Stock suficiente.

## Excepciones
- E1: Stock insuficiente → denegar.
- E2: Ticket sin supervisor → bloquear hasta asignación.

## Postcondiciones
- Stock actualizado.
- Línea creada en `item_ticket` y trazabilidad en historial.