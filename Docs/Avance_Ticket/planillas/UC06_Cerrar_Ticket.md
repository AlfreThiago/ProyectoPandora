# UC06 - Cerrar Ticket

- Actor principal: Supervisor/Técnico
- Propósito: Marcar ticket como resuelto y cerrar.
- Disparador: Trabajo finalizado y validado.

## Flujo básico
1. El técnico marca el trabajo como completado (opcional, según política).
2. El supervisor revisa y cambia estado a "Cerrado".
3. El sistema registra fecha de cierre e historial.

## Reglas de negocio
- Sólo roles autorizados pueden cerrar.
- Si hay repuestos solicitados, deben estar reflejados en el historial/costos.

## Validaciones
- Ticket en estado apto para cierre.

## Excepciones
- E1: Estado inválido para cierre.

## Postcondiciones
- Ticket cerrado con timestamp y trazabilidad.