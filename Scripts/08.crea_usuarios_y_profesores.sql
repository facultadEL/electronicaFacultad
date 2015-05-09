INSERT INTO usuario(id,mail,password,rol_fk,primera_vez,habilitado)VALUES(1,'hdferrari@gmail.com','profe1',3,FALSE,TRUE);
INSERT INTO usuario(id,mail,password,rol_fk,primera_vez,habilitado)VALUES(2,'ramon.oros@gmail.com','profe2',3,FALSE,TRUE);
INSERT INTO usuario(id,mail,password,rol_fk,primera_vez,habilitado)VALUES(3,'gutiejose@hotmail.com','profe3',3,FALSE,TRUE);
INSERT INTO usuario(id,mail,password,rol_fk,primera_vez,habilitado)VALUES(4,'maballes@arnet.com.ar','profe4',3,FALSE,TRUE);
INSERT INTO usuario(id,mail,password,rol_fk,primera_vez,habilitado)VALUES(5,'fmsalvatico@hotmail.com','profe5',3,FALSE,TRUE);
INSERT INTO usuario(id,mail,password,rol_fk,primera_vez,habilitado)VALUES(6,'ing_oliveros@arnet.com.ar','seguimiento',4,FALSE,TRUE);
INSERT INTO usuario(id,mail,password,rol_fk,primera_vez,habilitado)VALUES(7,'etell@frvm.utn.edu.ar','admin',2,FALSE,TRUE);

INSERT INTO profesor(id,nombre,apellido,mail,telefono,usuario_fk)VALUES(1,'Hector','Ferrari','hdferrari@gmail.com','',1);
INSERT INTO profesor(id,nombre,apellido,mail,telefono,usuario_fk)VALUES(2,'Ramon','Oros','ramon.oros@gmail.com','',2);
INSERT INTO profesor(id,nombre,apellido,mail,telefono,usuario_fk)VALUES(3,'José','Gutierrez','gutiejose@hotmail.com','',3);
INSERT INTO profesor(id,nombre,apellido,mail,telefono,usuario_fk)VALUES(4,'Miguel','Ballesteros','maballes@arnet.com.ar','',4);
INSERT INTO profesor(id,nombre,apellido,mail,telefono,usuario_fk)VALUES(5,'Franco','Salvatico','fmsalvatico@hotmail.com','',5);
INSERT INTO profesor(id,nombre,apellido,mail,telefono,usuario_fk)VALUES(6,'Hugo','Oliveros','ing_oliveros@arnet.com.ar','',6);
INSERT INTO profesor(id,nombre,apellido,mail,telefono,usuario_fk)VALUES(7,'Eduardo','Tell','etell@frvm.utn.edu.ar','',7);