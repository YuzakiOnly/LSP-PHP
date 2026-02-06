<?php

use Controllers\StudentController;

$controller = new StudentController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['simpan'])) {
        $controller->store();
    } elseif (isset($_POST['update'])) {
        $controller->update();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? null;

    switch ($action) {
        case 'create':
            $controller->create();
            break;

        case 'edit':
            $controller->edit();
            break;

        case 'delete':
            $controller->delete();
            break;

        default:
            if (isset($_GET['search'])) {
                $controller->search();
            } else {
                $controller->index();
            }
            break;
    }
}