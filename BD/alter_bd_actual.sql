ALTER TABLE public.menus
    RENAME icon TO icono;

ALTER TABLE public.menus
    RENAME "number" TO orden;

CREATE SEQUENCE public.perfil_id_perfil_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE public.perfil_id_perfil_seq
    OWNER TO postgres;

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
    OWNER to postgres;

-- Table: public.persona

-- DROP TABLE public.persona;

CREATE SEQUENCE public.persona_id_persona_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE public.persona_id_persona_seq
    OWNER TO postgres;

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
    OWNER to postgres;

-- Table: public.usuario_vant

-- DROP TABLE public.usuario_vant;
CREATE SEQUENCE public.usuario_vant_id_usuario_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE public.usuario_vant_id_usuario_seq
    OWNER TO postgres;

CREATE TABLE public.usuario_vant
(
    id_usuario bigint NOT NULL DEFAULT nextval('usuario_vant_id_usuario_seq'::regclass),
    id_rol integer NOT NULL,
    id_persona integer NOT NULL,
    id_perfil integer,
    usuario text COLLATE pg_catalog."default",
    pass text COLLATE pg_catalog."default",
    CONSTRAINT usuario_vant_pkey PRIMARY KEY (id_usuario)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.usuario_vant
    OWNER to admin;

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
    OWNER to postgres;


INSERT INTO usuario_admin (usuario, password)
values    ('admin','202cb962ac59075b964b07152d234b70');

ALTER TABLE public.usuario_admin
    OWNER to postgres;
	
INSERT INTO menus (id, parent, name, icono, slug, orden) VALUES
(1, NULL, 'Normativa', '', 'normativas', 1),
(2, NULL, 'Usuarios VANT', '', 'usuarios_vant', 2),
(3, NULL, 'Solicitudes de Excepcion', '', 'solicitudes_excepcion', 3),
(4, 1, 'Zonas de Influencia', '', 'zonas_influencia', 1),
(5, 1, 'Cargar Zonas', '', 'cargar_zonas', 2),
(6, 1, 'Zonas Temporales', '', 'zonas_temporales', 1),
(7, 2, 'Listar Usuarios', '', 'listar_usuarios', 2),
(8, 3, 'Listar Solicitudes', '', 'listar_solicitudes', 2);

CREATE OR REPLACE FUNCTION encripta_pass()
    RETURNS trigger AS '
    BEGIN
        UPDATE usuario_vant set pass = MD5(NEW.pass) where 
        id_usuario = NEW.id_usuario;
    END' LANGUAGE 'plpgsql';
	
CREATE TRIGGER trigger_encripta_pass
AFTER INSERT or UPDATE ON usuario_vant
FOR EACH ROW 
EXECUTE PROCEDURE encripta_pass();