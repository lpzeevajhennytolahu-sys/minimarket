CREATE TABLE Producto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    proveedor VARCHAR(100) NOT NULL,
    fecha_vencimiento DATE NOT NULL,
    precio DECIMAL(10,2) NOT NULL CHECK(precio >= 0),
    stock INT NOT NULL CHECK(stock >= 0),
    eliminado TINYINT(1) NOT NULL DEFAULT 0
);
INSERT INTO Producto (nombre, proveedor, fecha_vencimiento, precio, stock) 
VALUES ('Leche', 'Gloria', '2027-01-01', 5.50, 100);