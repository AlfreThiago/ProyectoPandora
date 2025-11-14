# UC06 - Publicar Presupuesto

- Actor principal: Supervisor
- Propósito: Publicar el presupuesto preparado (ítems + mano de obra) para que el cliente lo revise.
- Disparador: Supervisor confirma publicación desde Presupuestos.

## Observaciones
- Sólo rol Supervisor puede publicar.
- Requiere ítems y mano de obra definidos.
- No se muestran valores unitarios al cliente (solo totales).

## Precondiciones
- Supervisor autenticado.
- Ticket válido con ítems y mano de obra definidos.

## Postcondiciones
- Ticket en estado "Presupuesto".
- (Opcional) Notificación al cliente.

## Flujo básico
1. Supervisor revisa resumen (ítems y mano de obra).
2. Supervisor confirma Publicar.
3. El sistema cambia estado a "Presupuesto".

## Flujo alternativo
- FA1: Faltan datos → deshabilitar publicación y mostrar mensaje.

## Excepciones
- E1: Ticket inválido → denegar.
- E2: Sin técnico asignado → denegar.

## Restricciones
- Acceso exclusivo de Supervisor.
