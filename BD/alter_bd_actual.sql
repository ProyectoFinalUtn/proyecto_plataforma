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
    marca text COLLATE pg_catalog."default" NOT NULL,
    modelo text COLLATE pg_catalog."default",
    nro_serie text COLLATE pg_catalog."default",
    fabricante text COLLATE pg_catalog."default",
    lugar_fabricacion text COLLATE pg_catalog."default",
    anio_fabricacion text COLLATE pg_catalog."default",
    alto integer,
    ancho integer,
    largo integer,
    vel_max integer,
    alt_max integer,
    lugar_guardado text COLLATE pg_catalog."default",
    CONSTRAINT vant_pkey PRIMARY KEY (id_vant)
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