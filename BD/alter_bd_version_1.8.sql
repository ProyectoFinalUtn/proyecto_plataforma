-- Type: zona_temporal_type

-- DROP TYPE public.zona_temporal_type;

CREATE TYPE public.zona_temporal_type AS
(
  id bigint,
  nombre character varying(32)
);

ALTER TYPE public.zona_temporal_type
    OWNER TO admin;


-- FUNCTION: public.en_zona_temporal(numeric, numeric, numeric)

-- DROP FUNCTION public.en_zona_temporal(numeric, numeric, numeric);

CREATE OR REPLACE FUNCTION public.en_zona_temporal(
	coordx numeric,
	coordy numeric,
	radio numeric)
    RETURNS zona_temporal_type
    LANGUAGE 'plpgsql'

    COST 100
    VOLATILE 
    ROWS 0
AS $BODY$

DECLARE
  resultado zona_temporal_type;

BEGIN
  SELECT id, nombre
  INTO resultado.id, resultado.nombre
  FROM zona_temporal
  WHERE 
    (SELECT ST_DWithin( 
  		(SELECT ST_SetSRID((SELECT ST_GeomFromGeoJSON (geometria::Text)),3857)),                  
  		(SELECT ST_SetSRID(ST_MakePoint(coordx, coordy),3857)),
         radio)
    );
    
  RETURN resultado;

END

$BODY$;

ALTER FUNCTION public.en_zona_temporal(numeric, numeric, numeric)
    OWNER TO admin;

