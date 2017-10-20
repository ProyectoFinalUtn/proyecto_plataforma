-- Table: public.zona_temporal

-- DROP TABLE public.zona_temporal;

CREATE TABLE public.zona_temporal
(
    id bigint NOT NULL,
    nombre text COLLATE pg_catalog."default" NOT NULL,
    detalle text COLLATE pg_catalog."default",
    geometria json,
    propiedades json,
    CONSTRAINT zonas_temporales_pkey PRIMARY KEY (id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.zona_temporal
    OWNER to postgres;

GRANT ALL ON TABLE public.zona_temporal TO admin WITH GRANT OPTION;

GRANT ALL ON TABLE public.zona_temporal TO postgres;

ALTER TABLE public.zonas_temporales
    OWNER to admin;