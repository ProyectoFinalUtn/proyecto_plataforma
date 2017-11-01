<?php
    class Registrovuelo_model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
                $this->load->database();                
        }
              
        public function guardar_vuelo($vuelo)
        {
            $result = $this->db->insert('vuelo', [
                'id_usuario_vant' => $vuelo["idUsuarioVant"],  
                'latitud' => $vuelo['latitud'],
                'longitud' => $vuelo['longitud']
            ]);
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            return $this->db->insert_id();  
        }
    }
?>
