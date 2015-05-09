CREATE TABLE usuario(
	id serial NOT NULL primary key,
	mail character varying,
	password character varying,
	rol_fk integer references rol(id),
	primera_vez boolean default TRUE,
	habilitado boolean default TRUE
);