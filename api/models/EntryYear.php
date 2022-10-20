<?php

class EntryYear {
    private int $student_id;
    private int $schoolYear_id;

    private array $validations;

    public function __construct(int $studentId, int $schoolYearId) {
        $this->student_id = $studentId;
        $this->schoolYear_id = $schoolYearId;
        $this->setValidations();
    }

    private function setValidations() {
        $this->validations = array(
            'Identifiant Elève' => [],
            "Identifiant Année d'entrée" => []
        );
    }

    public function getValidations() {
        return $this->validations;
    }

    public function getModel() { return array(
        "studentId" => $this->student_id,
        "schoolYearId" => $this->schoolYear_id
    ); }
}