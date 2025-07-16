<?php
require_once __DIR__ . '/Auth.php';
if (!Auth::check()) {
    header('Location: /ProyectoPandora/Public/index.php?route=Auth/Login');
    exit;
}
