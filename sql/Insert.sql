-- Inserciones para la tabla 'level'
INSERT INTO level (xp_necesario, nombre) VALUES
(0, 'Trainee'),
(100, 'Aprendiz'),
(500, 'Junior'),
(1000, 'Script Kiddie'),
(2000, 'Intermedio'),
(4000, 'Especialista'),
(8000, 'Avanzado'),
(16000, 'Pentester'),
(32000, 'Experto'),
(64000, 'Hacker');



-- Inserciones para la tabla 'tipo'
INSERT INTO tipo (vulnerabilidad) VALUES
('xss'),
('sql_injection');

-- Inserciones para la tabla 'labs'
INSERT INTO labs (nombre_lab, xp_otorgado, descripcion, level_necesario, tipo_id, dificultad) VALUES
('SQL Injection', 150, 'Laboratorio para aprender y practicar SQL Injection', 1, 2, 'Facil'),
('XSS', 150, 'Laboratorio para aprender y practicar XSS', 1, 1, 'Facil');

-- Inserciones para la tabla 'user'
INSERT INTO user (name, email, username, password, xp_total, rol_id) VALUES
('Tomas Kugelmann', 'totookmann@gmail.com', 'totokmann', '123', 64000, 2),
('Angelina Kornel', 'angiek@gmail.com', 'anyik', '123', 0, 1);

DELIMITER $$

CREATE TRIGGER after_user_login
AFTER UPDATE ON user
FOR EACH ROW
BEGIN
    -- Verificamos si el valor de 'logged_in' cambió a 1
    IF NEW.logged_in = 1 AND OLD.logged_in = 0 THEN
        -- Insertamos el registro en 'login_history' para el usuario que ha iniciado sesión
        INSERT INTO login_history (user_id, login_time) 
        VALUES (NEW.user_id, NOW());
    END IF;
END $$

DELIMITER ;

DELIMITER //

CREATE TRIGGER actualizar_xp_y_nivel
AFTER UPDATE ON user_labs
FOR EACH ROW
BEGIN
    -- Verificar si el estado se ha cambiado a 'completado'
    IF NEW.estado = 'completado' THEN
        -- Actualizar el xp_total del usuario sumando la experiencia del laboratorio completado
        UPDATE user 
        SET xp_total = xp_total + (SELECT xp_otorgado FROM labs WHERE labs_id = NEW.labs_id)
        WHERE user_id = NEW.user_id;

        -- Calcular y actualizar el nuevo nivel del usuario basándose en el xp_total actualizado
        UPDATE user 
        SET level_id = (
            SELECT level_id 
            FROM level 
            WHERE xp_necesario <= xp_total
            ORDER BY xp_necesario DESC
            LIMIT 1
        )
        WHERE user_id = NEW.user_id;
    END IF;
END;
//

DELIMITER ;



select * from login_history;
select * from user;
select * from labs;
select * from user_labs;