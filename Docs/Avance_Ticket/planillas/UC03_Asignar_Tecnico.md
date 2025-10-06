# UC03 - Asignar Técnico

- Actor principal: Supervisor
- Propósito: Asignar un técnico disponible a un ticket.
- Disparador: Supervisor selecciona ticket y técnico.

## Observaciones
- Sólo rol "Supervisor" puede asignar técnicos.
- La disponibilidad del técnico es informativa; no bloquea la asignación.


## Precondiciones
- Supervisor autenticado.
- Ticket existente en estado válido para asignación (p.ej. "Nuevo" o "Diagnóstico").

## Postcondiciones
- Ticket vinculado a técnico y supervisor.
- Registro en `ticket_estado_historial` con usuario y comentario.

## Flujo básico
1. El sistema muestra tickets sin técnico y lista de técnicos.
2. El supervisor selecciona técnico y ticket.
3. El sistema asigna `tecnico_id` y `supervisor_id` al ticket.

## Flujos alternativos
- FA1: Reasignación
  1. Si el ticket ya tiene técnico, el supervisor puede cambiarlo.
  2. El sistema registra la reasignación en historial.
- FA2: Falta de técnicos
  1. Si no hay técnicos listados, informar y mantener el ticket sin técnico.

## Excepciones
- E1: Ticket ya asignado → denegar.
- E2: Técnico no disponible → denegar.

## Restricciones
- Sólo usuarios con rol "Supervisor" pueden ejecutar este caso de uso.