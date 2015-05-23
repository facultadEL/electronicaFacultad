CREATE TABLE idea(
	id serial NOT NULL primary key,
	nombre character varying,
	archivo character varying,
	estado integer references estado_idea(id),
	pasante_fk integer references pasante(id),
	fecha_registro date
);