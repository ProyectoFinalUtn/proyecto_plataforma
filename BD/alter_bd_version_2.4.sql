-- Table: public.zona_influencia

-- DROP TABLE public.zona_influencia;

CREATE TABLE public.zona_influencia
(
    id bigint NOT NULL,
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