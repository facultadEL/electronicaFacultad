CREATE TABLE profesor(
	id serial NOT NULL primary key,
	nombre character varying,
	apellido character varying,
	mail character varying,
	telefono character varying,
	usuario_fk
);