BEGIN TRANSACTION;

--CREATE DATABASE ADIANTI_CADASTRO

CREATE TABLE CLIENTE (
CODIGO INT PRIMARY KEY NOT NULL,
NOME VARCHAR (50) NOT NULL, 
RG_CNH VARCHAR (20) NOT NULL, 
CPF VARCHAR (20) NOT NULL, 
CONTATO VARCHAR (20) NULL, 
EMAIL VARCHAR (50) NULL
);


INSERT INTO CLIENTE VALUES (' ', 'Eliane', '20085963865', '69853214875', '85965321458', 'eliane@gmail.com');
INSERT INTO CLIENTE VALUES (' ', 'Rangel', '50085963860', '70053214875', '85965325632', 'rangel@gmail.com');
INSERT INTO CLIENTE VALUES (' ', 'Eliane', '20085963865', '69853214875', '85965321458', 'eliane@gmail.com');
INSERT INTO CLIENTE VALUES (' ', 'Eliane', '20085963865', '69853214875', '85965321458', 'eliane@gmail.com');


COMMIT;
