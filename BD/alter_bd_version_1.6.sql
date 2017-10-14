CREATE SEQUENCE public.normativa_id_normativa_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE public.normativa_id_normativa_seq
    OWNER TO admin;

-- Table: public.normativa

-- DROP TABLE public.normativa;

CREATE TABLE public.normativa
(
    id_normativa bigint NOT NULL DEFAULT nextval('normativa_id_normativa_seq'::regclass),
    descripcion text COLLATE pg_catalog."default" NOT NULL,
    fecha_desde date NOT NULL,
    fecha_hasta date,
    CONSTRAINT normativa_pkey PRIMARY KEY (id_normativa)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.normativa
    OWNER to admin;