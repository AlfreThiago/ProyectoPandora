SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;
-- Drop triggers if they exist
DROP TRIGGER IF EXISTS trigger_insertar_usuario_por_rol;
DROP TRIGGER IF EXISTS trigger_actualizar_usuario_por_rol;
-- Drop tables in reverse dependency order
DROP TABLE IF EXISTS item_ticket;
DROP TABLE IF EXISTS inventarios;
DROP TABLE IF EXISTS dispositivos;
DROP TABLE IF EXISTS tickets;
DROP TABLE IF EXISTS administradores;
DROP TABLE IF EXISTS supervisores;
DROP TABLE IF EXISTS tecnicos;
DROP TABLE IF EXISTS clientes;
DROP TABLE IF EXISTS historial;
DROP TABLE IF EXISTS estados_tickets;
DROP TABLE IF EXISTS categorias_inventario;
DROP TABLE IF EXISTS categorias;
DROP TABLE IF EXISTS areas;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;
-- ----------------------
-- Create base tables
-- ----------------------
CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    `NAME` VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    `PASSWORD` VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    direccion VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    role ENUM(
        'Cliente',
        'Tecnico',
        'Supervisor',
        'Administrador'
    ) NOT NULL DEFAULT 'Cliente',
    PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE TABLE areas (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- ----------------------
-- Per-role tables
-- ----------------------
CREATE TABLE clientes (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    num_ordenes INT DEFAULT 0,
    estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    PRIMARY KEY (id),
    UNIQUE KEY uq_clientes_user (user_id),
    CONSTRAINT fk_clientes_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE TABLE tecnicos (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    disponibilidad ENUM('Disponible', 'Ocupado') DEFAULT 'Disponible',
    especialidad VARCHAR(100),
    ticket_count INT DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY uq_tecnicos_user (user_id),
    CONSTRAINT fk_tecnicos_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE TABLE supervisores (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    area_id INT NULL,
    num_tecnicos INT DEFAULT 0,
    estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    PRIMARY KEY (id),
    UNIQUE KEY uq_supervisores_user (user_id),
    CONSTRAINT fk_supervisores_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_supervisores_area FOREIGN KEY (area_id) REFERENCES areas(id) ON DELETE
    SET NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE TABLE administradores (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_admins_user (user_id),
    CONSTRAINT fk_admins_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- ----------------------
-- Catalog tables
-- ----------------------
CREATE TABLE categorias (
    id INT NOT NULL AUTO_INCREMENT,
    `NAME` VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE TABLE categorias_inventario (
    id INT NOT NULL AUTO_INCREMENT,
    `NAME` VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE TABLE estados_tickets (
    id INT NOT NULL AUTO_INCREMENT,
    `NAME` VARCHAR(50) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_estados_name (`NAME`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- ----------------------
-- Core entities
-- ----------------------
CREATE TABLE tickets (
    id INT NOT NULL AUTO_INCREMENT,
    cliente_id INT NOT NULL,
    tecnico_id INT NULL,
    supervisor_id INT NULL,
    estado_id INT NOT NULL,
    descripcion TEXT NOT NULL,
    prioridad ENUM('Baja', 'Media', 'Alta') DEFAULT 'Media',
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_cierre DATETIME NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_tickets_cliente FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
    CONSTRAINT fk_tickets_tecnico FOREIGN KEY (tecnico_id) REFERENCES tecnicos(id) ON DELETE
    SET NULL,
        CONSTRAINT fk_tickets_supervisor FOREIGN KEY (supervisor_id) REFERENCES supervisores(id) ON DELETE
    SET NULL,
        CONSTRAINT fk_tickets_estado FOREIGN KEY (estado_id) REFERENCES estados_tickets(id) ON DELETE RESTRICT
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE TABLE dispositivos (
    id INT NOT NULL AUTO_INCREMENT,
    cliente_id INT NOT NULL,
    categoria_id INT NOT NULL,
    marca VARCHAR(50),
    modelo VARCHAR(50),
    numero_serie VARCHAR(50),
    descripcion_falla TEXT,
    foto_dispositivo VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_dispositivos_cliente FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
    CONSTRAINT fk_dispositivos_categoria FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE TABLE inventarios (
    id INT NOT NULL AUTO_INCREMENT,
    categoria_id INT NOT NULL,
    name_item VARCHAR(100) NOT NULL,
    valor_unitario DECIMAL(10, 2) NOT NULL,
    descripcion TEXT,
    stock_actual INT NOT NULL DEFAULT 0,
    stock_minimo INT NOT NULL DEFAULT 0,
    foto_item VARCHAR(255),
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    CONSTRAINT fk_inventarios_categoria FOREIGN KEY (categoria_id) REFERENCES categorias_inventario(id) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE TABLE item_ticket (
    id INT NOT NULL AUTO_INCREMENT,
    ticket_id INT NOT NULL,
    inventario_id INT NOT NULL,
    tecnico_id INT NOT NULL,
    supervisor_id INT NOT NULL,
    cantidad INT NOT NULL DEFAULT 1,
    valor_total DECIMAL(10, 2) NOT NULL,
    fecha_asignacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    CONSTRAINT fk_item_ticket_ticket FOREIGN KEY (ticket_id) REFERENCES tickets(id) ON DELETE CASCADE,
    CONSTRAINT fk_item_ticket_inventario FOREIGN KEY (inventario_id) REFERENCES inventarios(id) ON DELETE CASCADE,
    CONSTRAINT fk_item_ticket_tecnico FOREIGN KEY (tecnico_id) REFERENCES tecnicos(id) ON DELETE CASCADE,
    CONSTRAINT fk_item_ticket_supervisor FOREIGN KEY (supervisor_id) REFERENCES supervisores(id) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE TABLE historial (
    id INT NOT NULL AUTO_INCREMENT,
    acciones VARCHAR(255) NOT NULL,
    detalles TEXT,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- ----------------------
-- Triggers
-- ----------------------
DELIMITER $$ CREATE TRIGGER trigger_insertar_usuario_por_rol
AFTER
INSERT ON users FOR EACH ROW BEGIN IF NEW.role = 'Cliente' THEN
INSERT INTO clientes (user_id)
VALUES (NEW.id);
ELSEIF NEW.role = 'Tecnico' THEN
INSERT INTO tecnicos (user_id, disponibilidad)
VALUES (NEW.id, 'Disponible');
ELSEIF NEW.role = 'Supervisor' THEN
INSERT INTO supervisores (user_id)
VALUES (NEW.id);
ELSEIF NEW.role = 'Administrador' THEN
INSERT INTO administradores (user_id)
VALUES (NEW.id);
END IF;
END $$ CREATE TRIGGER trigger_actualizar_usuario_por_rol
AFTER
UPDATE ON users FOR EACH ROW BEGIN IF OLD.role <> NEW.role THEN IF OLD.role = 'Cliente' THEN
DELETE FROM clientes
WHERE user_id = OLD.id;
ELSEIF OLD.role = 'Tecnico' THEN
DELETE FROM tecnicos
WHERE user_id = OLD.id;
ELSEIF OLD.role = 'Supervisor' THEN
DELETE FROM supervisores
WHERE user_id = OLD.id;
ELSEIF OLD.role = 'Administrador' THEN
DELETE FROM administradores
WHERE user_id = OLD.id;
END IF;
IF NEW.role = 'Cliente' THEN
INSERT INTO clientes (user_id)
VALUES (NEW.id);
ELSEIF NEW.role = 'Tecnico' THEN
INSERT INTO tecnicos (user_id, disponibilidad)
VALUES (NEW.id, 'Disponible');
ELSEIF NEW.role = 'Supervisor' THEN
INSERT INTO supervisores (user_id)
VALUES (NEW.id);
ELSEIF NEW.role = 'Administrador' THEN
INSERT INTO administradores (user_id)
VALUES (NEW.id);
END IF;
END IF;
END $$ DELIMITER;