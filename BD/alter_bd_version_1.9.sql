-- Table: public.momento

-- DROP TABLE public.momento;

CREATE TABLE public.momento
(
    id_momento bigint NOT NULL,
    descripcion text COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT momento_pkey PRIMARY KEY (id_momento)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.momento
    OWNER to admin;
	
INSERT INTO public.momento (id_momento, descripcion)
values (1, 'Madrugada'),
(2, 'Mañana'),
(3, 'Tarde'),
(4, 'Noche');
	
-- Table: public.horario

-- DROP TABLE public.horario;

CREATE TABLE public.horario
(
    id_horario bigint NOT NULL,
    rango text COLLATE pg_catalog."default",
    rango_desde time without time zone,
    rango_hasta time without time zone,
    id_momento bigint,
    CONSTRAINT horario_pkey PRIMARY KEY (id_horario),
    CONSTRAINT horario_momento_fkey FOREIGN KEY (id_momento)
        REFERENCES public.momento (id_momento) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.horario
    OWNER to admin;

INSERT INTO public.horario(id_horario, rango, rango_desde, rango_hasta, id_momento)
values (0,'00 a 01','00:00:00','01:00:00', 1),
(1,'01 a 02','01:00:00','02:00:00', 1),
(2,'02 a 03','02:00:00','03:00:00', 1),
(3,'03 a 04','03:00:00','04:00:00', 1),
(4,'04 a 05','04:00:00','05:00:00', 1),
(5,'05 a 06','05:00:00','06:00:00', 1),
(6,'06 a 07','06:00:00','07:00:00', 2),
(7,'07 a 08','07:00:00','08:00:00', 2),
(8,'08 a 09','08:00:00','09:00:00', 2),
(9,'09 a 10','09:00:00','10:00:00', 2),
(10,'10 a 11','10:00:00','11:00:00', 2),
(11,'11 a 12','11:00:00','12:00:00', 2),
(12,'12 a 13','12:00:00','13:00:00', 2),
(13,'13 a 14','13:00:00','14:00:00', 3),
(14,'14 a 15','14:00:00','15:00:00', 3),
(15,'15 a 16','15:00:00','16:00:00', 3),
(16,'16 a 17','16:00:00','17:00:00', 3),
(17,'17 a 18','17:00:00','18:00:00', 3),
(18,'18 a 19','18:00:00','19:00:00', 3),
(19,'19 a 20','19:00:00','20:00:00', 4),
(20,'20 a 21','20:00:00','21:00:00', 4),
(21,'21 a 22','21:00:00','22:00:00', 4),
(22,'22 a 23','22:00:00','23:00:00', 4),
(23,'23 a 00','23:00:00','23:59:59', 4);

CREATE OR REPLACE FUNCTION cant_por_rango(desde time without time zone, hasta time without time zone) RETURNS INT AS $$
	BEGIN
		RETURN (select count(id_solicitud) cantidad from solicitud where hora_vuelo_desde between desde and hasta);
	END;
	$$ LANGUAGE plpgsql;