# UC01 - Crear Ticket

- Actor principal: Cliente
- Propósito: Registrar una solicitud de servicio para un dispositivo.
- Disparador: Cliente selecciona "Crear Ticket".

## Flujo básico
1. El sistema muestra formulario con dispositivos del cliente.
2. El cliente ingresa la descripción de la falla y selecciona dispositivo.
3. El cliente confirma la creación.
4. El sistema valida datos y crea el ticket con estado "Abierto".

## Reglas de negocio
- El estado inicial es "En espera" (id=1).
- El dispositivo debe pertenecer al cliente autenticado.

## Validaciones
- Descripción requerida (no vacía).
- Dispositivo válido y asociado al cliente.

## Excepciones
- E1: Dispositivo no encontrado → mostrar error.
- E2: Falla al insertar → registrar y notificar.

## Postcondiciones
- Ticket persistido con fecha de creación.
- Registro en historial asociado al ticket.