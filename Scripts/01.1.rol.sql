CREATE TABLE rol
(
	id serial NOT NULL primary key,
	nombre character varying
);
INSERT INTO rol(nombre)VALUES('Alumno');
INSERT INTO rol(nombre)VALUES('Administrador');
INSERT INTO rol(nombre)VALUES('Profesor');
INSERT INTO rol(nombre)VALUES('Seguimiento');