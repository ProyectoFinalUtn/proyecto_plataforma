<?php
class Zonas_influencia_model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
                $this->load->database();                
        }

        public function guardar_zona($zonas)
        {   
            $nombre_capa = $zonas["nombre_zona"];
            $radio = $zonas["radio_zona"];
            $detalle = $zonas["detalle_zona"];
            $features = json_decode( $zonas["archivo"], true );
            foreach ($features["features"] as $ft) {
                $geom = json_encode($ft["geometry"]);                
                $props = json_encode($ft["properties"]);
                $dataInsert = array('nombre_capa' => $nombre_capa,    
                                'geometria' => $geom,
                                'propiedades' => $props,
                                'radio' => $radio,
                                'detalle' => $detalle);                
                $this->db->insert('zona_influencia', $dataInsert);                                        
            }
        }

        public function buscar_zonas($zonas)
        {          
          $columnas = 'nombre_capa, ST_AsGeoJSON(ST_Transform(ST_SetSRID((ST_GeomFromGeoJSON (geometria::Text)),4326), 3857)) geometria, propiedades,detalle';
          $this->db->select($columnas);

          if ($zonas['zona'] != ''){
            $this->db->where("nombre_capa ='".$zonas['zona']."'");
          }
          $this->db->from('zona_influencia');          
          $query = $this->db->get();
          return $query->result_array();
        }

        public function buscar_nombres_capa()
        {          
          $columnas = 'nombre_capa';
          $this->db->distinct();
          $this->db->select($columnas);
          $this->db->from('zona_influencia');          
          $query = $this->db->get();
          return $query->result_array();
        }

        public function eliminar_zona($data)
        {
          $nombre_capa = strval($data["nombre_capa"]);
          $this->db->delete('zona_influencia', array('nombre_capa' => $nombre_capa));
        }

        public function get_zona_influencia($punto)
        {
            /*$columnas = 'id, nombre_capa, geometria, detalle';
            $this->db->select($columnas);
            $this->db->from('zona_influencia');
            $where = '( ST_DWithin( 
                       ( ST_SetSRID(( ST_GeomFromGeoJSON (geometria::Text)),4326)),                  
                       ( ST_SetSRID(ST_MakePoint('.strval($punto["long"]).','.strval($punto["lat"]).'),4326)),radio +'.strval($punto["rad"]).'))';
            $this->db->where($where);
            $query = $this->db->get();            
            return $query->result_array();*/
            $columnas = 'id, nombre_capa, 
                        ST_AsGeoJSON(ST_Transform(ST_Buffer(ST_Transform(ST_SetSRID(ST_GeomFromGeoJSON (geometria::Text), 4326), 3857), radio), 4326)) geometria, 
                        propiedades';
            $this->db->select($columnas);
            $this->db->from('zona_influencia');
            $where = "( ST_DWithin( 
                        ( ST_SetSRID(( ST_Transform(ST_SetSRID(ST_GeomFromGeoJSON (geometria::Text), 4326), 3857)),3857)),                  
                        ( ST_SetSRID(ST_Transform(ST_GeomFromText('POINT(".strval($punto["long"])." ".strval($punto["lat"]).")', 4326), 3857),3857)), 
                            radio + ".strval($punto["rad"]).")) ";
            $this->db->where($where);
            $this->db->limit(5);
            $query = $this->db->get();            
            return $query->result_array();
        }
    }
?>
