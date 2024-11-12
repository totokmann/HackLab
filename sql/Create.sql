-- Crear base de datos
CREATE DATABASE hacklab;
-- Seleccionar la base de datos
USE hacklab;

SET SQL_SAFE_UPDATES = 0;

-- Crear tabla 'level'
CREATE TABLE level (
    level_id INT AUTO_INCREMENT PRIMARY KEY,
    xp_necesario INT NOT NULL,
    nombre VARCHAR(50) NOT NULL
);

-- Crear tabla 'rol'
CREATE TABLE rol (
    rol_id INT AUTO_INCREMENT PRIMARY KEY,
    rol VARCHAR(50) NOT NULL
);


-- Crear tabla 'user'
CREATE TABLE user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    xp_total INT,
    level_id INT,
    rol_id INT,
    logged_in TINYINT DEFAULT 0,
    FOREIGN KEY (level_id) REFERENCES level(level_id),
    FOREIGN KEY (rol_id) REFERENCES rol(rol_id)
);

-- Crear tabla 'tipo'
CREATE TABLE tipo (
    tipo_id INT AUTO_INCREMENT PRIMARY KEY,
    vulnerabilidad VARCHAR(100) NOT NULL
);

-- Crear tabla 'labs'
CREATE TABLE labs (
    labs_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_lab VARCHAR(100) NOT NULL,
    xp_otorgado INT NOT NULL,
    descripcion TEXT,
    level_necesario INT,
	dificultad VARCHAR(50) NOT NULL,
    tipo_id INT,
    FOREIGN KEY (level_necesario) REFERENCES level(level_id),
    FOREIGN KEY (tipo_id) REFERENCES tipo(tipo_id)
);

-- Crear tabla de unión 'user_labs' entre 'user' y 'labs'
CREATE TABLE user_labs (
    user_labs_id INT AUTO_INCREMENT PRIMARY KEY,
    estado VARCHAR(50),
    user_id INT,
    labs_id INT,
    FOREIGN KEY (user_id) REFERENCES user(user_id),
    FOREIGN KEY (labs_id) REFERENCES labs(labs_id)
);


-- Crear tabla 'login_history'
CREATE TABLE login_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(user_id)
);
