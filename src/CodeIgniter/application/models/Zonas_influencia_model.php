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
                $id = $ft["properties"]["id"];
                $props = json_encode($ft["properties"]);
                $dataInsert = array('id' => $id,
                                'nombre_capa'  => $nombre_capa,    
                                'geometria' => $geom,
                                'propiedades' => $props,
                                'radio' => $radio,
                                'detalle' => $detalle);                
                $this->db->insert('zona_influencia', $dataInsert);                                        
            }
        }

        public function buscar_zonas()
        {          
          $columnas = 'nombre_capa, ST_AsGeoJSON(ST_Transform(ST_SetSRID((ST_GeomFromGeoJSON (geometria::Text)),4326), 3857)) geometria, propiedades,detalle';
          $this->db->select($columnas);
          $this->db->from('zona_influencia');          
          $query = $this->db->get();
          return $query->result_array();
        }

        public function eliminar_zona($data)
        {
          //$id = strval($data["id"]);
          //$this->db->delete('zona_temporal', array('id' => $id));
        }

        public function get_zona_influencia($punto)
        {
            $columnas = 'id, nombre_capa, geometria, detalle';
            $this->db->select($columnas);
            $this->db->from('zona_influencia');
            $where = '( ST_DWithin( 
                       ( ST_SetSRID(( ST_GeomFromGeoJSON (geometria::Text)),4326)),                  
                       ( ST_SetSRID(ST_MakePoint('.strval($punto["long"]).','.strval($punto["lat"]).'),4326)),radio +'.strval($punto["rad"]).'))';
            $this->db->where($where);
            $query = $this->db->get();            
            return $query->result_array();
        }
}
?>
