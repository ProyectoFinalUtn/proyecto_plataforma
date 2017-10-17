CREATE OR REPLACE FUNCTION cant_por_rango(desde time without time zone, hasta time without time zone) RETURNS INT AS $$
	BEGIN
		RETURN (select count(id_solicitud) cantidad from solicitud where hora_vuelo_desde between desde and hasta);
	END;
	$$ LANGUAGE plpgsql;