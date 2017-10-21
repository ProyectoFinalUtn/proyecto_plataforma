<?php
    class Provincia_model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
                $this->load->database();                
        }
              
        public function obtener_provincias()
        {        
            $sql = 'id_provincia, provincia';
            $this->db->select($sql);
            $this->db->from('provincia');
            $this->db->order_by('id_provincia', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_localidades($idProvincia)
        {        
            $sql = 'id_localidad, id_provincia, localidad';
            $this->db->select($sql);
            $this->db->from('localidad');
            $this->db->where('id_provincia = ', $idProvincia);
            $this->db->order_by('id_provincia', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        

    }
?>
