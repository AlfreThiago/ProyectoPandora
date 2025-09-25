# Crear Ticket
- Actor principal: Cliente
- Propósito: Registrar una solicitud de servicio para un dispositivo.
- Disparador: Cliente selecciona "Crear Ticket".

## Observaciones
- El estado inicial del ticket es "Nuevo" y se muestra en el detalle con badge.
- El cliente sólo ve sus dispositivos y no puede crear tickets para otros.
- Opcional: puede registrarse una línea en `ticket_estado_historial` con el estado inicial y usuario si la auditoría está habilitada.
- La navegación vuelve a Mis Tickets tras crear.

## Precondiciones
- Cliente autenticado en el sistema.
- El cliente tiene al menos un dispositivo registrado.

## Postcondiciones
- Ticket persistido con fecha de creación.
- Opcional: registro en historial asociado al ticket.

## Flujo básico
1. El sistema muestra formulario con dispositivos del cliente.
2. El cliente ingresa la descripción de la falla y selecciona dispositivo.
3. El cliente confirma la creación.
4. El sistema valida datos y crea el ticket con estado "Nuevo".

## Flujos alternativos
- FA1: Cliente no tiene dispositivos
	1. El sistema informa que debe registrar un dispositivo antes.
	2. Ofrece navegación a la sección de dispositivos.
- FA2: Validación de datos fallida
	1. Falta descripción o selección de dispositivo.
	2. El sistema muestra mensajes y no crea el ticket.
- FA3: Error de persistencia
	1. Falla la inserción en base de datos.
	2. El sistema registra el incidente y notifica al cliente.

## Excepciones
- E1: Dispositivo no encontrado → mostrar error.
- E2: Falla al insertar → registrar y notificar.
- E3: Usuario no autenticado → redirigir a Login.
- E4: Dispositivo no pertenece al cliente → denegar y notificar.

## Restricciones
- El estado inicial es "Nuevo" (id=1).
- El dispositivo debe pertenecer al cliente autenticado.

