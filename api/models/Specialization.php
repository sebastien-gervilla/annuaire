<?php

class Specialization {
    private int $_id;
    private string $title;
    private string $abbreviation;
    private string $color;
    private string $contrast;

    private array $specialization;
    private array $validations;

    public function __construct(array $specialization) {
        $this->setModel($specialization);
        $this->setValidations();
    }

    private function setModel(array $specialization) {
        $this->title = $specialization['title'];
        $this->abbreviation = $specialization['abbreviation'];
        $this->color = $specialization['color'];
        $this->contrast = $specialization['contrast'];
        $this->specialization = $specialization;
    }

    private function setValidations() {
        $this->validations = array(
            'Titre' => [minLength($this->title, 5), validChars($this->title)],
            'Abbréviation' => [betweenLengths($this->abbreviation, 2, 16), validChars($this->abbreviation)],
            'Coleur' => [betweenLengths($this->color, 4, 7)],
            'Contraste' => [amongValues($this->contrast, ['Noir', 'Blanc'])]
        );
    }

    public function getValidations() {
        return $this->validations;
    }

    public function getModel() { return $this->specialization; }
}