<?php
    class Usuariovant_model extends CI_Model {

        public function __construct()
        {
            parent::__construct();
            $this->load->database();       
        }

        public function get_password($nombre)
        {
            $this->db->select('password');
            $query = $this->db->get_where('administrador', array('nombre =' => $nombre))->row();
            if (count($query) > 0) {
               return $query->password;
            }else {
                return NULL;
            }
        }
        
        public function crear_perfil($perfil)
        {        
            //$this->db->trans_begin();    
            $this->db->trans_start(true);
            $this->load->model('Persona_model');
            $id_persona = $this->Persona_model->guardar_persona($perfil);
            //$error = $this->db->error(); 
            $id_perfil = $this->guardar_perfil($perfil);
            $perfil["idPersona"] = $id_persona;
            $perfil["idPerfil"] = $id_perfil;
            $perfil["usuarioCad"] = null;
            $perfil["passCad"] = null;
            $id_usuario = $this->guardar_usuario_vant($perfil);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE)
            {
                //$this->db->trans_rollback();
                throw new Exception("Se producto un error al guardar los datos del perfil");
            }
            else
            {
                //$this->db->trans_commit();
                return $id_usuario;
            }
        }
        
        private function guardar_perfil($perfil)
        {
            $this->db->insert('perfil', [
                'foto' => $perfil["fotoPerfil"],
                'logueadoEnCad' => $perfil['logueadoEnCad'],     
                'nombreDePerfil' => $perfil["nombreDePerfil"]
            ]);
            return $this->db->insert_id();
        }

        public function guardar_usuario_vant($usuario)
        {        
            $this->db->insert('usuario_vant', [
                'idRol' => 1,
                'idPersona' => $usuario["idPersona"],     
                'idPerfil' => $usuario["idPerfil"],    
                'usuarioCad' => $usuario["usuarioCad"],
                'passCad' => $usuario["passCad"]
            ]);
            return $this->db->insert_id();  
        }
    }
?>