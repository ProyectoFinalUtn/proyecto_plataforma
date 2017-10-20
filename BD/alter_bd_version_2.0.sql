CREATE SEQUENCE public.vuelo_id_vuelo_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE public.vuelo_id_vuelo_seq
    OWNER TO admin;

-- Table: public.vuelo

-- DROP TABLE public.vuelo;

CREATE TABLE public.vuelo
(
    id_vuelo bigint NOT NULL DEFAULT nextval('vuelo_id_vuelo_seq'::regclass),
    id_usuario_vant bigint NOT NULL,
    latitud text COLLATE pg_catalog."default" NOT NULL,
    longitud text COLLATE pg_catalog."default" NOT NULL,
    provincia text COLLATE pg_catalog."default",
    localidad text COLLATE pg_catalog."default",
    zona_interes text COLLATE pg_catalog."default",
    CONSTRAINT vuelo_pkey PRIMARY KEY (id_vuelo),
    CONSTRAINT usuariovant_fkey FOREIGN KEY (id_usuario_vant)
        REFERENCES public.usuario_vant (id_usuario) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.vuelo
    OWNER to admin;