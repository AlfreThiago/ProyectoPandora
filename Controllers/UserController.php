<?php
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Core/Database.php';

class UserController
{
    public function Register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $controllerRegister = new UserController();
            $result = $controllerRegister->RegisterUser($username, $email, $password);

            echo $result;
            header(header: 'Location: ../Views/Dashboard/dashboard.php');
            exit;
        } else {
            include 'Views/User/Register.php';
        }
    }

    public function RegisterUser($username, $email, $password)
    {
        $db = new Database();
        $db->conectDatabase();
        $userModel = new UserModel($db->getConnection());

        if ($userModel->createUser($username, $email, $password)) {
            return "User registered successfully.";
        } else {
            return "Error registering user.";
        }
    }
}
