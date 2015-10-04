-- Table: nivel_carrera

-- DROP TABLE nivel_carrera;

CREATE TABLE nivel_carrera(
  id serial NOT NULL primary key,
  nombre character varying
);
INSERT INTO nivel_carrera(id,nombre)VALUES(1,'Grado');
INSERT INTO nivel_carrera(id,nombre)VALUES(2,'Posgrado');
INSERT INTO nivel_carrera(id,nombre)VALUES(3,'Pregrado');

