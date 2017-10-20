<?php
class Zonas_temporales_model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
                $this->load->database();                
        }

        public function guardar_zona($zona)
        {
            $result = $this->db->insert('zona_temporal', [
              'id' => $zona["id"],
              'nombre'  => $zona["nombre"],    
              'detalle' => $zona["detalle"],
              'geoJson' => $zona["json"]
            ]); 
            
        }

        public function get_zona_within_radius($punto)
        {
           $columnas = 'id, nombre';
            $this->db->select($columnas);
            $this->db->from('zona_temporal');
            $where = '( ST_DWithin( 
                       ( ST_SetSRID(( ST_GeomFromGeoJSON (geometria::Text)),3857)),                  
                       ( ST_SetSRID(ST_MakePoint('.strval($punto["long"]).','.strval($punto["lat"]).'),3857)),'.strval($punto["rad"]).'))';
            $this->db->where($where);
            $query = $this->db->get()->row();
            return $query;  
            // Produces: SELECT title, content, date FROM mytable   

           
  
              


        }
}
?>
