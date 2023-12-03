--------------------------------------------------------
-- Archivo creado  - domingo-diciembre-03-2023   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Table DOCUMENTO
--------------------------------------------------------

  CREATE TABLE "SYSTEM"."DOCUMENTO" 
   (	"IDENTIFICADOR" NUMBER DEFAULT "SYSTEM"."SEQ_DOCUMENTO"."NEXTVAL", 
	"TIPO" VARCHAR2(50 BYTE), 
	"TITULO" VARCHAR2(50 BYTE), 
	"AUTOR" VARCHAR2(50 BYTE), 
	"EDITORIAL" VARCHAR2(50 BYTE), 
	"ANIO" NUMBER, 
	"EDICION" VARCHAR2(50 BYTE), 
	"CATEGORIA" VARCHAR2(50 BYTE), 
	"CANTIDAD" NUMBER(*,0)
   ) PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Table SOLICITUD_PRESTAMO
--------------------------------------------------------

  CREATE TABLE "SYSTEM"."SOLICITUD_PRESTAMO" 
   (	"IDSOLICITUD" NUMBER DEFAULT "SYSTEM"."SEQ_SOLICITUD"."NEXTVAL", 
	"IDUSUARIO" NUMBER, 
	"FECHA_SOLICITUD" DATE, 
	"HORA_SOLICITUD" TIMESTAMP (0)
   ) PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Table DETALLE_SOLICITUD_PRESTAMO
--------------------------------------------------------

  CREATE TABLE "SYSTEM"."DETALLE_SOLICITUD_PRESTAMO" 
   (	"IDSOLICITUD" NUMBER, 
	"IDEJEMPLAR" NUMBER
   ) PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Table CUENTAS_USUARIO
--------------------------------------------------------

  CREATE TABLE "SYSTEM"."CUENTAS_USUARIO" 
   (	"RUT" VARCHAR2(9 BYTE), 
	"CORREO" VARCHAR2(100 BYTE), 
	"CLAVE" VARCHAR2(50 BYTE)
   ) PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Table EJEMPLAR
--------------------------------------------------------

  CREATE TABLE "SYSTEM"."EJEMPLAR" 
   (	"IDEJEMPLAR" NUMBER DEFAULT "SYSTEM"."SEQ_SOLICITUD"."NEXTVAL", 
	"IDDOCUMENTO" NUMBER, 
	"ESTADO" VARCHAR2(50 BYTE), 
	"UBICACION" VARCHAR2(50 BYTE)
   ) PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Table PRESTAMO
--------------------------------------------------------

  CREATE TABLE "SYSTEM"."PRESTAMO" 
   (	"IDPRESTAMO" NUMBER DEFAULT "SYSTEM"."SEQ_PRESTAMO"."NEXTVAL", 
	"TIPO_PRESTAMO" VARCHAR2(50 BYTE), 
	"IDEJEMPLAR" NUMBER, 
	"FECHA_PRESTAMO" DATE, 
	"HORA_PRESTAMO" TIMESTAMP (0), 
	"FECHA_DEVOLUCION" DATE, 
	"HORA_DEVOLUCION" TIMESTAMP (0), 
	"FECHA_DEVOLUCION_REAL" DATE, 
	"HORA_DEVOLUCION_REAL" TIMESTAMP (0), 
	"IDUSUARIO" NUMBER
   ) PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Table CUENTAS_PERSONAL
--------------------------------------------------------

  CREATE TABLE "SYSTEM"."CUENTAS_PERSONAL" 
   (	"IDCUENTA" NUMBER DEFAULT "SYSTEM"."SEQ_PERSONAL"."NEXTVAL", 
	"USUARIO" VARCHAR2(255 BYTE), 
	"CONTRASENA" VARCHAR2(255 BYTE), 
	"TIPO_CUENTA" VARCHAR2(255 BYTE)
   ) PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Table USUARIO
--------------------------------------------------------

  CREATE TABLE "SYSTEM"."USUARIO" 
   (	"IDENTIFICADOR" NUMBER DEFAULT "SYSTEM"."SEQ_USUARIO"."NEXTVAL", 
	"RUT" VARCHAR2(9 BYTE), 
	"NOMBRES" VARCHAR2(50 BYTE), 
	"APELLIDOS" VARCHAR2(50 BYTE), 
	"DIRECCION" VARCHAR2(50 BYTE), 
	"TELEFONO_ACTIVO" VARCHAR2(50 BYTE)
   ) PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
REM INSERTING into SYSTEM.DOCUMENTO
SET DEFINE OFF;
Insert into SYSTEM.DOCUMENTO (IDENTIFICADOR,TIPO,TITULO,AUTOR,EDITORIAL,ANIO,EDICION,CATEGORIA,CANTIDAD) values ('1','Libro','a','a','a','22','a','Ciencia','22');
Insert into SYSTEM.DOCUMENTO (IDENTIFICADOR,TIPO,TITULO,AUTOR,EDITORIAL,ANIO,EDICION,CATEGORIA,CANTIDAD) values ('2','Articulo','Machine Learning Avanzado','Alice Johnson','Editorial 123','2019','Especial','Arte','8');
Insert into SYSTEM.DOCUMENTO (IDENTIFICADOR,TIPO,TITULO,AUTOR,EDITORIAL,ANIO,EDICION,CATEGORIA,CANTIDAD) values ('3','Libro','Algoritmos y Estructuras de Datos','Michael Brown','Editorial XYZ','2018','Segunda Edicion','Tecnologia','15');
Insert into SYSTEM.DOCUMENTO (IDENTIFICADOR,TIPO,TITULO,AUTOR,EDITORIAL,ANIO,EDICION,CATEGORIA,CANTIDAD) values ('4','Revista','Historia del Arte Moderno','Emma Davis','Editorial 789','2022','Vol. 3, No. 1','Arte','3');
REM INSERTING into SYSTEM.SOLICITUD_PRESTAMO
SET DEFINE OFF;
REM INSERTING into SYSTEM.DETALLE_SOLICITUD_PRESTAMO
SET DEFINE OFF;
REM INSERTING into SYSTEM.CUENTAS_USUARIO
SET DEFINE OFF;
Insert into SYSTEM.CUENTAS_USUARIO (RUT,CORREO,CLAVE) values ('20430543','diego@riv','1234');
Insert into SYSTEM.CUENTAS_USUARIO (RUT,CORREO,CLAVE) values ('2','a@a','a');
Insert into SYSTEM.CUENTAS_USUARIO (RUT,CORREO,CLAVE) values ('7','b@b','b');
REM INSERTING into SYSTEM.EJEMPLAR
SET DEFINE OFF;
Insert into SYSTEM.EJEMPLAR (IDEJEMPLAR,IDDOCUMENTO,ESTADO,UBICACION) values ('2','2','Bueno','ASD');
Insert into SYSTEM.EJEMPLAR (IDEJEMPLAR,IDDOCUMENTO,ESTADO,UBICACION) values ('3','3','Bueno','ASD');
Insert into SYSTEM.EJEMPLAR (IDEJEMPLAR,IDDOCUMENTO,ESTADO,UBICACION) values ('1','1','Bueno','ASD');
Insert into SYSTEM.EJEMPLAR (IDEJEMPLAR,IDDOCUMENTO,ESTADO,UBICACION) values ('4','4','Bueno','ASD');
Insert into SYSTEM.EJEMPLAR (IDEJEMPLAR,IDDOCUMENTO,ESTADO,UBICACION) values ('5','1','Bueno','ASD');
Insert into SYSTEM.EJEMPLAR (IDEJEMPLAR,IDDOCUMENTO,ESTADO,UBICACION) values ('6','2','Bueno','ASD');
Insert into SYSTEM.EJEMPLAR (IDEJEMPLAR,IDDOCUMENTO,ESTADO,UBICACION) values ('7','3','Bueno','ASD');
Insert into SYSTEM.EJEMPLAR (IDEJEMPLAR,IDDOCUMENTO,ESTADO,UBICACION) values ('8','4','Bueno','ASD');
REM INSERTING into SYSTEM.PRESTAMO
SET DEFINE OFF;
Insert into SYSTEM.PRESTAMO (IDPRESTAMO,TIPO_PRESTAMO,IDEJEMPLAR,FECHA_PRESTAMO,HORA_PRESTAMO,FECHA_DEVOLUCION,HORA_DEVOLUCION,FECHA_DEVOLUCION_REAL,HORA_DEVOLUCION_REAL,IDUSUARIO) values ('41','Documento','2',to_date('03/12/23','DD/MM/RR'),to_timestamp('03/12/23 15:44:18,000000000','DD/MM/RR HH24:MI:SSXFF'),to_date('18/12/23','DD/MM/RR'),to_timestamp('18/12/23 15:44:18,000000000','DD/MM/RR HH24:MI:SSXFF'),to_date('03/12/23','DD/MM/RR'),to_timestamp('03/12/23 16:04:31,000000000','DD/MM/RR HH24:MI:SSXFF'),'6');
Insert into SYSTEM.PRESTAMO (IDPRESTAMO,TIPO_PRESTAMO,IDEJEMPLAR,FECHA_PRESTAMO,HORA_PRESTAMO,FECHA_DEVOLUCION,HORA_DEVOLUCION,FECHA_DEVOLUCION_REAL,HORA_DEVOLUCION_REAL,IDUSUARIO) values ('41','Documento','3',to_date('03/12/23','DD/MM/RR'),to_timestamp('03/12/23 15:44:18,000000000','DD/MM/RR HH24:MI:SSXFF'),to_date('18/12/23','DD/MM/RR'),to_timestamp('18/12/23 15:44:18,000000000','DD/MM/RR HH24:MI:SSXFF'),to_date('03/12/23','DD/MM/RR'),to_timestamp('03/12/23 16:04:31,000000000','DD/MM/RR HH24:MI:SSXFF'),'6');
Insert into SYSTEM.PRESTAMO (IDPRESTAMO,TIPO_PRESTAMO,IDEJEMPLAR,FECHA_PRESTAMO,HORA_PRESTAMO,FECHA_DEVOLUCION,HORA_DEVOLUCION,FECHA_DEVOLUCION_REAL,HORA_DEVOLUCION_REAL,IDUSUARIO) values ('44','Documento','2',to_date('03/12/23','DD/MM/RR'),to_timestamp('03/12/23 17:20:41,000000000','DD/MM/RR HH24:MI:SSXFF'),to_date('10/11/23','DD/MM/RR'),to_timestamp('10/11/23 17:20:41,000000000','DD/MM/RR HH24:MI:SSXFF'),to_date('03/12/23','DD/MM/RR'),to_timestamp('03/12/23 17:23:04,000000000','DD/MM/RR HH24:MI:SSXFF'),'6');
Insert into SYSTEM.PRESTAMO (IDPRESTAMO,TIPO_PRESTAMO,IDEJEMPLAR,FECHA_PRESTAMO,HORA_PRESTAMO,FECHA_DEVOLUCION,HORA_DEVOLUCION,FECHA_DEVOLUCION_REAL,HORA_DEVOLUCION_REAL,IDUSUARIO) values ('40','Documento','2',to_date('03/12/23','DD/MM/RR'),to_timestamp('03/12/23 15:44:15,000000000','DD/MM/RR HH24:MI:SSXFF'),to_date('30/12/22','DD/MM/RR'),to_timestamp('30/12/22 15:44:15,000000000','DD/MM/RR HH24:MI:SSXFF'),to_date('03/12/23','DD/MM/RR'),to_timestamp('03/12/23 16:25:09,000000000','DD/MM/RR HH24:MI:SSXFF'),'7');
Insert into SYSTEM.PRESTAMO (IDPRESTAMO,TIPO_PRESTAMO,IDEJEMPLAR,FECHA_PRESTAMO,HORA_PRESTAMO,FECHA_DEVOLUCION,HORA_DEVOLUCION,FECHA_DEVOLUCION_REAL,HORA_DEVOLUCION_REAL,IDUSUARIO) values ('40','Documento','4',to_date('03/12/23','DD/MM/RR'),to_timestamp('03/12/23 15:44:15,000000000','DD/MM/RR HH24:MI:SSXFF'),to_date('30/12/22','DD/MM/RR'),to_timestamp('30/12/22 15:44:15,000000000','DD/MM/RR HH24:MI:SSXFF'),to_date('03/12/23','DD/MM/RR'),to_timestamp('03/12/23 16:25:09,000000000','DD/MM/RR HH24:MI:SSXFF'),'7');
REM INSERTING into SYSTEM.CUENTAS_PERSONAL
SET DEFINE OFF;
Insert into SYSTEM.CUENTAS_PERSONAL (IDCUENTA,USUARIO,CONTRASENA,TIPO_CUENTA) values ('1','usuario1','contrasena1','bibliotecario');
Insert into SYSTEM.CUENTAS_PERSONAL (IDCUENTA,USUARIO,CONTRASENA,TIPO_CUENTA) values ('2','usuario2','contrasena2','admin');
Insert into SYSTEM.CUENTAS_PERSONAL (IDCUENTA,USUARIO,CONTRASENA,TIPO_CUENTA) values ('3','usuario3','contrasena3','bibliotecario');
Insert into SYSTEM.CUENTAS_PERSONAL (IDCUENTA,USUARIO,CONTRASENA,TIPO_CUENTA) values ('4','usuario4','contrasena4','admin');
Insert into SYSTEM.CUENTAS_PERSONAL (IDCUENTA,USUARIO,CONTRASENA,TIPO_CUENTA) values ('5','usuario5','contrasena5','bibliotecario');
REM INSERTING into SYSTEM.USUARIO
SET DEFINE OFF;
Insert into SYSTEM.USUARIO (IDENTIFICADOR,RUT,NOMBRES,APELLIDOS,DIRECCION,TELEFONO_ACTIVO) values ('6','20430543','Diego Alonso','Rivera Jara','JM 4415','12345678');
Insert into SYSTEM.USUARIO (IDENTIFICADOR,RUT,NOMBRES,APELLIDOS,DIRECCION,TELEFONO_ACTIVO) values ('7','2','a','a','a','2');
Insert into SYSTEM.USUARIO (IDENTIFICADOR,RUT,NOMBRES,APELLIDOS,DIRECCION,TELEFONO_ACTIVO) values ('8','7','b','b','asd','87');
--------------------------------------------------------
--  DDL for Index SYS_C008335
--------------------------------------------------------

  CREATE UNIQUE INDEX "SYSTEM"."SYS_C008335" ON "SYSTEM"."DOCUMENTO" ("IDENTIFICADOR") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Index SYS_C008341
--------------------------------------------------------

  CREATE UNIQUE INDEX "SYSTEM"."SYS_C008341" ON "SYSTEM"."SOLICITUD_PRESTAMO" ("IDSOLICITUD") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Index SYS_C008347
--------------------------------------------------------

  CREATE UNIQUE INDEX "SYSTEM"."SYS_C008347" ON "SYSTEM"."CUENTAS_USUARIO" ("RUT") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Index SYS_C008336
--------------------------------------------------------

  CREATE UNIQUE INDEX "SYSTEM"."SYS_C008336" ON "SYSTEM"."EJEMPLAR" ("IDEJEMPLAR") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Index SYS_C008350
--------------------------------------------------------

  CREATE UNIQUE INDEX "SYSTEM"."SYS_C008350" ON "SYSTEM"."CUENTAS_PERSONAL" ("IDCUENTA") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Index SYS_C008340
--------------------------------------------------------

  CREATE UNIQUE INDEX "SYSTEM"."SYS_C008340" ON "SYSTEM"."USUARIO" ("IDENTIFICADOR") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  Constraints for Table DOCUMENTO
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."DOCUMENTO" ADD PRIMARY KEY ("IDENTIFICADOR")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM"  ENABLE;
  ALTER TABLE "SYSTEM"."DOCUMENTO" MODIFY ("IDENTIFICADOR" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table SOLICITUD_PRESTAMO
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."SOLICITUD_PRESTAMO" ADD PRIMARY KEY ("IDSOLICITUD")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM"  ENABLE;
  ALTER TABLE "SYSTEM"."SOLICITUD_PRESTAMO" MODIFY ("IDSOLICITUD" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table CUENTAS_USUARIO
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."CUENTAS_USUARIO" MODIFY ("RUT" NOT NULL ENABLE);
  ALTER TABLE "SYSTEM"."CUENTAS_USUARIO" ADD PRIMARY KEY ("RUT")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM"  ENABLE;
--------------------------------------------------------
--  Constraints for Table EJEMPLAR
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."EJEMPLAR" ADD PRIMARY KEY ("IDEJEMPLAR")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM"  ENABLE;
  ALTER TABLE "SYSTEM"."EJEMPLAR" MODIFY ("IDEJEMPLAR" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table PRESTAMO
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."PRESTAMO" MODIFY ("IDPRESTAMO" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table CUENTAS_PERSONAL
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."CUENTAS_PERSONAL" ADD PRIMARY KEY ("IDCUENTA")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM"  ENABLE;
  ALTER TABLE "SYSTEM"."CUENTAS_PERSONAL" MODIFY ("IDCUENTA" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table USUARIO
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."USUARIO" ADD PRIMARY KEY ("IDENTIFICADOR")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM"  ENABLE;
  ALTER TABLE "SYSTEM"."USUARIO" MODIFY ("IDENTIFICADOR" NOT NULL ENABLE);
--------------------------------------------------------
--  Ref Constraints for Table SOLICITUD_PRESTAMO
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."SOLICITUD_PRESTAMO" ADD FOREIGN KEY ("IDUSUARIO")
	  REFERENCES "SYSTEM"."USUARIO" ("IDENTIFICADOR") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table DETALLE_SOLICITUD_PRESTAMO
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."DETALLE_SOLICITUD_PRESTAMO" ADD FOREIGN KEY ("IDSOLICITUD")
	  REFERENCES "SYSTEM"."SOLICITUD_PRESTAMO" ("IDSOLICITUD") ENABLE;
  ALTER TABLE "SYSTEM"."DETALLE_SOLICITUD_PRESTAMO" ADD FOREIGN KEY ("IDEJEMPLAR")
	  REFERENCES "SYSTEM"."EJEMPLAR" ("IDEJEMPLAR") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table EJEMPLAR
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."EJEMPLAR" ADD FOREIGN KEY ("IDDOCUMENTO")
	  REFERENCES "SYSTEM"."DOCUMENTO" ("IDENTIFICADOR") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table PRESTAMO
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."PRESTAMO" ADD FOREIGN KEY ("IDEJEMPLAR")
	  REFERENCES "SYSTEM"."EJEMPLAR" ("IDEJEMPLAR") ENABLE;
