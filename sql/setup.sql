DROP DATABASE IF EXISTS contacts_app_reto1;

CREATE DATABASE contacts_app_reto1;

USE contacts_app_reto1;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255)
);

CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    user_id INT NOT NULL,
    phone_number VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE adresses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    adress VARCHAR(255),
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES contacts(id)
);

-- Inserciones para cada una de las tablas de la base de datos
INSERT INTO users (name, email, password) VALUES ("Juan", "juanp@test.com", "buenas");

INSERT INTO users (name, email, password) VALUES ("Pedro", "pedrop@test.com", "tardes");

INSERT INTO contacts (name, user_id, phone_number) VALUES ("Pedrito", 1, "456123789");

INSERT INTO contacts (name, user_id, phone_number) VALUES ("Maria", 1, "987321654");

INSERT INTO contacts (name, user_id, phone_number) VALUES ("Antonio", 2, "963471852");

INSERT INTO contacts (name, user_id, phone_number) VALUES ("Pepe", 2, "258963741");

INSERT INTO adresses (adress, user_id) VALUES ("Calle Pedrito", 1);

INSERT INTO adresses (adress, user_id) VALUES ("Calle Pedrito 2", 1);

INSERT INTO adresses (adress, user_id) VALUES ("Calle Maria", 2);

INSERT INTO adresses (adress, user_id) VALUES ("Calle Antonio", 3);

INSERT INTO adresses (adress, user_id) VALUES ("Calle Pepe", 4);
