<?php

class Event {
    private int $_id;
    private string $title;
    private string $type;
    private string $description;
    private string $createdAt;

    private array $validations;

    public function __construct(array $student) {
        $this->setModel($student);
        $this->setValidations();
    }

    private function setModel(array $student) {
        $this->title = $student['title'];
        $this->type = $student['type'];
        $this->description = $student['description'];
    }

    private function setValidations() {
        $this->validations = array(
            'Nom' => [minLength($this->title, 2)],
            'Type' => [amongValues($this->type, ["JPO", "Entretien", "Visite", "Autre"])],
            'Description' => [maxLength($this->description, 256)]
        );
    }

    public function getValidations() {
        return $this->validations;
    }
}