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
              'nombre' => $zona["nombre"],     
              'detalle' => $perfil["detalle"],
              'json' => $perfil["json"]
            ]);
            if(!$result){
              $db_error = $this->db->error();
              throw new Exception($db_error);
            }
            return $this->db->insert_id();  
        }
}
?>
