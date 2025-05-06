CREATE DATABASE IF NOT EXISTS technical_enterprise DEFAULT CHARACTER SET utf8;

USE technical_enterprise;

CREATE TABLE IF NOT EXISTS Users(
    id INT AUTO_INCREMENT primary key,
    name VARCHAR(255) NOT NULL,
    cpf VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    telephone VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    tipo VARCHAR(255) NOT NULL DEFAULT 'user',
    estatus VARCHAR(255) NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Technicians(
    id INT AUTO_INCREMENT primary key,
    name VARCHAR(255) NOT NULL,
    cpf VARCHAR(255) NOT NULL UNIQUE,
    matricula VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    telephone VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    tipo VARCHAR(255) NOT NULL DEFAULT 'technicians',
    estatus VARCHAR(255) NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Calleds(
    id INT AUTO_INCREMENT primary key,
    id_user INT NOT NULL,
    code_called INT NOT NULL UNIQUE,
    description VARCHAR(255) NOT NULL,
    estatus VARCHAR(255) NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES Users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Calleds_technicians(
    id INT AUTO_INCREMENT primary key,
    id_called INT NOT NULL,
    id_technician INT NOT NULL,
    matricula_technician VARCHAR(255) NOT NULL,
    description VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_called) REFERENCES Calleds(id) ON DELETE CASCADE,
    FOREIGN KEY (id_technician) REFERENCES Technicians(id) ON DELETE CASCADE
);

-- ALTER TABLE Users DROP COLUMN cpf;

-- 1. Inserir usuários
INSERT INTO Users (name, cpf, email, telephone, password) VALUES
('Lucas', '12345678900', 'email@gmail.com', '11987654321', '123456'),
('Pedro', '12345678901', 'pedro@gmail.com', '11987654322', '123456'),
('João', '12345678902', 'joao@gmail.com', '11987654323', '123456');

-- 2. Inserir técnicos
INSERT INTO Technicians (name, cpf, matricula, email, telephone, password) VALUES
('Lucas', '22345678900', '123456', 'lucas.tech@gmail.com', '11987654321', '123456'),
('Pedro', '33123455100', '33222', 'pedro.tech@gmail.com', '11987654322', '123456'),
('João', '32345678902', '123458', 'joao.tech@gmail.com', '11987654323', '123456');

-- 3. Inserir chamados com IDs de usuários existentes
INSERT INTO Calleds (id_user, code_called, description) VALUES
(1, 123456, 'Teste de chamado'),
(2, 654321, 'Teste de chamado 2'),
(3, 789012, 'Teste de chamado 3');

-- 4. Inserir relacionamento técnico/chamado
INSERT INTO Calleds_technicians (id_called, id_technician, matricula_technician, description) VALUES
(1, 1, '123456', 'Teste de chamado'),
(2, 2, '33222', 'Teste de chamado 2'),
(3, 3, '123458', 'Teste de chamado 3');