CREATE TABLE ideaxprofesor(
	id serial NOT NULL primary key,
	idea integer references idea(id),
	profesor integer references profesor(id),
	ideaaprobada boolean
	fecha_calif date,
	observacion text,
	visto boolean default false
);