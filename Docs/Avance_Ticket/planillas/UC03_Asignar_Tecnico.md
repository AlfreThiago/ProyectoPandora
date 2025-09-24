# UC03 - Asignar Técnico

- Actor principal: Supervisor
- Propósito: Asignar un técnico disponible a un ticket.
- Disparador: Supervisor selecciona ticket y técnico.

## Flujo básico
1. El sistema muestra tickets sin técnico y lista de técnicos.
2. El supervisor selecciona técnico y ticket.
3. El sistema asigna `tecnico_id` y `supervisor_id` al ticket.
4. El sistema registra en historial.

## Observaciones
- Sólo rol "Supervisor" puede asignar técnicos.
- La disponibilidad del técnico es informativa; no bloquea la asignación.
- Opcional: la acción puede reflejarse en la línea de tiempo del ticket si la auditoría está habilitada.

## Precondiciones
- Supervisor autenticado.
- Ticket existente en estado válido para asignación (p.ej. "Nuevo" o "Diagnóstico").

## Postcondiciones
- Ticket vinculado a técnico y supervisor.
- Opcional: registro en `ticket_estado_historial` con usuario y comentario.

## Reglas de negocio
- Un ticket asignado debe registrar un `supervisor_id` (trazabilidad y validaciones posteriores).
- Un técnico puede tener múltiples tickets asignados; la disponibilidad ("Disponible"/"Ocupado") la gestiona el propio técnico en su perfil y no bloquea la asignación.

## Validaciones
- Ticket existe y está sin técnico.
- Técnico existe y está disponible.

## Excepciones
- E1: Ticket ya asignado → denegar.
- E2: Técnico no disponible → denegar.

## Flujos alternativos
- FA1: Reasignación
  1. Si el ticket ya tiene técnico, el supervisor puede cambiarlo.
  2. El sistema registra la reasignación en historial.
- FA2: Falta de técnicos
  1. Si no hay técnicos listados, informar y mantener el ticket sin técnico.

## Restricciones
- Sólo usuarios con rol "Supervisor" pueden ejecutar este caso de uso.
- La auditoría en historial es opcional.