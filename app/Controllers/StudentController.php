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

        $sortBy = $_GET['sort'] ?? 'nis';
        $sortOrder = $_GET['order'] ?? 'asc';
        $student = Student::sort($student, $sortBy, $sortOrder);

        $averages = Student::calculateAllAverages($student);
        $searchKeyword = $keyword;

        require VIEW_PATH . 'student/index.php';
    }

    public function index()
    {
        $student = Student::getAll();

        $sortBy = $_GET['sort'] ?? 'nis';
        $sortOrder = $_GET['order'] ?? 'asc';
        $student = Student::sort($student, $sortBy, $sortOrder);

        $averages = Student::calculateAllAverages($student);

        require VIEW_PATH . 'student/index.php';
    }

    public function create()
    {
        require VIEW_PATH . 'student/form.php';
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
            header("Location: index.php?action=create");
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
        $_SESSION['success'] = "Data siswa {$data['nama']} berhasil ditambahkan!";
        header("Location: index.php");
        exit;
    }

    public function edit()
    {
        $nis = $_GET['nis'] ?? '';

        if (empty($nis)) {
            header("Location: index.php");
            exit;
        }

        $editData = Student::find($nis);

        if (!$editData) {
            $_SESSION['error'] = "Data siswa tidak ditemukan!";
            header("Location: index.php");
            exit;
        }

        require VIEW_PATH . 'student/form.php';
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
            header("Location: index.php?action=edit&nis=" . urlencode($oldNis));
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

        Student::update($oldNis, $data);
        $_SESSION['success'] = "Data siswa {$data['nama']} berhasil diupdate!";
        header("Location: index.php");
        exit;
    }

    public function delete()
    {
        $nis = $_GET['nis'] ?? '';

        if (empty($nis)) {
            header("Location: index.php");
            exit;
        }

        $student = Student::find($nis);
        if ($student) {
            Student::delete($nis);
            $_SESSION['success'] = "Data siswa {$student['nama']} berhasil dihapus!";
        } else {
            $_SESSION['error'] = "Data siswa tidak ditemukan!";
        }

        header("Location: index.php");
        exit;
    }
}