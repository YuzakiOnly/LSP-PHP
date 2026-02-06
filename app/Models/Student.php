<?php

namespace Models;

class Student
{
    public static function getAll()
    {
        if (empty($_SESSION['student'])) {
            return [];
        }

        $student = $_SESSION['student'];
        array_multisort(array_column($student, 'nis'), SORT_ASC, $student);
        return $student;
    }

    public static function find($index)
    {
        if (empty($_SESSION['student'])) {
            return null;
        }

        foreach ($_SESSION['student'] as $student) {
            if ($student['nis'] == $index) {
                return $student;
            }
        }
        return null;
    }

    public static function create($data)
    {
        if (!isset($_SESSION['student'])) {
            $_SESSION['student'] = [];
        }

        $_SESSION['student'][] = [
            'nis' => $data['nis'],
            'nama' => $data['nama'],
            'mtk' => $data['mtk'],
            'bin' => $data['bin'],
            'big' => $data['big'],
            'pro' => $data['pro']
        ];

        return true;
    }

    public static function update($index, $data)
    {
        if (empty($_SESSION['student'])) {
            return false;
        }

        foreach ($_SESSION['student'] as $key => $student) {
            if ($student['nis'] == $index) {
                $_SESSION['student'][$key] = [
                    'nis' => $data['nis'],
                    'nama' => $data['nama'],
                    'mtk' => $data['mtk'],
                    'bin' => $data['bin'],
                    'big' => $data['big'],
                    'pro' => $data['pro']
                ];
                return true;
            }
        }
        return false;
    }

    public static function delete($index)
    {
        if (empty($_SESSION['student'])) {
            return false;
        }

        foreach ($_SESSION['student'] as $key => $student) {
            if ($student['nis'] == $index) {
                unset($_SESSION['student'][$key]);
                $_SESSION['student'] = array_values($_SESSION['student']);
                return true;
            }
        }
        return false;
    }

    public static function calculateAverage($student)
    {
        return ($student['mtk'] + $student['bin'] + $student['big'] + $student['pro']) / 4;
    }

    public static function calculateAllAverages($allStudent)
    {
        $totals = [
            'mtk' => 0,
            'bin' => 0,
            'big' => 0,
            'pro' => 0,
            'rerata' => 0
        ];

        $count = count($allStudent);

        if ($count === 0) {
            return $totals;
        }

        foreach ($allStudent as $student) {
            $totals['mtk'] += $student['mtk'];
            $totals['bin'] += $student['bin'];
            $totals['big'] += $student['big'];
            $totals['pro'] += $student['pro'];
            $totals['rerata'] += self::calculateAverage($student);
        }

        return [
            'mtk' => round($totals['mtk'] / $count, 2),
            'bin' => round($totals['bin'] / $count, 2),
            'big' => round($totals['big'] / $count, 2),
            'pro' => round($totals['pro'] / $count, 2),
            'rerata' => round($totals['rerata'] / $count, 2)
        ];
    }

    public static function search($keyword)
    {
        if (empty($_SESSION['student'])) {
            return [];
        }

        $results = [];
        foreach ($_SESSION['student'] as $student) {
            if (stripos($student['nis'], $keyword) !== false) {
                $results[] = $student;
            }
        }

        array_multisort(array_column($results, 'nis'), SORT_ASC, $results);
        return $results;
    }

    public static function sort($students, $sortBy, $sortOrder)
    {
        if (empty($students)) {
            return [];
        }

        if ($sortBy === 'rerata') {
            $column = [];
            foreach ($students as $student) {
                $column[] = self::calculateAverage($student);
            }
        } else {
            $column = array_column($students, $sortBy);
        }

        $order = ($sortOrder === 'desc') ? SORT_DESC : SORT_ASC;
        array_multisort($column, $order, $students);

        return $students;
    }
}