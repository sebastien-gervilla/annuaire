<?php

class Participation {
    private int $student_id;
    private int $event_id;
    private int $amount;
    private DateTime $date;

    private array $validations;

    public function __construct(int $studentId, int $eventId, int $amount = 1) {
        $this->student_id = $studentId;
        $this->event_id = $eventId;
        $this->amount = $amount;
        $this->setValidations();
    }

    private function setValidations() {
        $this->validations = array(
            'Identifiant Elève' => [],
            'Identifiant Evènement' => [],
            'Nombre de participations' => [betweenNumbers($this->amount, 1, 9)]
        );
    }

    public function getValidations() {
        return $this->validations;
    }

    public function getModel() { return array(
        "studentId" => $this->student_id,
        "eventId" => $this->event_id
    ); }
}