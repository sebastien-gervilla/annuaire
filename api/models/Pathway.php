<?php

class Pathway {
    private int $student_id;
    private int $specialization_id;

    private array $validations;

    public function __construct(int $studentId, int $specializationId) {
        $this->student_id = $studentId;
        $this->specialization_id = $specializationId;
        $this->setValidations();
    }

    private function setValidations() {
        $this->validations = array(
            'Identifiant Elève' => [],
            'Identifiant Spécialisation' => []
        );
    }

    public function getValidations() {
        return $this->validations;
    }

    public function getModel() { return array(
        "studentId" => $this->student_id,
        "specializationId" => $this->specialization_id
    ); }
}