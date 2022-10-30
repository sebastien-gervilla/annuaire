<?php

class Specialization {
    private int $_id;
    private string $title;

    private array $specialization;
    private array $validations;

    public function __construct(array $specialization) {
        $this->setModel($specialization);
        $this->setValidations();
    }

    private function setModel(array $specialization) {
        $this->title = $specialization['title'];
        $this->specialization = $specialization;
    }

    private function setValidations() {
        $this->validations = array(
            'Titre' => [minLength($this->title, 5), validChars($this->title)]
        );
    }

    public function getValidations() {
        return $this->validations;
    }

    public function getModel() { return $this->specialization; }
}