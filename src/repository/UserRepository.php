<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        return new User(
            $user['id'],
            $user['email'],
            $user['password'],
            $user['name'],
            $user['surname'],
            $user['is_admin']
        );
    }

    public function createUser(string $email, string $password, string $name, string $surname): bool
    {
        try {
            // Przygotowanie zapytania SQL
            $stmt = $this->database->connect()->prepare('
            INSERT INTO users (email, password, name, surname) 
            VALUES (:email, :password, :name, :surname)
        ');

            // Hashowanie hasła dla bezpieczeństwa
            // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);


            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Error creating user: ' . $e->getMessage());
            return false;
        }
    }

    public function getAllUsers(): array
    {
        $stmt = $this->database->connect()->prepare('
        SELECT id, email, name, surname, is_admin
        FROM users
    ');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Tablica asocjacyjna użytkowników
    }
    public function deleteUserById(int $userId): bool
    {
        try {
            $stmt = $this->database->connect()->prepare('
            DELETE FROM users WHERE id = :userId
        ');
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Failed to delete user: " . $e->getMessage());
            return false;
        }
    }


}