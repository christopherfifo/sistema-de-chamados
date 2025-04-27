CREATE DATABASE IF NOT EXISTS bdlojinha2000;
USE bdlojinha2000;

CREATE TABLE tbvendedor(
	codvend INT PRIMARY KEY AUTO_INCREMENT,
    vendedor VARCHAR(90) NOT NULL
);

CREATE TABLE tbcliente(
	codcli INT PRIMARY KEY AUTO_INCREMENT,
    cliente VARCHAR(90) NOT NULL,
    cpf VARCHAR(20),
    codvendedor INT,
    FOREIGN KEY(codvendedor) REFERENCES tbvendedor(codvend)
);

INSERT INTO tbvendedor(vendedor) VALUE ('Vendedor 1');

Drop DATABASE bdlojinha2000;

SELECT * FROM tbcliente;
SELECT * FROM tbvendedor;