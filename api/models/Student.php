<?php

class Student {
    private int $_id;
    private string $fname;
    private string $lname;
    private int $age;
    private string $gender;
    private string $email;
    private string|null $phone;
    private string|null $degree;

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
        $this->phone = $student['phone'];
        $this->degree = $student['degree'];
    }

    private function setValidations() {
        $phone = removeAllSpaces($this->phone);
        $this->validations = array(
            'Prénom' => [minLength($this->fname, 2)],
            'Nom' => [minLength($this->lname, 1)],
            'Age' => [betweenNumbers($this->age, 0, 100)],
            'Genre' => [amongValues($this->gender, ['Homme', 'Femme'])],
            'Email' => [validEmail($this->email)],
            'Téléphone' => [validPhone($phone), validLength($phone, 10)]
        );
    }

    public function getValidations() {
        return $this->validations;
    }
}