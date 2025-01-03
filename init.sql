-- Tworzenie tabeli users kompatybilnej z klasą User
CREATE TABLE users (
    id SERIAL PRIMARY KEY,          -- Unikalny identyfikator użytkownika
    email VARCHAR(255) NOT NULL UNIQUE,  -- Adres e-mail (unikalny)
    password VARCHAR(255) NOT NULL,      -- Hasło użytkownika
    name VARCHAR(100) NOT NULL,          -- Imię użytkownika
    surname VARCHAR(100) NOT NULL,       -- Nazwisko użytkownika
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Data utworzenia rekordu
);

-- Dodanie przykładowych użytkowników
INSERT INTO users (email, password, name, surname)
VALUES
('jsnow@pk.edu.pl', '$2y$10$hashed_password_here', 'John', 'Snow');
-- haslo to password123

