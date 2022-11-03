<?php

class SchoolYear {
    private int $_id;
    private string $title;

    private array $schoolYear;
    private array $validations;

    public function __construct(array $schoolYear) {
        $this->setModel($schoolYear);
        $this->setValidations();
    }

    private function setModel(array $schoolYear) {
        $this->title = $schoolYear['title'];
        $this->schoolYear = $schoolYear;
    }

    private function setValidations() {
        $this->validations = array(
            'Titre' => [minLength($this->title, 5)]
        );
    }

    public function getValidations() {
        return $this->validations;
    }

    public function getModel() { return $this->schoolYear; }
}