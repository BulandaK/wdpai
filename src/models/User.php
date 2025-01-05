<?php

class User
{
    private $email;
    private $password;
    private $name;
    private $surname;

    public function __construct(
        int $id,
        string $email,
        string $password,
        string $name,
        string $surname
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->surname = $surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getId(): int
    {
        return $this->id;
    }

}