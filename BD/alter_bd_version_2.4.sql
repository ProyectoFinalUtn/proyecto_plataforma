-- Table: public.zona_influencia

-- DROP TABLE public.zona_influencia;


CREATE SEQUENCE public.zona_influencia_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;

ALTER SEQUENCE public.zona_influencia_seq
    OWNER TO admin;



CREATE TABLE public.zona_influencia
(
    id bigint NOT NULL DEFAULT nextval('zona_influencia_seq'::regclass),
    nombre_capa text NOT NULL,
    geometria json NOT NULL,
    propiedades json NOT NULL,
    radio bigint NOT NULL,
    detalle text,
    CONSTRAINT zona_influencia_pkey PRIMARY KEY (id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.zona_influencia
    OWNER to admin;