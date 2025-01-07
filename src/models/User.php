<?php

class User
{
    private int $id;
    private string $email;
    private string $password;
    private string $name;
    private string $surname;
    private bool $is_admin;

    public function __construct(
        int $id,
        string $email,
        string $password,
        string $name,
        string $surname,
        bool $is_admin
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->surname = $surname;
        $this->is_admin = $is_admin;
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
    public function getIsAdmin(): bool
    {
        return $this->is_admin;
    }

}