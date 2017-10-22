ALTER TABLE public.persona DROP COLUMN provincia;

ALTER TABLE public.persona DROP COLUMN localidad;

ALTER TABLE public.persona
    ADD COLUMN provincia bigint;

ALTER TABLE public.persona
    ADD COLUMN localidad bigint;
ALTER TABLE public.persona
    ADD CONSTRAINT provincia_fkey FOREIGN KEY (provincia)
    REFERENCES public.provincia (id_provincia) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;

ALTER TABLE public.persona
    ADD CONSTRAINT localidad_fkey FOREIGN KEY (localidad)
    REFERENCES public.localidad (id_localidad) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION;
	
ALTER TABLE public.perfil
    ADD COLUMN fecha_registro date;