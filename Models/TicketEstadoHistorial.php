<?php
class TicketEstadoHistorialModel {
    private $conn;
    public function __construct($db){ $this->conn = $db; }
    public function add($ticket_id, $estado_id, $user_id, $user_role, $comentario=null){
        $stmt = $this->conn->prepare("INSERT INTO ticket_estado_historial (ticket_id, estado_id, user_id, user_role, comentario) VALUES (?,?,?,?,?)");
        $stmt->bind_param("iiiss", $ticket_id, $estado_id, $user_id, $user_role, $comentario);
        return $stmt->execute();
    }
    public function listByTicket($ticket_id){
        $sql = "SELECT h.*, e.name AS estado, u.name AS autor
                FROM ticket_estado_historial h
                INNER JOIN estados_tickets e ON h.estado_id = e.id
                INNER JOIN users u ON h.user_id = u.id
                WHERE h.ticket_id = ? ORDER BY h.created_at ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $ticket_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $out = [];
        while($row=$res->fetch_assoc()){ $out[] = $row; }
        return $out;
    }
}
?>
