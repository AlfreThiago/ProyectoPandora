# UC03 - Asignar Técnico

- Actor principal: Supervisor
- Propósito: Asignar un técnico disponible a un ticket.
- Disparador: Supervisor selecciona ticket y técnico.

## Flujo básico
1. El sistema muestra tickets sin técnico y lista de técnicos.
2. El supervisor selecciona técnico y ticket.
3. El sistema asigna `tecnico_id` y `supervisor_id` al ticket.
4. El sistema registra en historial.

## Reglas de negocio
- Un ticket asignado debe registrar un `supervisor_id` (trazabilidad y validaciones posteriores).
- Un técnico puede tener múltiples tickets asignados; la disponibilidad ("Disponible"/"Ocupado") la gestiona el propio técnico en su perfil y no bloquea la asignación.

## Validaciones
- Ticket existe y está sin técnico.
- Técnico existe y está disponible.

## Excepciones
- E1: Ticket ya asignado → denegar.
- E2: Técnico no disponible → denegar.

## Postcondiciones
- Ticket vinculado a técnico y supervisor.
- Técnico con estado actualizado.