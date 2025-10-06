<?php

class ItemTicketModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function crear($ticket_id, $inventario_id, $tecnico_id, $supervisor_id, $cantidad, $valor_total)
    {
        $sql = "INSERT INTO item_ticket (ticket_id, inventario_id, tecnico_id, supervisor_id, cantidad, valor_total)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("iiiiid", $ticket_id, $inventario_id, $tecnico_id, $supervisor_id, $cantidad, $valor_total);
            return $stmt->execute();
        }
        return false;
    }

    public function listarPorTicket($ticket_id)
    {
        $sql = "SELECT it.id,
                       it.ticket_id,
                       it.inventario_id,
                       it.tecnico_id,
                       it.supervisor_id,
                       it.cantidad,
                       it.valor_total,
                       it.fecha_asignacion,
                       i.name_item,
                       i.valor_unitario,
                       i.foto_item,
                       c.name AS categoria
                FROM item_ticket it
                INNER JOIN inventarios i ON it.inventario_id = i.id
                INNER JOIN categorias_inventario c ON i.categoria_id = c.id
                WHERE it.ticket_id = ?
                ORDER BY it.fecha_asignacion DESC";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $ticket_id);
            $stmt->execute();
            $res = $stmt->get_result();
            $data = [];
            while ($row = $res->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return [];
    }
}

?>