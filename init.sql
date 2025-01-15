-- Tworzenie tabeli użytkowników
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,               -- Unikalny identyfikator użytkownika
    email VARCHAR(255) NOT NULL UNIQUE,  -- Adres e-mail (unikalny)
    password VARCHAR(255) NOT NULL,      -- Hasło użytkownika
    name VARCHAR(100) NOT NULL,          -- Imię użytkownika
    surname VARCHAR(100) NOT NULL,       -- Nazwisko użytkownika
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Data utworzenia konta
    is_admin BOOLEAN DEFAULT FALSE       -- Flaga: czy użytkownik jest administratorem
);

-- Tworzenie tabeli filmów
CREATE TABLE IF NOT EXISTS movies (
    id SERIAL PRIMARY KEY,               -- Unikalny identyfikator filmu
    title VARCHAR(255) NOT NULL,         -- Tytuł filmu
    description TEXT,                    -- Opis filmu
    release_date DATE NOT NULL,          -- Data premiery
    file VARCHAR(255) NOT NULL DEFAULT 'default.png' -- Nazwa pliku powiązanego z filmem
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

CREATE OR REPLACE FUNCTION delete_user_reservations() RETURNS TRIGGER AS $$
BEGIN
    DELETE FROM reservations WHERE user_id = OLD.id;
    RETURN OLD;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_delete_user_reservations
AFTER DELETE ON users
FOR EACH ROW
EXECUTE FUNCTION delete_user_reservations();


-- Przykładowi użytkownicy
-- Przykładowi użytkownicy
INSERT INTO users (email, password, name, surname, is_admin) VALUES
('john.doe@example.com', 'password123', 'John', 'Doe', true),  -- Admin
('jane.smith@example.com', 'password456', 'Jane', 'Smith', false); -- Zwykły użytkownik

-- Przykładowe filmy
INSERT INTO movies (title, description, release_date,file) VALUES
('Spider-man:homecoming', 'Superhero movie by Marvel', '2019-04-26','film-card1.jpeg'),
('Taxi driver', 'Mind-bending thriller about american taxi driver', '1979-07-16','film-card2.jpeg'),
('American Psycho', 'horror movie about corporate psycho', '1999-07-16','film-card4.jpeg');

-- Przykładowe seanse
INSERT INTO screenings (movie_id, screening_time, room_number) VALUES
(1, '2025-01-05 18:00:00', 1),
(1, '2025-01-05 21:00:00', 1),
(2, '2025-01-06 20:00:00', 2);


-- Dodawanie miejsc do tabeli seats
DO $$
BEGIN
    -- Iteracja po numerach sal
    FOR room_number IN 1..12 LOOP
        -- Iteracja po rzędach
        FOR seat_row IN 1..6 LOOP
            -- Iteracja po miejscach w rzędzie
            FOR seat_number IN 1..12 LOOP
                -- Wstawienie miejsca do tabeli
                INSERT INTO seats (room_number, seat_row, seat_number)
                VALUES (room_number, seat_row, seat_number);
            END LOOP;
        END LOOP;
    END LOOP;
END $$;

-- Przykładowe rezerwacje
INSERT INTO reservations (user_id, screening_id, seat_id) VALUES
(1, 1, 1), -- Rezerwacja użytkownika 1 na seans 1, miejsce 1
(2, 1, 2); -- Rezerwacja użytkownika 2 na seans 1, miejsce 2
