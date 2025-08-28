<?php
class Ticket {
    private $conn;
    private $table = "tickets";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear Ticket
    public function crearTicket($dispositivo_id, $cliente_id, $descripcion_falla) {
        $sql = "INSERT INTO $this->table (dispositivo_id, cliente_id, descripcion_falla, estado_id) 
                VALUES (?, ?, ?, 1)"; -- 1 = En espera
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iis", $dispositivo_id, $cliente_id, $descripcion_falla);
        return $stmt->execute();
    }

    // Listar Tickets
    public function obtenerTickets() {
        $sql = "SELECT t.id, t.descripcion_falla, t.fecha_creacion, 
                       e.nombre AS estado, 
                       d.nombre AS dispositivo, 
                       c.nombre AS cliente,
                       tec.nombre AS tecnico
                FROM $this->table t
                JOIN estados_tickets e ON t.estado_id = e.id
                JOIN dispositivos d ON t.dispositivo_id = d.id
                JOIN clientes c ON t.cliente_id = c.id
                LEFT JOIN tecnicos tec ON t.tecnico_id = tec.id
                ORDER BY t.fecha_creacion DESC";
        return $this->conn->query($sql);
    }

    // Obtener Ticket por ID
    public function obtenerTicketPorId($id) {
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Actualizar descripción de falla (cliente puede editar al crear)
    public function actualizarTicket($id, $descripcion_falla) {
        $sql = "UPDATE $this->table SET descripcion_falla = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $descripcion_falla, $id);
        return $stmt->execute();
    }

    // Asignar Técnico (Supervisor)
    public function asignarTecnico($id, $tecnico_id) {
        $sql = "UPDATE $this->table SET tecnico_id = ?, estado_id = 2 WHERE id = ?"; 
        // 2 = En reparación
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $tecnico_id, $id);
        return $stmt->execute();
    }

    // Finalizar Ticket (Técnico)
    public function finalizarTicket($id) {
        $sql = "UPDATE $this->table SET estado_id = 3, fecha_cierre = NOW() WHERE id = ?"; 
        // 3 = Finalizado
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Eliminar Ticket
    public function eliminarTicket($id) {
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>



<?php
require_once __DIR__ . '/../Models/Ticket.php';
require_once __DIR__ . '/../Core/Database.php';

class TicketController {
    private $ticketModel;

    public function __construct() {
        $db = new Database();
        $db->connectDatabase();
        $this->ticketModel = new Ticket($db->getConnection());
    }

    // Crear Ticket
    public function crearTicket() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dispositivo_id = $_POST['dispositivo_id'];
            $cliente_id = $_POST['cliente_id'];
            $descripcion_falla = $_POST['descripcion_falla'];

            if ($this->ticketModel->crearTicket($dispositivo_id, $cliente_id, $descripcion_falla)) {
                header("Location: ../Views/Ticket/ListarTicket.php");
            } else {
                echo "Error al crear el ticket";
            }
        }
    }

    // Listar Tickets
    public function listarTickets() {
        return $this->ticketModel->obtenerTickets();
    }

    // Ver Ticket
    public function verTicket($id) {
        return $this->ticketModel->obtenerTicketPorId($id);
    }

    // Actualizar Ticket
    public function actualizarTicket() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];
            $descripcion_falla = $_POST['descripcion_falla'];

            if ($this->ticketModel->actualizarTicket($id, $descripcion_falla)) {
                header("Location: ../Views/Ticket/ListarTicket.php");
            } else {
                echo "Error al actualizar el ticket";
            }
        }
    }

    // Asignar Técnico
    public function asignarTecnico() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];
            $tecnico_id = $_POST['tecnico_id'];

            if ($this->ticketModel->asignarTecnico($id, $tecnico_id)) {
                header("Location: ../Views/Ticket/ListarTicket.php");
            } else {
                echo "Error al asignar técnico";
            }
        }
    }

    // Finalizar Ticket
    public function finalizarTicket() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];

            if ($this->ticketModel->finalizarTicket($id)) {
                header("Location: ../Views/Ticket/ListarTicket.php");
            } else {
                echo "Error al finalizar ticket";
            }
        }
    }

    // Eliminar Ticket
    public function eliminarTicket($id) {
        if ($this->ticketModel->eliminarTicket($id)) {
            header("Location: ../Views/Ticket/ListarTicket.php");
        } else {
            echo "Error al eliminar el ticket";
        }
    }
}
?>


