CREATE TABLE informe_idea(
	id serial NOT NULL primary key,
	idea integer references idea(id),
	archivo_pdf character varying,
	fecha_registro_pdf date,
	descripcion text,
	constatador integer references constatador(id),
	visto boolean default false,
	es_final boolean default false
);