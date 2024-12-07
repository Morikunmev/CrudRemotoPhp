CREATE TABLE datos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    contacto VARCHAR(15) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
);

CREATE TABLE datos_esp (
    id INT AUTO_INCREMENT PRIMARY KEY,
    valor_unico VARCHAR(36) DEFAULT (UUID()),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);