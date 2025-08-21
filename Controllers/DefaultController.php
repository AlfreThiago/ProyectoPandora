<?php
require_once __DIR__ . '/../Core/Auth.php';

class DefaultController
{

    public function index()
    {
        $user = Auth::user();
        include_once __DIR__ . '/../Views/AllUsers/Home.php';
    }
}
