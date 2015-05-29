CREATE TABLE informe_idea(
	id serial NOT NULL primary key,
	idea integer references idea(id),
	archivo_pdf character varying,
	fecha_registro_pdf date,
	descripcion text,
	visto boolean default false
);