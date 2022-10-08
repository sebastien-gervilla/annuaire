<?php

class Student {
    private string $tablePrefix = 'student_';

    private int $id;
    private string $fname;
    private string $lname;
    private int $age;
    private string $gender;
    private string $email;
    private string|null $number;
    private string|null $degree;
    private string $createdAt;

    private array $validations;

    public function __construct(array $student) {
        $this->setModel($student);
        $this->setValidations();
    }

    private function setModel(array $student) {
        $this->fname = $student['fname'];
        $this->lname = $student['lname'];
        $this->age = $student['age'];
        $this->gender = $student['gender'];
        $this->email = $student['email'];
        $this->number = $student['number'];
        $this->degree = $student['degree'];
    }

    private function setValidations() {
        $this->validations = array(
            'Prénom' => [minLength($this->fname, 2)],
            'Nom' => [minLength($this->lname, 1)],
            'Age' => [betweenNumbers($this->age, 0, 100)],
            'Genre' => [amongValues($this->gender, ['Homme', 'Femme'])],
            'Email' => [validEmail($this->email)],
            'Téléphone' => [betweenLengths($this->number, 9, 11)]
        );
    }

    public function getValidations() {
        return $this->validations;
    }
}