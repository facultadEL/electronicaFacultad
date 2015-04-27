﻿CREATE TABLE pasante
(
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
  usuario_fk integer references usuario(id),
  prov_trabajo character varying,
  loc_trabajo character varying,
  codpos2 character varying,
  empresa_trabaja character varying,
  perfil_laboral character varying,
  logueado boolean default false,
  fecreg date
);