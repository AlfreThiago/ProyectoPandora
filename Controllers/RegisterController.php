<?php
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Controllers/HistorialController.php';

class RegisterController
{
    private $historialController;

    public function __construct()
    {
        $this->historialController = new HistorialController();
    }

    public function Register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $result = $this->RegisterUser($username, $email, $password);
            // Guardar en historial
            $accion = "Registro de usuario";
            $detalle = "Se registró el usuario {$username} con email {$email}. Resultado: {$result}";
            $this->historialController->agregarAccion($accion, $detalle);

            header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
            exit;
        } else {
            include_once __DIR__ . '/../Views/Auth/Register.php';
        }
    }

    public function RegisterAdmin()
    {
        $user = Auth::user();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'Cliente';

            $result = $this->RegisterUserWithRole($username, $email, $password, $role);

            $accion = "Registro de usuario por admin";
            $detalle = "El administrador registró el usuario {$username} con email {$email} y rol {$role}. Resultado: {$result}";
            $this->historialController->agregarAccion($accion, $detalle);

            header('Location: /ProyectoPandora/Public/index.php?route=Admin/ListarUsers');
            exit;
        } else {
            include_once __DIR__ . '/../Views/Admin/Register.php';
        }
    }

    function RegisterUser($username, $email, $password)
    {
        $db = new Database();
        $db->connectDatabase();
        $userModel = new UserModel($db->getConnection());
        $existingUser = $userModel->findByEmail($email);
        if ($existingUser) {
            $isAdmin = isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'RegisterAdminPortal') !== false;
            $route = $isAdmin ? 'Register/RegisterAdminPortal' : 'Register/Register';
            header("Location: /ProyectoPandora/Public/index.php?route=$route&error=EmailYaRegistrado");
            exit;
        }

        $role = ($email === 'admin@admin.com') ? 'Administrador' : 'Cliente';

        if ($userModel->createUser($username, $email, $password, $role)) {
            return "User registered successfully.";
        } else {
            return "Error registering user.";
        }
    }

    public function RegisterUserWithRole($username, $email, $password, $role)
    {
        $db = new Database();
        $db->connectDatabase();
        $userModel = new UserModel($db->getConnection());

        $existingUser = $userModel->findByEmail($email);
        if ($existingUser) {
            $isAdmin = isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'RegisterAdminPortal') !== false;
            $route = $isAdmin ? 'Register/RegisterAdminPortal' : 'Register/Register';
            header("Location: /ProyectoPandora/Public/index.php?route=$route&error=EmailYaRegistrado");
            exit;
        }

        if ($userModel->createUser($username, $email, $password, $role)) {
            // Si es técnico, registrar una calificación inicial simulada de 3★ para arrancar con reputación base
            if (strcasecmp($role, 'Tecnico') === 0) {
                require_once __DIR__ . '/../Models/Rating.php';
                // Buscar el tecnico recien creado
                $newUser = $userModel->findByEmail($email);
                if ($newUser) {
                    // Resolver tecnico_id y un cliente fantasma 0 (o null) si el esquema lo permite
                    $conn = $db->getConnection();
                    // Obtener tecnico_id por user_id
                    $stmtT = $conn->prepare("SELECT id FROM tecnicos WHERE user_id = ? LIMIT 1");
                    if ($stmtT) {
                        $stmtT->bind_param('i', $newUser['id']);
                        $stmtT->execute();
                        $tec = $stmtT->get_result()->fetch_assoc();
                        if ($tec && isset($tec['id'])) {
                            $ratingM = new RatingModel($conn);
                            // Insertar fila de seed usando ticket_id=0 para promedio base (si la PK UNIQUE lo permite). Si no, ignorar errores.
                            @$conn->query("INSERT IGNORE INTO ticket_ratings (ticket_id, tecnico_id, cliente_id, stars, comment) VALUES (0, ".(int)$tec['id'].", 0, 3, 'Seed inicial 3★')");
                        }
                    }
                }
            }
            return "Usuario registrado correctamente con rol: $role";
        } else {
            return "Error al registrar usuario.";
        }
    }
}
