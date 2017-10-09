CREATE TABLE public.zona_temporal
(
    id bigint NOT NULL,
    nombre "char" NOT NULL,
    detalle "char",
    geoJson "json" NOT NULL,
    CONSTRAINT zonas_temporales_pkey PRIMARY KEY (id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.zonas_temporales
    OWNER to admin;