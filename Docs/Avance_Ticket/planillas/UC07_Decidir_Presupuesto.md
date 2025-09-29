# UC07 - Aprobar/Rechazar Presupuesto

- Actor principal: Cliente
- Propósito: Aceptar o rechazar el presupuesto publicado.
- Disparador: Cliente abre el ticket con estado "Presupuesto".

## Observaciones
- Si aprueba, el sistema pasa el ticket a "En reparación" automáticamente.
- Si rechaza, el sistema pasa el ticket a "Cancelado".

## Precondiciones
- Cliente autenticado dueño del ticket.
- Ticket en estado "Presupuesto".

## Postcondiciones
- Ticket actualizado a "En reparación" o "Cancelado".

## Flujo básico
1. Cliente revisa totales de ítems y mano de obra.
2. Cliente elige Aprobar o Rechazar.
3. El sistema actualiza el estado según la decisión.

## Flujo alternativo
- (N/A)

## Excepciones
- E1: Ticket no pertenece al cliente → denegar.
- E2: Ticket no está en "Presupuesto" → denegar.

## Restricciones
- No se muestran valores unitarios al cliente.
