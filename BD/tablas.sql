CREATE DATABASE goguide ;
--connect goguide ;

CREATE EXTENSION postgis;

CREATE USER admin WITH PASSWORD 'proyecto2017';

GRANT ALL PRIVILEGES ON DATABASE goguide to admin;

-- Table: public.administrador

-- DROP TABLE public.administrador;

CREATE SEQUENCE public.admin_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE public.admin_seq
    OWNER TO admin;

CREATE TABLE public.administrador
(
    id bigint NOT NULL DEFAULT nextval('admin_seq'::regclass),
    nombre text COLLATE pg_catalog."default" NOT NULL,
    password text COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT administrador_pkey PRIMARY KEY (id),
    CONSTRAINT administrador_nombre_key UNIQUE (nombre)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.administrador
    OWNER to admin;

GRANT ALL ON TABLE public.administrador TO admin WITH GRANT OPTION;

GRANT ALL ON TABLE public.administrador TO admin;


-- Table: public.menus

-- DROP TABLE public.menus;

CREATE TABLE public.menus
(
    id integer NOT NULL,
    name text COLLATE pg_catalog."default" NOT NULL,
    slug text COLLATE pg_catalog."default" NOT NULL,
    parent integer,
    orden integer NOT NULL,
    icono text COLLATE pg_catalog."default"
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.menus
    OWNER to admin;

GRANT ALL ON TABLE public.menus TO admin WITH GRANT OPTION;

GRANT ALL ON TABLE public.menus TO admin;


-- Table: public.perfil

-- DROP TABLE public.perfil;

CREATE SEQUENCE public.perfil_id_perfil_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE public.perfil_id_perfil_seq
    OWNER TO admin;

-- Table: public.perfil

-- DROP TABLE public.perfil;

CREATE TABLE public.perfil
(
    id_perfil bigint NOT NULL DEFAULT nextval('perfil_id_perfil_seq'::regclass),
    foto text COLLATE pg_catalog."default",
    logueado_en_cad boolean NOT NULL,
    nombre_de_perfil text COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT perfil_pkey PRIMARY KEY (id_perfil)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.perfil
    OWNER to admin;

-- Table: public.persona

-- DROP TABLE public.persona;

CREATE SEQUENCE public.persona_id_persona_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE public.persona_id_persona_seq
    OWNER TO admin;

CREATE TABLE public.persona
(
    id_persona bigint NOT NULL DEFAULT nextval('persona_id_persona_seq'::regclass),
    nombre text COLLATE pg_catalog."default" NOT NULL,
    apellido text COLLATE pg_catalog."default" NOT NULL,
    id_tipo_documento integer,
    nro_documento integer,
    edad integer,
    sexo "char",
    calle text COLLATE pg_catalog."default",
    numero text COLLATE pg_catalog."default",
    piso text COLLATE pg_catalog."default",
    dpto text COLLATE pg_catalog."default",
    provincia text COLLATE pg_catalog."default",
    localidad text COLLATE pg_catalog."default",
    telefono text COLLATE pg_catalog."default",
    email text COLLATE pg_catalog."default",
    CONSTRAINT persona_pkey PRIMARY KEY (id_persona),
    CONSTRAINT email_unique UNIQUE (email)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.persona
    OWNER to admin;

-- Table: public.usuario_vant

-- DROP TABLE public.usuario_vant;
CREATE SEQUENCE public.usuario_vant_id_usuario_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE public.usuario_vant_id_usuario_seq
    OWNER TO admin;

CREATE TABLE public.usuario_vant
(
    id_usuario bigint NOT NULL DEFAULT nextval('usuario_vant_id_usuario_seq'::regclass),
    id_rol integer NOT NULL,
    id_persona integer NOT NULL,
    id_perfil integer,
    usuario text COLLATE pg_catalog."default",
    pass text COLLATE pg_catalog."default",
    CONSTRAINT usuario_vant_pkey PRIMARY KEY (id_usuario),
	CONSTRAINT id_perfil_perfil FOREIGN KEY (id_perfil)
        REFERENCES public.perfil (id_perfil) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT id_persona_persona FOREIGN KEY (id_persona)
        REFERENCES public.persona (id_persona) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

CREATE SEQUENCE public.usuario_admin_id_usuario_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
	
CREATE TABLE public.usuario_admin
(
    id_usuario integer NOT NULL DEFAULT nextval('usuario_admin_id_usuario_seq'::regclass),
    id_persona bigint,
    id_rol smallint,
    usuario text COLLATE pg_catalog."default",
    password text COLLATE pg_catalog."default",
    CONSTRAINT usuario_admin_pkey PRIMARY KEY (id_usuario)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.usuario_admin
    OWNER to admin;


INSERT INTO usuario_admin (usuario, password)
values    ('admin','202cb962ac59075b964b07152d234b70');

ALTER TABLE public.usuario_admin
    OWNER to admin;
	
-- Table: public.tipo_solicitud

-- DROP TABLE public.tipo_solicitud;

CREATE SEQUENCE public.tipo_solicitud_id_tipo_solicitud_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE public.tipo_solicitud_id_tipo_solicitud_seq
    OWNER TO admin;

CREATE TABLE public.tipo_solicitud
(
    id_tipo_solicitud integer NOT NULL DEFAULT nextval('tipo_solicitud_id_tipo_solicitud_seq'::regclass),
    descripcion text COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT tipo_solicitud_pkey PRIMARY KEY (id_tipo_solicitud)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.tipo_solicitud
    OWNER to admin;
	
-- Table: public.estado_solicitud

-- DROP TABLE public.estado_solicitud;

CREATE SEQUENCE public.estado_solicitud_id_estado_solicitud_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE public.estado_solicitud_id_estado_solicitud_seq
    OWNER TO admin;

CREATE TABLE public.estado_solicitud
(
    id_estado_solicitud smallint NOT NULL DEFAULT nextval('estado_solicitud_id_estado_solicitud_seq'::regclass),
    descripcion text COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT estado_solicitud_pkey PRIMARY KEY (id_estado_solicitud)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.estado_solicitud
    OWNER to admin;
	
-- Table: public.vant

-- DROP TABLE public.vant;

CREATE SEQUENCE public.vant_id_vant_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE public.vant_id_vant_seq
    OWNER TO admin;

CREATE TABLE public.vant
(
    id_vant bigint NOT NULL DEFAULT nextval('vant_id_vant_seq'::regclass),
    id_usuario_vant integer,
    marca text COLLATE pg_catalog."default" NOT NULL,
    modelo text COLLATE pg_catalog."default",
    nro_serie text COLLATE pg_catalog."default",
    fabricante text COLLATE pg_catalog."default",
    lugar_fabricacion text COLLATE pg_catalog."default",
    anio_fabricacion integer,
    alto integer,
    ancho integer,
    largo integer,
	peso smallint,
    vel_max integer,
    alt_max integer,
    lugar_guardado text COLLATE pg_catalog."default",
    color text COLLATE pg_catalog."default",
    activo smallint NOT NULL,
    CONSTRAINT vant_pkey PRIMARY KEY (id_vant),
    CONSTRAINT id_usuario_vant_usuario FOREIGN KEY (id_usuario_vant)
        REFERENCES public.usuario_vant (id_usuario) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.vant
    OWNER to admin;
	
	
-- Table: public.solicitud

-- DROP TABLE public.solicitud;

CREATE SEQUENCE public.solicitud_id_solicitud_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE public.solicitud_id_solicitud_seq
    OWNER TO admin;

CREATE TABLE public.solicitud
(
    id_solicitud bigint NOT NULL DEFAULT nextval('solicitud_id_solicitud_seq'::regclass),
    id_usuario_vant bigint NOT NULL,
    id_tipo_solicitud integer NOT NULL,
    id_usuario_aprobador integer,
    id_estado_solicitud smallint NOT NULL,
    latitud text COLLATE pg_catalog."default" NOT NULL,
    longitud text COLLATE pg_catalog."default" NOT NULL,
    radio_vuelo text COLLATE pg_catalog."default" NOT NULL,
    fecha_hora_vuelo date NOT NULL,
    CONSTRAINT solicitud_pkey PRIMARY KEY (id_solicitud),
    CONSTRAINT id_estado_solicitud_solicitud FOREIGN KEY (id_estado_solicitud)
        REFERENCES public.estado_solicitud (id_estado_solicitud) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
    CONSTRAINT id_usuario_aprobador_usuario FOREIGN KEY (id_usuario_aprobador)
        REFERENCES public.usuario_admin (id_usuario) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
    CONSTRAINT id_usuario_vant_solicitud FOREIGN KEY (id_usuario_vant)
        REFERENCES public.usuario_vant (id_usuario) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.solicitud
    OWNER to admin;
	
-- Table: public.vants_por_solicitud

-- DROP TABLE public.vants_por_solicitud;

CREATE TABLE public.vants_por_solicitud
(
    id_solicitud bigint NOT NULL,
    id_vant bigint,
    CONSTRAINT vants_por_solicitud_pkey PRIMARY KEY (id_solicitud),
    CONSTRAINT id_solicitud_solicitud FOREIGN KEY (id_solicitud)
        REFERENCES public.solicitud (id_solicitud) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT id_vant_vant FOREIGN KEY (id_vant)
        REFERENCES public.vant (id_vant) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.vants_por_solicitud
    OWNER to admin;

INSERT INTO usuario_admin (usuario, password)
values    ('admin','202cb962ac59075b964b07152d234b70');

INSERT INTO menus (id, parent, name, icono, slug, orden) VALUES
(1, NULL, 'Normativa', '', 'normativas', 1),
(2, NULL, 'Usuarios VANT', '', 'usuarios_vant', 2),
(3, NULL, 'Solicitudes de Excepcion', '', 'solicitudes_excepcion', 3),
(4, 1, 'Zonas de Influencia', '', 'zonas_influencia', 1),
(5, 1, 'Cargar Zonas', '', 'cargar_zonas', 2),
(6, 1, 'Zonas Temporales', '', 'zonas_temporales', 1),
(7, 2, 'Listar Usuarios', '', 'listar_usuarios', 2),
(8, 3, 'Listar Solicitudes', '', 'listar_solicitudes', 2);
