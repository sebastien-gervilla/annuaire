<?php

class Event {
    private int $_id;
    private string $title;
    private string $type;
    private string $date;
    private string $description;

    private array $event;
    private array $validations;

    public function __construct(array $event) {
        $this->setModel($event);
        $this->setValidations();
    }

    private function setModel(array $event) {
        $this->title = $event['title'];
        $this->type = $event['type'];
        $this->date = $event['date'];
        $this->description = $event['description'];
        $this->event = $event;
    }

    private function setValidations() {
        $this->validations = array(
            'Nom' => [minLength($this->title, 2), validChars($this->title)],
            'Type' => [amongValues($this->type, ["JPO", "Entretien", "Visite", "Autre"])],
            'Date' => [maxLength($this->date, 64)],
            'Description' => [maxLength($this->description, 256)]
        );
    }

    public function getValidations() {
        return $this->validations;
    }

    public function getModel() { return $this->event; }
}