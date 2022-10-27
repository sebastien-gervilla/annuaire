<?php

class User {
    private int $_id;
    private string $fname;
    private string $lname;
    private string $email;
    private string $password;

    private array $validations;

    public function __construct(array $user) {
        $this->setModel($user);
        $this->setValidations();
    }

    private function setModel(array $user) {
        $this->fname = $user['fname'];
        $this->lname = $user['lname'];
        $this->email = $user['email'];
        $this->password = $user['password'];
    }

    private function setValidations() {
        $this->validations = array(
            'Email' => [validEmail($this->email)],
            'Mot de passe' => [minLength($this->password, 8)]
        );
    }

    public function hashPassword() {
        if (!$this->password) return;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function getValidations() {
        return $this->validations;
    }

    public function getModel() { 
        return array(
            'fname' => $this->fname,
            'lname' => $this->lname,
            'email' => $this->email,
            'password' => $this->password
        ); 
    }
}