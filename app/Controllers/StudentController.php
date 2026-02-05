<?php

namespace Controllers;

use Models\Student;

class StudentController
{
    public function search()
    {
        $keyword = $_GET['search'] ?? '';

        if (empty($keyword)) {
            header("Location: index.php");
            exit;
        }

        $student = Student::search($keyword);
        $averages = Student::calculateAllAverages($student);
        $searchKeyword = $keyword;

        require VIEW_PATH . 'student/index.php';
    }
    public function index()
    {
        $student = Student::getAll();
        $averages = Student::calculateAllAverages($student);

        require VIEW_PATH . 'student/index.php';
    }

    public function store()
    {
        $nis = $_POST['nis'];

        $nisExists = false;
        if (isset($_SESSION['student'])) {
            foreach ($_SESSION['student'] as $student) {
                if ($student['nis'] == $nis) {
                    $nisExists = true;
                    break;
                }
            }
        }

        if ($nisExists) {
            $_SESSION['error'] = "NIS {$nis} sudah terdaftar!";
            $_SESSION['old_input'] = $_POST;
            header("Location: index.php");
            exit;
        }

        $data = [
            'nis' => $_POST['nis'],
            'nama' => $_POST['nama'],
            'mtk' => $_POST['mtk'],
            'bin' => $_POST['bin'],
            'big' => $_POST['big'],
            'pro' => $_POST['pro']
        ];

        Student::create($data);
        header("Location: index.php");
        exit;
    }

    public function edit()
    {
        $index = $_GET['edit'];
        $editData = Student::find($index);

        $student = Student::getAll();
        $averages = Student::calculateAllAverages($student);

        require VIEW_PATH . 'student/index.php';
    }

    public function update()
    {
        $oldNis = $_POST['old_nis'];
        $newNis = $_POST['nis'];

        $nisExists = false;
        if ($newNis != $oldNis && isset($_SESSION['student'])) {
            foreach ($_SESSION['student'] as $student) {
                if ($student['nis'] == $newNis) {
                    $nisExists = true;
                    break;
                }
            }
        }

        if ($nisExists) {
            $_SESSION['error'] = "NIS {$newNis} sudah terdaftar!";
            $_SESSION['old_input'] = $_POST;
            header("Location: index.php?edit=" . urlencode($oldNis));
            exit;
        }
        
        $oldNis = $_POST['old_nis'];
        $data = [
            'nis' => $_POST['nis'],
            'nama' => $_POST['nama'],
            'mtk' => $_POST['mtk'],
            'bin' => $_POST['bin'],
            'big' => $_POST['big'],
            'pro' => $_POST['pro']
        ];

        Student::update($oldNis, $data);
        header("Location: index.php");
        exit;
    }

    public function delete()
    {
        $index = $_GET['hapus'];
        Student::delete($index);
        header("Location: index.php");
        exit;
    }
}