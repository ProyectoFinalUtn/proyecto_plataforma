ALTER TABLE public.vants_por_solicitud
    OWNER to admin;

ALTER TABLE public.solicitud
    RENAME fecha_hora_vuelo TO fecha_vuelo;

ALTER TABLE public.solicitud
    ADD COLUMN hora_vuelo_desde time without time zone NOT NULL;

ALTER TABLE public.solicitud
    ADD COLUMN hora_vuelo_hasta time without time zone NOT NULL;
