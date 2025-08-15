CREATE TABLE users(
    id INT(11) NOT NULL AUTO_INCREMENT,
    NAME VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    PASSWORD VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    direccion VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    role ENUM(
        'Cliente',
        'Tecnico',
        'Supervisor',
        'Administrador'
    ) NOT NULL DEFAULT 'Cliente',
    PRIMARY KEY(id)
);
CREATE TABLE clientes(
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    num_ordenes INT(11) DEFAULT 0,
    estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE tecnicos(
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    disponibilidad ENUM('Disponible', 'Ocupado') DEFAULT 'Disponible',
    especialidad VARCHAR(100),
    ticket_count INT(11) DEFAULT 0,
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE supervisores(
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    AREA VARCHAR(100),
    num_tecnicos INT(11) DEFAULT 0,
    estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY(AREA) REFERENCES areas(NAME) ON DELETE
    SET NULL
);
CREATE TABLE areas(
    id INT(11) NOT NULL AUTO_INCREMENT,
    NAME VARCHAR(100) NOT NULL,
    PRIMARY KEY(id)
);
CREATE TABLE administradores(
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE tickets(
    id INT(11) NOT NULL AUTO_INCREMENT,
    cliente_id INT(11) NOT NULL,
    tecnico_id INT(11),
    Supervisor_id INT(11),
    estado_id INT(11) NOT NULL,
    descripcion TEXT NOT NULL,
    prioridad ENUM('Baja', 'Media', 'Alta') DEFAULT 'Media',
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_cierre DATETIME,
    PRIMARY KEY(id),
    FOREIGN KEY(cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
    FOREIGN KEY(tecnico_id) REFERENCES tecnicos(id) ON DELETE
    SET NULL,
        FOREIGN KEY(Supervisor_id) REFERENCES supervisores(id) ON DELETE
    SET NULL
);
CREATE TABLE estados_tickets(
    id INT(11) NOT NULL AUTO_INCREMENT,
    NAME VARCHAR(50) NOT NULL
);
CREATE TABLE dispositivos(
    id INT(11) NOT NULL AUTO_INCREMENT,
    cliente_id INT(11) NOT NULL,
    categoria_id INT(11) NOT NULL,
    marca VARCHAR(50),
    modelo VARCHAR(50),
    numero_serie VARCHAR(50),
    descripcion_falla TEXT,
    PRIMARY KEY(id),
    FOREIGN KEY(cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
    FOREIGN KEY(categoria_id) REFERENCES categorias(id) ON DELETE CASCADE
);
CREATE TABLE categorias(
    id INT(11) NOT NULL AUTO_INCREMENT,
    NAME VARCHAR(50) NOT NULL,
    PRIMARY KEY(id)
);
CREATE TABLE inventarios(
    id INT(11) NOT NULL AUTO_INCREMENT,
    categoria_id INT(11) NOT NULL,
    name_item VARCHAR(100) NOT NULL,
    valor_unitario DECIMAL(10, 2) NOT NULL,
    descripcion TEXT,
    stock_actual INT(11) NOT NULL DEFAULT 0,
    stock_minimo INT(11) NOT NULL DEFAULT 0,
    foto_item VARCHAR(255),
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    FOREIGN KEY(categoria_id) REFERENCES categorias_inventario(id) ON DELETE CASCADE
);
CREATE TABLE categorias_inventario(
    id INT(11) NOT NULL AUTO_INCREMENT,
    NAME VARCHAR(50) NOT NULL,
    PRIMARY KEY(id)
);
CREATE TABLE item_ticket(
    id INT(11) NOT NULL AUTO_INCREMENT,
    ticket_id INT(11) NOT NULL,
    inventario_id INT(11) NOT NULL,
    tecnico_id INT(11) NOT NULL,
    Supervisor_id INT(11) NOT NULL,
    cantidad INT(11) NOT NULL DEFAULT 1,
    valor_total DECIMAL(10, 2) NOT NULL,
    fecha_asignacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    cantidad INT(11) NOT NULL DEFAULT 1,
    PRIMARY KEY(id),
    FOREIGN KEY(ticket_id) REFERENCES tickets(id) ON DELETE CASCADE,
    FOREIGN KEY(inventario_id) REFERENCES inventarios(id) ON DELETE CASCADE,
    FOREIGN KEY(tecnico_id) REFERENCES tecnicos(id) ON DELETE CASCADE,
    FOREIGN KEY(Supervisor_id) REFERENCES supervisores(id) ON DELETE CASCADE
);
CREATE TABLE historial(
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    acciones VARCHAR(255) NOT NULL,
    detalles TEXT,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP
);
DELIMITER $$ CREATE TRIGGER trigger_insertar_usuario_por_rol
AFTER
INSERT ON users FOR EACH ROW BEGIN IF NEW.role = 'Cliente' THEN
INSERT INTO clientes(user_id)
VALUES(NEW.id);
ELSEIF NEW.role = 'Tecnico' THEN
INSERT INTO tecnicos(user_id, disponibilidad)
VALUES(NEW.id, 'Disponible');
ELSEIF NEW.role = 'Supervisor' THEN
INSERT INTO supervisores(user_id)
VALUES(NEW.id);
ELSEIF NEW.role = 'Administrador' THEN
INSERT INTO administradores(user_id)
VALUES(NEW.id);
END IF;
END $$ DELIMITER;
DELIMITER $$ CREATE TRIGGER trigger_actualizar_usuario_por_rol
AFTER
UPDATE ON users FOR EACH ROW BEGIN IF OLD.role = 'Cliente' THEN
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
INSERT INTO clientes(user_id)
VALUES(NEW.id);
ELSEIF NEW.role = 'Tecnico' THEN
INSERT INTO tecnicos(user_id, disponibilidad)
VALUES(NEW.id, 'Disponible');
ELSEIF NEW.role = 'Supervisor' THEN
INSERT INTO supervisores(user_id)
VALUES(NEW.id);
ELSEIF NEW.role = 'Administrador' THEN
INSERT INTO administradores(user_id)
VALUES(NEW.id);
END IF;
END $$ DELIMITER;