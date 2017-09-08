ALTER TABLE public.menus
    RENAME icon TO icono;

ALTER TABLE public.menus
    RENAME "number" TO orden;

-- Table: public.perfil

-- DROP TABLE public.perfil;

CREATE SEQUENCE public.perfil_idPerfil_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE public.perfil_idPerfil_seq
    OWNER TO postgres;

CREATE TABLE public.perfil
(
    idPerfil bigint NOT NULL DEFAULT nextval('perfil_idPerfil_seq'::regclass),
    foto text COLLATE pg_catalog."default",
    logueadoEnCad boolean NOT NULL,
    CONSTRAINT perfil_pkey PRIMARY KEY ("idPerfil")
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.perfil
    OWNER to postgres;

-- Table: public.persona

-- DROP TABLE public.persona;

CREATE SEQUENCE public.persona_idPersona_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE public.persona_idPersona_seq
    OWNER TO postgres;

CREATE TABLE public.persona
(
    idPersona bigint NOT NULL DEFAULT nextval('persona_idPersona_seq'::regclass),
    nombre text COLLATE pg_catalog."default" NOT NULL,
    apellido text COLLATE pg_catalog."default" NOT NULL,
    idTipoDocumento integer,
    nroDocumento integer,
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
    CONSTRAINT persona_pkey PRIMARY KEY ("idPersona")
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.persona
    OWNER to postgres;

-- Table: public.usuario_vant

-- DROP TABLE public.usuario_vant;
CREATE SEQUENCE public.UsuarioVant_idUsuario_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE public.UsuarioVant_idUsuario_seq
    OWNER TO postgres;

CREATE TABLE public.usuario_vant
(
    idUsuario bigint NOT NULL DEFAULT nextval('UsuarioVant_idUsuario_seq'::regclass),
    idRol integer NOT NULL,
    idPersona integer NOT NULL,
    idPerfil integer,
    usuario text COLLATE pg_catalog."default" NOT NULL,
    pass text COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT "UsuarioVant_pkey" PRIMARY KEY ("idUsuario")
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.usuario_vant
    OWNER to postgres;	
	
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