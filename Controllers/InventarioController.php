<?php
require_once __DIR__ . '/../Models/Inventory.php';
require_once __DIR__ . '/../Core/Database.php';

class InventarioController
{
    private $db;
    private $model;

    public function __construct()
    {
        $conexion = new Database();
        $this->db = $conexion->getConnection();
        $this->model = new Repuesto($this->db);
    }

    public function index()
    {
        $stmt = $this->model->leer();
        $repuestos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once __DIR__ . '/../Views/inventario/index.php';
    }

    public function show($id)
    {
        $repuesto = $this->model->obtenerPorId($id);
        require_once __DIR__ . '/../Views/inventario/show.php';
    }

    public function create()
    {
        require_once __DIR__ . '/../Views/inventario/create.php';
    }

    public function store()
    {
        $this->model->nombre = $_POST['nombre'];
        $this->model->descripcion = $_POST['descripcion'];
        $this->model->stock_actual = $_POST['stock_actual'];
        $this->model->stock_minimo = $_POST['stock_minimo'];
        $this->model->crear();
        header('Location: /inventario');
        exit;
    }

    public function edit($id)
    {
        $repuesto = $this->model->obtenerPorId($id);
        require_once __DIR__ . '/../Views/inventario/edit.php';
    }

    public function update($id)
    {
        $this->model->id = $id;
        $this->model->nombre = $_POST['nombre'];
        $this->model->descripcion = $_POST['descripcion'];
        $this->model->stock_actual = $_POST['stock_actual'];
        $this->model->stock_minimo = $_POST['stock_minimo'];
        $this->model->actualizar();
        header('Location: /inventario');
        exit;
    }

    public function destroy($id)
    {
        $this->model->id = $id;
        $this->model->eliminar();
        header('Location: /inventario');
        exit;
    }
}
