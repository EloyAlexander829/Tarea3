CREATE DATABASE SENATIDB;
USE SENATIDB;

CREATE TABLE marcas 
(
	idmarca INT auto_increment primary KEY,
    marca   VARCHAR(30) NOT NULL,
    create_at DATETIME NOT NULL DEFAULT NOW(),
    inactive_at DATETIME NULL,
    update_at DATETIME NULL,
    CONSTRAINT uk_marca_mar UNIQUE (marca)
)
ENGINE = INNODB;

INSERT INTO marcas (marca)
	VALUES 
		('Toyota'),
        ('Nissan'),
        ('Volvo'),
        ('Hyundai'),
        ('KIA');

CREATE TABLE vehiculos 
(
	idvehiculo INT AUTO_INCREMENT PRIMARY KEY,
    idmarca 	INT 	NOT NULL,
    modelo 		VARCHAR(50) NOT NULL,
    color 		VARCHAR(30) NOT NULL,
    tipocombustible CHAR(3) NOT NULL,
    peso 		SMALLINT 	NOT NULL,
    afabricacion CHAR(4) 	NOT NULL,
    placa 		CHAR(7) 	NOT NULL,
    create_at 	DATETIME NOT NULL DEFAULT NOW(),
    inactive_at DATETIME 		NULL,
    update_at 	DATETIME 		NULL,
    CONSTRAINT fk_idmarca_veh FOREIGN KEY (idmarca) REFERENCES marcas (idmarca),
    CONSTRAINT ck_tipocombustible_veh CHECK (tipocombustible IN ('GSL','DSL','GNV','GLP')),
    CONSTRAINT ck_peso_vech CHECK (peso > 0),
	constraint uk_placa_veh unique (placa)
)
ENGINE = INNODB;

INSERT INTO vehiculos 
		(idmarca,modelo,color,tipocombustible,peso,afabricacion,placa)
        VALUES 
        (1,'Hilux','blanco','DSL',1800,'2020','ABC-111'),
        (2,'Sentra','gris','GSL',1200,'2021','ABC-112'),
        (3,'EX30','negro','GNV',1350,'2023','ABC-113'),
        (4,'Tucson','rojo','GLP',1800,'2022','ABC-114'),
        (5,'Sportage','azul','DSL',1500,'2010','ABC-115');
        
DELIMITER $$
CREATE PROCEDURE spu_vehiculos_buscar(IN _placa CHAR(7))
BEGIN 
	SELECT 
		VEH.idvehiculo,
        MAR.marca,
        VEH.modelo,
        VEH.color,
        VEH.tipocombustible,
        VEH.peso,
        VEH.afabricacion,
        VEH.placa
		FROM vehiculos VEH
        INNER JOIN marcas MAR ON MAR.idmarca = VEH.idmarca
        WHERE (VEH.inactive_at IS NULL) AND
			  (VEH.placa = _placa);
END $$

CALL spu_vehiculos_buscar('ABC-111');

DELIMITER $$
CREATE PROCEDURE spu_vehiculos_registrar
(
IN _idmarca 			int,
IN _modelo 				varchar(30),
IN _color 				varchar(30),
IN _tipocombustible 	char(3),
IN _peso				smallint,
IN _afabricacion		char(4),
IN _placa				char(7)
)
BEGIN
	INSERT INTO vehiculos (idmarca,modelo, color, tipocombustible, peso, afabricacion, placa)
    VALUES (_idmarca,_modelo,_color,_tipocombustible,_peso,_afabricacion,_placa);
    
    SELECT @@last_insert_id 'idvehiculo';
END $$

call spu_vehiculos_registrar(4,'Santa Fe','Negro','GSL',1900,'2020','ABC-777');
call spu_vehiculos_registrar(4,'Creta','Azul Eléctrico','GNV',1200,'2021','ABC-001');

DELIMITER $$
CREATE PROCEDURE spu_marcas_listar() 
BEGIN 
	SELECT 
		idmarca,
        marca
		FROM marcas
        WHERE inactive_at IS NULL
        ORDER BY marca;
END $$

CREATE TABLE sedes
(
	idsede	 	INT AUTO_INCREMENT PRIMARY KEY,
    sede   		VARCHAR(50) NOT NULL,
    create_at 	DATETIME NOT NULL DEFAULT NOW(),
    inactive_at DATETIME NULL,
    update_at 	DATETIME NULL,
    CONSTRAINT uk_sede_sed UNIQUE (sede)
)
ENGINE = INNODB;

INSERT INTO sedes (sede)
	VALUES 
		('Chincha'),
        ('Ica'),
        ('Ayacucho'),
        ('Lima'),
        ('Piura');
        
CREATE TABLE empleados 
(
	idempleado 		INT AUTO_INCREMENT PRIMARY KEY,
    idsede 			INT,
    apellidos 		VARCHAR(50) NOT NULL,
    nombres 		VARCHAR(40) NOT NULL,
    nrodocumento	CHAR(8) 	NOT NULL,
    fechanac		DATE 	NOT NULL,
    telefono 		VARCHAR(9)	NOT NULL,
    create_at 		DATETIME NOT NULL DEFAULT NOW(),
    inactive_at 	DATETIME NULL,
    update_at 		DATETIME NULL,
    CONSTRAINT uk_nrodocumento_sed UNIQUE (nrodocumento),
    CONSTRAINT fk_idsede_sed FOREIGN KEY (idsede) REFERENCES sedes (idsede)
)
ENGINE = INNODB;

DELIMITER $$
CREATE PROCEDURE spu_sedes_listar() 
BEGIN 
	SELECT 
		idsede,
        sede
		FROM sedes
        WHERE inactive_at IS NULL
        ORDER BY sede;
END $$

CALL spu_sedes_listar

DELIMITER $$
CREATE PROCEDURE spu_empleados_listar()
BEGIN
    SELECT 
        EMP.idempleado,
        SED.sede,
        EMP.apellidos,
        EMP.nombres,
        EMP.nrodocumento, 
        EMP.fechanac,
        EMP.telefono
    FROM empleados EMP
    LEFT JOIN sedes SED ON SED.idsede = EMP.idsede
    WHERE EMP.inactive_at IS NULL;
END $$

CALL spu_empleados_listar

DELIMITER $$
CREATE PROCEDURE spu_empleados_buscar(IN _nrodocumento CHAR(8))
BEGIN 
	SELECT 
		EMP.idempleado,
        SED.sede,
        EMP.apellidos,
        EMP.nombres,
        EMP.nrodocumento,
        EMP.fechanac,
        EMP.telefono
		FROM empleados EMP
        INNER JOIN sedes SED ON SED.idsede = EMP.idsede
        WHERE (EMP.inactive_at IS NULL) AND
			  (EMP.nrodocumento = _nrodocumento);
END $$

CALL spu_empleados_buscar('72845296');

DELIMITER $$
CREATE PROCEDURE spu_empleados_registrar
(
IN _idsede 				INT,
IN _apellidos 			VARCHAR(50),
IN _nombres 			VARCHAR(40),
IN _nrodocumento 		CHAR(8),
IN _fechanac			DATE,
IN _telefono			VARCHAR(9)
)
BEGIN
	INSERT INTO empleados (idsede, apellidos, nombres, nrodocumento, fechanac, telefono)
    VALUES (_idsede, _apellidos, _nombres, _nrodocumento, _fechanac, _telefono);
    
    SELECT @@last_insert_id 'idempleado';
END $$

call spu_empleados_registrar(1,'Guerra Vasquez','Yazuri Fiorella','72845296','2005-03-21','927814567');

-- consultas de resumen (campos rendundantes) 
SELECT * FROM vehiculos;

SELECT * FROM empleados;

DELIMITER $$ 
CREATE PROCEDURE spu_resumen_tipocombustible()
BEGIN
	SELECT 
		tipocombustible, count(tipocombustible) AS 'total'
		FROM vehiculos
        GROUP BY tipocombustible
        ORDER BY total;
END $$

DELIMITER $$
CREATE PROCEDURE spu_resumen_sedes()
BEGIN 
	SELECT 
		idsede, count(idsede) AS 'Total'
        FROM empleados 
        GROUP BY idsede
        ORDER BY Total;
END $$

CALL spu_resumen_sedes();
CALL spu_resumen_tipocombustible();