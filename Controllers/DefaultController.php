<?php
require_once __DIR__ . '/../Core/Auth.php';

class DefaultController
{

    public function index()
    {
        $user = Auth::user();
        include_once __DIR__ . '/../Views/AllUsers/Home.php';
    }
    public function index2() {
        $user = Auth::user();
        include_once __DIR__ . '/../Views/AllUsers/Guia.php';
    }  
    public function index3() {
        $user = Auth::user();
        include_once __DIR__ . '/../Views/AllUsers/Perfil.php';
    }
}
