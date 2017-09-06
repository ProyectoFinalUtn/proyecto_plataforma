-- Table: public.administrador

-- DROP TABLE public.administrador;

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
    OWNER to postgres;

GRANT ALL ON TABLE public.administrador TO admin WITH GRANT OPTION;

GRANT ALL ON TABLE public.administrador TO postgres;


-- Table: public.menus

-- DROP TABLE public.menus;

CREATE TABLE public.menus
(
    id integer NOT NULL,
    name text COLLATE pg_catalog."default" NOT NULL,
    slug text COLLATE pg_catalog."default" NOT NULL,
    parent integer,
    "number" integer NOT NULL,
    icon text COLLATE pg_catalog."default"
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.menus
    OWNER to postgres;

GRANT ALL ON TABLE public.menus TO admin WITH GRANT OPTION;

GRANT ALL ON TABLE public.menus TO postgres;

-- Table: public.perfil

-- DROP TABLE public.perfil;

CREATE TABLE public.perfil
(
    "idPerfil" bigint NOT NULL DEFAULT nextval('"perfil_idPerfil_seq"'::regclass),
    foto text COLLATE pg_catalog."default",
    "logueadoEnCad" boolean NOT NULL,
    CONSTRAINT perfil_pkey PRIMARY KEY ("idPerfil")
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.perfil
    OWNER to admin;
	
-- Table: public.persona

-- DROP TABLE public.persona;

CREATE TABLE public.persona
(
    "idPersona" bigint NOT NULL DEFAULT nextval('"persona_idPersona_seq"'::regclass),
    nombre text COLLATE pg_catalog."default" NOT NULL,
    apellido text COLLATE pg_catalog."default" NOT NULL,
    "idTipoDocumento" integer,
    "nroDocumento" integer,
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
    OWNER to admin;
	
-- Table: public.usuario_vant

-- DROP TABLE public.usuario_vant;

CREATE TABLE public.usuario_vant
(
    "idUsuario" bigint NOT NULL DEFAULT nextval('"UsuarioVant_idUsuario_seq"'::regclass),
    "idRol" integer NOT NULL,
    "idPersona" integer NOT NULL,
    "idPerfil" integer,
    usuario text COLLATE pg_catalog."default" NOT NULL,
    pass text COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT "UsuarioVant_pkey" PRIMARY KEY ("idUsuario")
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.usuario_vant
    OWNER to admin;