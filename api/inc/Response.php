<?php

class Response {
    private int $status;
    private bool $success;
    private string $message;
    private array|null $body;

    public function __construct(int $status, bool $success, string $message, array|null $body = null) {
        $this->status = $status;
        $this->success = $success;
        $this->message = $message;
        $this->body = $body;
    }

    private function setResponseHeader() {
        header('Content-type: application/json');
    }

    public function create(): array {
        $this->setResponseHeader();
        return array(
            "status" => $this->status,
            "success" => $this->success,
            "message" => $this->message,
            "body" => $this->body
        );
    }

    public function send(): string {
        return json_encode($this->create());
    }
}