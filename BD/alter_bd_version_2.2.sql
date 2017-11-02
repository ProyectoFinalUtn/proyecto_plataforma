DROP TABLE public.vuelo;

CREATE TABLE public.vuelo
(
    id_vuelo bigint NOT NULL DEFAULT nextval('vuelo_id_vuelo_seq'::regclass),
    id_usuario_vant bigint,
    latitud text COLLATE pg_catalog."default" NOT NULL,
    longitud text COLLATE pg_catalog."default" NOT NULL,
    provincia bigint,
    localidad bigint,
    zona_interes text COLLATE pg_catalog."default",
	fecha_vuelo date NOT NULL,
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