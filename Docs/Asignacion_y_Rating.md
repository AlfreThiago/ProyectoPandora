# Sistema de asignación de técnicos y honor (rating)

Esta guía resume cómo funciona la asignación de técnicos a tickets y el sistema de honor/calificación en el proyecto. Incluye qué archivos revisar y las reglas de negocio clave.

## Asignación de técnicos a tickets

- Punto de entrada (rutas):
  - `Supervisor/Asignar` → lista técnicos y tickets sin técnico.
  - `Supervisor/AsignarTecnico` → ejecuta la asignación.
- Archivos principales:
  - Controlador: `Controllers/SupervisorController.php` (métodos `Asignar()` y `AsignarTecnico()`).
  - Modelos:
    - `Models/User.php` → `getAllTecnicos()`, `setTecnicoEstado()`.
    - `Models/Ticket.php` → `getTicketsSinTecnico()`, `asignarTecnico()`, `asignarSupervisor()`.
  - Vista: `Views/Supervisor/Asignar.php` (UI de filtros, tarjetas de técnico, formulario de asignación).
  - Rutas: `Routes/web.php` (mapea las rutas anteriores al controlador).

### Diagrama de flujo: Asignar técnico

- Supervisor abre `Supervisor/Asignar` → filtra y elige técnico y ticket → POST a `Supervisor/AsignarTecnico`
- Backend valida:
  - Rol = Supervisor
  - Ticket sin técnico
  - Calcula honor promedio del técnico y límite permitido
  - Cuenta tickets activos del técnico
  - Si activos >= límite → error
  - Si pasa → asigna técnico y supervisor; si alcanzó límite → marca "Ocupado" (UI: "No disponible")

### Flujo (contrato) de asignación
- Entradas: `ticket_id` y `tecnico_id` (POST a `Supervisor/AsignarTecnico`).
- Precondiciones:
  - Usuario debe tener rol `Supervisor` (verificación con `Auth::checkRole`).
  - El ticket no debe tener técnico asignado (se verifica en DB).
- Lógica de negocio:
  1) Cargar promedio de honor del técnico (rating promedio) y conteo de calificaciones.
  2) Redondear a estrellas enteras y mapear un límite de carga activa:
     - 1★ → 3 tickets activos máximo.
     - 2★ → 5 activos.
     - 3★ → 10 activos.
     - 4★ → 15 activos.
     - 5★ → sin límite (PHP_INT_MAX).
  3) Calcular tickets activos actuales del técnico (`fecha_cierre IS NULL`).
  4) Si `activos >= límite`, rechazar con error.
  5) Si pasa, asignar: `tickets.tecnico_id = tecnico_id` y asociar el `supervisor_id` del usuario en sesión.
  6) Post-asignación, si se alcanzó el límite, marcar disponibilidad del técnico como `Ocupado` (en UI se muestra como “No disponible”).
- Salidas: redirección con `success=1` o `error=...`.

### Orden y filtros en la UI
- `UserModel::getAllTecnicos()` aporta:
  - Datos del usuario, `disponibilidad`, `especialidad`.
  - `tickets_asignados` y `tickets_activos` vía subconsultas.
- `SupervisorController::Asignar()` enriquece cada técnico con `rating_avg` y `rating_count` y ordena:
  - Primer criterio: `rating_avg` descendente.
  - Segundo criterio: `tickets_activos` ascendente.
- `Views/Supervisor/Asignar.php` permite filtrar por disponibilidad y buscar por nombre/especialidad, y seleccionar el ticket a asignar.

## Sistema de honor / rating

- Propósito: permitir que el cliente califique al técnico por ticket y usar ese promedio para orden y límites de asignación.
- Archivos principales:
  - Modelo: `Models/Rating.php` (crea tabla, guarda/actualiza, promedia por técnico).
  - Controlador de tickets: `Controllers/TicketController.php` (método `Calificar`).
  - Vista de ticket: `Views/Ticket/VerTicket.php` (muestra el formulario de calificación cuando corresponde).
  - Uso en Supervisor: `Controllers/SupervisorController.php` (lee promedio y conteo; aplica límites).
  - Estadísticas del técnico: `Controllers/TecnicoController.php::MisStats()` y `Views/Tecnicos/MisStats.php`.

### Diagrama de flujo: Calificar (honor)

- Cliente abre `Ticket/Ver` → si estado Finalizado/Cerrado y es dueño → ve form de calificación
- Envía POST `Ticket/Calificar` con `ticket_id`, `stars` (1–5), `comment`
- Backend valida:
  - Rol = Cliente
  - Ticket pertenece al cliente y tiene técnico
  - Estado del ticket es final (finalizado/cerrado)
  - Guarda rating (upsert por ticket)
- Resultado: redirección a `Ticket/Ver&id=...&rated=1`

### Tabla y persistencia
- Tabla: `ticket_ratings` (creada al instanciar `RatingModel`).
  - Campos: `ticket_id` (UNIQUE), `tecnico_id`, `cliente_id`, `stars` (1–5), `comment`, timestamps.
  - Restricciones: FK a `tickets`, `tecnicos` y `clientes` con `ON DELETE CASCADE`.
- Guardado:
  - `RatingModel::save()` hace UPSERT por `ticket_id`: si existe, actualiza; si no, inserta.
- Cálculo de promedio:
  - `RatingModel::getAvgForTecnico($tecnico_id)` devuelve `[avg_stars, total]`.

### Quién y cuándo puede calificar
- Sólo el usuario con rol `Cliente` propietario del ticket.
- Sólo cuando el ticket esté en estado “Finalizado/Cerrado”.
- Flujo:
  - Vista `Ticket/VerTicket.php` muestra el formulario cuando el estado es final y el ticket tiene técnico.
  - `TicketController::Calificar` valida rol, propiedad del ticket y estado; luego llama a `RatingModel::save()`.

### Uso del honor en la asignación y stats
- En `SupervisorController::Asignar()` se añade `rating_avg` y `rating_count` a cada técnico, se ordena por ello y se muestra un display de estrellas (con redondeo y tooltip en la vista).
- En `SupervisorController::AsignarTecnico()` el `starsRounded` determina el límite de tickets activos.
- En `TecnicoController::MisStats()` se muestra el promedio (1 decimal) y el conteo de calificaciones.

## Gotchas y detalles a tener en cuenta
- Fallback de 3★: cuando un técnico no tiene calificaciones (`rating_count = 0`), en la UI de Asignar se muestra 3.0★ por defecto. El límite también usa 3★ por defecto si no hay calificaciones.
- Única calificación por ticket: `ticket_id` es UNIQUE en `ticket_ratings`, por lo que una nueva calificación sobre el mismo ticket actualiza (no duplica).
- “No disponible” vs `Ocupado`: a nivel de base se guarda `Ocupado`; en UI se muestra como “No disponible”. Los filtros usan los valores internos (`Disponible`/`Ocupado`).
- Conteo de activos: se considera activo si `fecha_cierre IS NULL`.
- Semilla de honor: hay un intento de insertar una calificación inicial de 3★ al registrar técnicos nuevos (`RegisterController.php`), pero puede no persistir si no existe `ticket_id=0` por las FKs. De todos modos, el fallback a 3★ cubre el caso de técnicos sin calificaciones.
- Consistencia visual: en listados de admin (`Views/Admin/ListaTecnico.php`) ya mostramos “No disponible” cuando el valor interno es `Ocupado` para mantener coherencia con Supervisor/Asignar y Perfil.

## Orden recomendado de lectura
1) `Controllers/SupervisorController.php` → métodos `Asignar()` y `AsignarTecnico()`.
2) `Models/User.php` → `getAllTecnicos()` y `setTecnicoEstado()`.
3) `Models/Ticket.php` → `getTicketsSinTecnico()`, `asignarTecnico()`, `asignarSupervisor()`.
4) `Views/Supervisor/Asignar.php` → filtros, orden, formulario.
5) `Models/Rating.php` → tabla y API de calificaciones.
6) `Controllers/TicketController.php::Calificar()` y `Views/Ticket/VerTicket.php` → quién/ cuándo califica.
7) (Opcional) `Controllers/TecnicoController.php::MisStats()` y `Views/Tecnicos/MisStats.php` → visualización del honor.

## Criterios de éxito (check rápido)
- No se puede asignar un ticket ya asignado.
- Un técnico no puede sobrepasar su límite activo según su honor.
- El supervisor queda asociado al ticket asignado.
- Sólo el cliente propietario califica y sólo con el ticket finalizado.
- El promedio y conteo se reflejan en Asignar y en MisStats.

---
Cualquier mejora propuesta (p.ej. normalizar “No disponible” en la base o guardar un “rating inicial” sin violar FKs) se puede discutir y ajustar en iteraciones futuras.
