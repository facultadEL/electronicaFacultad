CREATE TABLE estado_idea
(
  id serial NOT NULL primary key,
  nombre character varying
);
INSERT INTO estado_idea(nombre)VALUES('Pendiente de aprobación');
INSERT INTO estado_idea(nombre)VALUES('Aprobado');
INSERT INTO estado_idea(nombre)VALUES('No Aprobado');
INSERT INTO estado_idea(nombre)VALUES('En Ejecución');
INSERT INTO estado_idea(nombre)VALUES('Finalizado');