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
    if (isset($_GET['edit'])) {
        $controller->edit();
    } elseif (isset($_GET['hapus'])) {
        $controller->delete();
    } elseif (isset($_GET['search'])) {
        $controller->search();
    } else {
        $controller->index();
    }
}