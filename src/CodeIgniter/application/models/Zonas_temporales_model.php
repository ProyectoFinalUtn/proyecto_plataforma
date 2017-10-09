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
}
?>
