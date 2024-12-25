CREATE DATABASE tienda;
USE tienda;

CREATE TABLE clientes (
    id_clientes INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    direccion VARCHAR(200)
);

CREATE TABLE productos (
    id_productos INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL
);
ALTER TABLE productos 
ADD COLUMN cantidad_disponible INT NOT NULL DEFAULT 0;

CREATE TABLE compras (
    id_compras INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    producto_id INT,
    cantidad INT,
    precio_total DECIMAL(10,2),
    fecha_compra DATETIME,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id_clientes),
    FOREIGN KEY (producto_id) REFERENCES productos(id_productos)
);

