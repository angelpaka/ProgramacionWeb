-- Base de datos: Plataforma Web para la Gestión y Optimización del Uso de Agua en Riego
-- Importar desde phpMyAdmin (XAMPP) o ejecutar: mysql -u root < database/riego.sql
CREATE DATABASE IF NOT EXISTS riego_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE riego_db;

CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  correo VARCHAR(120) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  rol ENUM('administrador','usuario') NOT NULL DEFAULT 'usuario',
  fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS parcelas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  nombre VARCHAR(100) NOT NULL,
  ubicacion VARCHAR(150),
  area_m2 DECIMAL(10,2),
  tipo_cultivo VARCHAR(80),
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS riegos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  parcela_id INT NOT NULL,
  fecha DATE NOT NULL,
  duracion_min INT NOT NULL,
  cantidad_litros DECIMAL(10,2) NOT NULL,
  observaciones VARCHAR(255),
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (parcela_id) REFERENCES parcelas(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS alertas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  riego_id INT NOT NULL,
  mensaje VARCHAR(200) NOT NULL,
  estado ENUM('pendiente','atendida') NOT NULL DEFAULT 'pendiente',
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (riego_id) REFERENCES riegos(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Datos de prueba (la contraseña real se generará con password_hash() cuando exista el login)
INSERT INTO usuarios (nombre, correo, password_hash, rol)
VALUES ('Usuario de prueba', 'demo@riego.local', 'pendiente', 'usuario');
INSERT INTO parcelas (usuario_id, nombre, ubicacion, area_m2, tipo_cultivo) VALUES
 (1, 'Parcela Saylla 1', 'Saylla, Cusco', 1200, 'Maíz'),
 (1, 'Área verde Plaza', 'Cusco', 400, 'Césped');
INSERT INTO riegos (parcela_id, fecha, duracion_min, cantidad_litros, observaciones) VALUES
 (1, CURDATE(), 45, 900, 'Riego por aspersión'),
 (2, CURDATE(), 20, 300, 'Riego manual');
