ALTER TABLE public.vants_por_solicitud DROP CONSTRAINT vants_por_solicitud_pkey;
ALTER TABLE public.vants_por_solicitud
    ADD CONSTRAINT vants_por_solicitud_pkey PRIMARY KEY (id_solicitud, id_vant);
