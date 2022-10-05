<?php

class StudentController {
    public static function getAll() {
        $students = array(
            array(
                "fname" => "Sébastien",
                "lname" => "Gervilla"
            ),
            array(
                "fname" => "Killian",
                "lname" => "Lecorf"
            )
        );
        return $students;
    }

    public static function getById(int $id) {
        $students = $id;
        return $students;
    }
}