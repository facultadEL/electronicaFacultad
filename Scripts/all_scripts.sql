CREATE TABLE nivel_carrera(
  id serial NOT NULL primary key,
  nombre character varying
);
INSERT INTO nivel_carrera(id,nombre)VALUES(1,'Grado');
INSERT INTO nivel_carrera(id,nombre)VALUES(2,'Posgrado');
INSERT INTO nivel_carrera(id,nombre)VALUES(3,'Pregrado');

CREATE TABLE rol(
	id serial NOT NULL primary key,
	nombre character varying
);
INSERT INTO rol(nombre)VALUES('Alumno');
INSERT INTO rol(nombre)VALUES('Administrador');
INSERT INTO rol(nombre)VALUES('Profesor');
INSERT INTO rol(nombre)VALUES('Constatador');

CREATE TABLE usuario(
	id serial NOT NULL primary key,
	mail character varying,
	password character varying,
	rol_fk integer references rol(id),
	primera_vez boolean default TRUE,
	habilitado boolean default TRUE
);
INSERT INTO usuario(id,mail,password,rol_fk,primera_vez,habilitado)VALUES(1,'hdferrari@gmail.com','aa72459f21421e8027a836f286729868',3,FALSE,TRUE);
INSERT INTO usuario(id,mail,password,rol_fk,primera_vez,habilitado)VALUES(2,'ramon.oros@gmail.com','3ee91f6b0075241c722728c639793364',3,FALSE,TRUE);
INSERT INTO usuario(id,mail,password,rol_fk,primera_vez,habilitado)VALUES(3,'gutiejose@hotmail.com','10d644b3d8776238df17bddf6553bcc2',3,FALSE,TRUE);
INSERT INTO usuario(id,mail,password,rol_fk,primera_vez,habilitado)VALUES(4,'maballes@arnet.com.ar','6f70e24eab5c9baf3d0137c6b467a678',3,FALSE,TRUE);
INSERT INTO usuario(id,mail,password,rol_fk,primera_vez,habilitado)VALUES(5,'fmsalvatico@hotmail.com','060baa8ecd2478c5c560ebd1125516f0',3,FALSE,TRUE);
INSERT INTO usuario(id,mail,password,rol_fk,primera_vez,habilitado)VALUES(6,'etell@frvm.utn.edu.ar','21232f297a57a5a743894a0e4a801fc3',2,FALSE,TRUE);
INSERT INTO usuario(id,mail,password,rol_fk,primera_vez,habilitado)VALUES(7,'ing_oliveros@arnet.com.ar','8090af55fa8de93895ee60c16c4c88b8',4,FALSE,TRUE);

CREATE TABLE tipo_dni(
  id serial NOT NULL primary key,
  nombre character varying,
  descripcion character varying
);
INSERT INTO tipo_dni(nombre,descripcion)VALUES('DNI','Documento Nacional de Identidad');
INSERT INTO tipo_dni(nombre,descripcion)VALUES('LC','Libreta Cívica');
INSERT INTO tipo_dni(nombre,descripcion)VALUES('LE','Libreta Enrolamiento');

CREATE TABLE estado_idea(
  id serial NOT NULL primary key,
  nombre character varying
);
INSERT INTO estado_idea(nombre)VALUES('No existe idea');
INSERT INTO estado_idea(nombre)VALUES('Pendiente de aprobación');
INSERT INTO estado_idea(nombre)VALUES('Aprobado');
INSERT INTO estado_idea(nombre)VALUES('No Aprobado');
INSERT INTO estado_idea(nombre)VALUES('En Ejecución');
INSERT INTO estado_idea(nombre)VALUES('Finalizado');
INSERT INTO estado_idea(nombre)VALUES('Fin PS');

CREATE TABLE carrera(
	id serial NOT NULL primary key,
	nombre character varying,
	nivel_fk integer references nivel_carrera(id)
);
INSERT INTO carrera(id,nombre,nivel_fk) VALUES('1','Ing. en Sistemas de Información','1');
INSERT INTO carrera(id,nombre,nivel_fk) VALUES('2','Ing. Electrónica','1');
INSERT INTO carrera(id,nombre,nivel_fk) VALUES('3','Ing. Química','1');
INSERT INTO carrera(id,nombre,nivel_fk) VALUES('4','Ing. Mecánica','1');
INSERT INTO carrera(id,nombre,nivel_fk) VALUES('5','Lic. en Administración Rural','1');

CREATE TABLE pasante(
	id serial NOT NULL primary key,
	nombre character varying,
	apellido character varying,
	nro_legajo character varying,
	tipodni integer references tipo_dni(id),
	nrodni character varying,
	fec_nacimiento date,
	loc_nacimiento character varying,
	prov_viviendo character varying,
	loc_viviendo character varying,
	codpos character varying,
	calle character varying,
	nrocalle character varying,
	piso character varying,
	dpto character varying,
	carrera_fk integer references carrera(id),
	caracfijo character varying,
	nrofijo character varying,
	caraccel character varying,
	nrocelular character varying,
	mail character varying,
	mail2 character varying,
	facebook character varying,
	twitter character varying,
	prov_trabajo character varying,
	loc_trabajo character varying,
	codpos2 character varying,
	empresa_trabaja character varying,
	perfil_laboral character varying,
	confirmado boolean default false,
	logueado boolean default false,
	fecreg date,
	usuario_fk integer references usuario(id),
	enviado boolean default false
);

CREATE TABLE idea(
	id serial NOT NULL primary key,
	nombre character varying,
	archivo character varying,
	estado integer references estado_idea(id),
	pasante_fk integer references pasante(id),
	fecha_registro date,
	fecha_aprobada date
);

CREATE TABLE informe_final(
	id serial NOT NULL primary key,
	nombre character varying,
	archivo character varying,
	estado integer references estado_idea(id),
	pasante_fk integer references pasante(id),
	fecha_registro date
);

CREATE TABLE profesor(
	id serial NOT NULL primary key,
	nombre character varying,
	apellido character varying,
	mail character varying,
	telefono character varying,
	usuario_fk integer references usuario(id)
);
INSERT INTO profesor(id,nombre,apellido,mail,telefono,usuario_fk)VALUES(1,'Hector','Ferrari','hdferrari@gmail.com','',1);
INSERT INTO profesor(id,nombre,apellido,mail,telefono,usuario_fk)VALUES(2,'Ramon','Oros','ramon.oros@gmail.com','',2);
INSERT INTO profesor(id,nombre,apellido,mail,telefono,usuario_fk)VALUES(3,'José','Gutierrez','gutiejose@hotmail.com','',3);
INSERT INTO profesor(id,nombre,apellido,mail,telefono,usuario_fk)VALUES(4,'Miguel','Ballesteros','maballes@arnet.com.ar','',4);
INSERT INTO profesor(id,nombre,apellido,mail,telefono,usuario_fk)VALUES(5,'Franco','Salvatico','fmsalvatico@hotmail.com','',5);
INSERT INTO profesor(id,nombre,apellido,mail,telefono,usuario_fk)VALUES(6,'Eduardo','Tell','etell@frvm.utn.edu.ar','',6);

CREATE TABLE ideaxprofesor(
	id serial NOT NULL primary key,
	idea integer references idea(id),
	profesor integer references profesor(id),
	ideaaprobada boolean,
	fecha_calif date,
	observacion text,
	visto boolean default false
);

CREATE TABLE informexprofesor(
	id serial NOT NULL primary key,
	informe integer references informe_final(id),
	profesor integer references profesor(id),
	informeaprobado boolean;
	fecha_calif date,
	observacion text,
	visto boolean default false
);

CREATE TABLE informe_idea(
	id serial NOT NULL primary key,
	idea integer references idea(id),
	archivo_pdf character varying,
	fecha_registro_pdf date,
	descripcion text,
	constatador integer references constatador(id),
	es_final boolean default false
);

CREATE TABLE constatador(
	id serial NOT NULL primary key,
	nombre character varying,
	apellido character varying,
	mail character varying,
	usuario_fk integer references usuario(id)
);
INSERT INTO constatador(id,nombre,apellido,mail,usuario_fk)VALUES(1,'Hugo','Oliveros','ing_oliveros@arnet.com.ar',7);
