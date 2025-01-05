-- Tworzenie tabeli użytkowników
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,               -- Unikalny identyfikator użytkownika
    email VARCHAR(255) NOT NULL UNIQUE,  -- Adres e-mail (unikalny)
    password VARCHAR(255) NOT NULL,      -- Hasło użytkownika
    name VARCHAR(100) NOT NULL,          -- Imię użytkownika
    surname VARCHAR(100) NOT NULL,       -- Nazwisko użytkownika
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Data utworzenia konta
);

-- Tworzenie tabeli filmów
CREATE TABLE IF NOT EXISTS movies (
    id SERIAL PRIMARY KEY,               -- Unikalny identyfikator filmu
    title VARCHAR(255) NOT NULL,         -- Tytuł filmu
    description TEXT,                    -- Opis filmu
    release_date DATE NOT NULL           -- Data premiery
);

-- Tworzenie tabeli seansów
CREATE TABLE IF NOT EXISTS screenings (
    id SERIAL PRIMARY KEY,               -- Unikalny identyfikator seansu
    movie_id INT NOT NULL,               -- Powiązanie z filmem
    screening_time TIMESTAMP NOT NULL,   -- Data i godzina seansu
    room_number INT NOT NULL,            -- Numer sali
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
);

-- Tworzenie tabeli miejsc w salach kinowych
CREATE TABLE IF NOT EXISTS seats (
    id SERIAL PRIMARY KEY,               -- Unikalny identyfikator miejsca
    room_number INT NOT NULL,            -- Numer sali
    seat_row INT NOT NULL,               -- Rząd w sali
    seat_number INT NOT NULL,            -- Numer miejsca w rzędzie
    UNIQUE (room_number, seat_row, seat_number) -- Unikalność miejsca w danej sali
);

-- Tworzenie tabeli rezerwacji
CREATE TABLE IF NOT EXISTS reservations (
    id SERIAL PRIMARY KEY,               -- Unikalny identyfikator rezerwacji
    user_id INT NOT NULL,                -- Powiązanie z użytkownikiem
    screening_id INT NOT NULL,           -- Powiązanie z seansem
    seat_id INT NOT NULL,                -- Powiązanie z miejscem
    reservation_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Data i godzina rezerwacji
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (screening_id) REFERENCES screenings(id) ON DELETE CASCADE,
    FOREIGN KEY (seat_id) REFERENCES seats(id) ON DELETE CASCADE,
    UNIQUE (screening_id, seat_id)       -- Unikalność miejsca na danym seansie
);

-- Przykładowi użytkownicy
INSERT INTO users (email, password, name, surname) VALUES
('john.doe@example.com', 'password123', 'John', 'Doe'),
('jane.smith@example.com', 'password456', 'Jane', 'Smith');

-- Przykładowe filmy
INSERT INTO movies (title, description, release_date) VALUES
('Avengers: Endgame', 'Superhero movie by Marvel', '2019-04-26'),
('Inception', 'Mind-bending thriller by Christopher Nolan', '2010-07-16');

-- Przykładowe seanse
INSERT INTO screenings (movie_id, screening_time, room_number) VALUES
(1, '2025-01-05 18:00:00', 1),
(1, '2025-01-05 21:00:00', 1),
(2, '2025-01-06 20:00:00', 2);

-- Przykładowe miejsca w salach kinowych
INSERT INTO seats (room_number, seat_row, seat_number) VALUES
(1, 1, 1), (1, 1, 2), (1, 1, 3),
(1, 2, 1), (1, 2, 2), (1, 2, 3),
(2, 1, 1), (2, 1, 2), (2, 1, 3);

-- Przykładowe rezerwacje
INSERT INTO reservations (user_id, screening_id, seat_id) VALUES
(1, 1, 1), -- Rezerwacja użytkownika 1 na seans 1, miejsce 1
(2, 1, 2); -- Rezerwacja użytkownika 2 na seans 1, miejsce 2
