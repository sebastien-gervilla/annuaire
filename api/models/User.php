<?php

class User {
    private int $_id;
    private string $email;
    private string $password;

    private array $user;
    private array $validations;

    public function __construct(array $user) {
        $this->setModel($user);
        $this->setValidations();
    }

    private function setModel(array $user) {
        $this->email = $user['email'];
        $this->password = $user['password'];
        $this->user = $user;
    }

    private function setValidations() {
        $this->validations = array(
            'Email' => [validEmail($this->email)],
            'Mot de passe' => [minLength($this->password, 10)]
        );
    }

    public function getValidations() {
        return $this->validations;
    }

    public function getModel() { return $this->user; }
}