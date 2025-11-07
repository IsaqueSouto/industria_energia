CREATE DATABASE IF NOT EXISTS producao_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE producao_db;

CREATE TABLE IF NOT EXISTS producao_industrial (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dia INT NOT NULL,
  horas_trabalhadas INT NOT NULL,
  consumo_kwh INT NOT NULL
);

INSERT INTO producao_industrial (dia, horas_trabalhadas, consumo_kwh) VALUES
(1, 8, 1150),
(2, 7, 980),
(3, 9, 1320),
(4, 6, 890),
(5, 8, 1100),
(6, 10, 1450),
(7, 5, 760),
(8, 9, 1280),
(9, 7, 970),
(10, 8, 1185);
