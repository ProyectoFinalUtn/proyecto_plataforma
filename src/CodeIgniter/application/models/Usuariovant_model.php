<?php
    class Usuariovant_model extends CI_Model {

        public function __construct()
        {
            parent::__construct();
            $this->load->database();       
        }

        public function login_user($usuario, $pass)
        {
            $query = $this->db->get_where('usuario_vant', array('usuario =' => $usuario))->row();
            if (count($query) > 0) {
               if(md5($query->password) != $pass){
                   throw new Exception("Password invalido");
               }
               return $query;
            }else {
               throw new Exception("Usuario invalido");
            }
        }
        
        public function crear_perfil($perfil)
        {        
            $this->db->trans_begin();  
            //$this->db->trans_start(TRUE);
            $this->load->model('Persona_model');
            $id_persona = $this->Persona_model->guardar_persona($perfil);
            //$error = $this->db->error(); 
            $id_perfil = $this->guardar_perfil($perfil);
            $perfil["idPersona"] = $id_persona;
            $perfil["idPerfil"] = $id_perfil;
            $id_usuario = $this->guardar_usuario_vant($perfil);
            //$this->db->trans_complete();
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                throw new Exception("Se producto un error al guardar los datos del perfil");
            }
            else
            {
                $this->db->trans_commit();
                return $id_usuario;
            }
        }
        
        public function obtener_perfiles()
        {        
            $this->db->select('us.id_usuario, us.id_rol, us.usuario, us.pass, pers.*, perf.* ');    
            $this->db->from('usuario_vant us');
            $this->db->join('persona pers', 'us.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'us.id_perfil = perf.id_perfil');
            $query = $this->db->get();
            return $query->result();
        }
        
        public function obtener_usuarios_habilitados()
        {   $this->db->select('*');    
            $this->db->from('usuario_vant');     
            return $this->db->get()->result_array();
        }
        
        public function obtener_perfil_por_id($idUsuario)
        {        
            $this->db->select('usuario_vant.id_usuario, usuario_vant.id_rol, usuario_vant.usuario, usuario_vant.pass, pers.*, perf.* ');    
            $this->db->from('usuario_vant');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->where('pers.id', $idUsuario);
            $query = $this->db->get()->row();
            return $query->result();
        }
        
        public function obtener_perfil_usuario($usuario, $pass)
        {        
            $this->db->select('usuario_vant.id_usuario, usuario_vant.id_rol, usuario_vant.usuario, usuario_vant.pass, pers.*, perf.* ');    
            $this->db->from('usuario_vant');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->where('usuario_vant.usuario', $usuario);
            $this->db->where('usuario_vant.pass', md5($pass));
            $query = $this->db->get()->row();
            if (count($query) <= 0) {
                throw new Exception("El usuario que intenta modificar no se encuentra logueado");               
            }
            return $query;
        }
        
        public function cambiar_perfil($perfil)
        {        
            $this->db->trans_begin();  
            $this->load->model('Persona_model');
            $perfilModificacion = $this->obtener_perfil_usuario($perfil['usuario'], $perfil['pass']);            
            $perfil["idPersona"] = $perfilModificacion->id_persona;
            $perfil["idPerfil"] = $perfilModificacion->id_perfil;
            $perfil["idUsuarioVant"] = $perfilModificacion->id_usuario;
            $this->Persona_model->modifica_persona($perfil, $perfilModificacion);            
            $this->modificar_perfil($perfil);
            $this->modificar_usuario_vant($perfil);
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                throw new Exception("Se producto un error al modificar los datos del perfil");
            }
            else
            {
                $this->db->trans_commit();
            }
        }
        
        private function guardar_perfil($perfil)
        {
            $result = $this->db->insert('perfil', [
                'foto' => $perfil["fotoPerfil"],
                'logueado_en_cad' => $perfil['logueadoEnCad'],     
                'nombre_de_perfil' => $perfil["nombreDePerfil"]
            ]);
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            return $this->db->insert_id();  
        }
        
        private function modificar_perfil($perfil)
        {
            $this->db->where('id_perfil', $perfil["idPerfil"]);
            $result = $this->db->update('perfil', [
                'foto' => $perfil["fotoPerfil"],
                'logueado_en_cad' => $perfil['logueadoEnCad'],     
                'nombre_de_perfil' => $perfil["nombreDePerfil"]
            ]);
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            };  
        }

        private function guardar_usuario_vant($usuario)
        {        
            $result = $this->db->insert('usuario_vant', [
                'id_rol' => 1,
                'id_persona' => $usuario["idPersona"],     
                'id_perfil' => $usuario["idPerfil"],    
                'usuario' => $usuario["usuario"],
                'pass' =>  md5($usuario["pass"])
            ]);
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            return $this->db->insert_id();  
        }
        
        private function modificar_usuario_vant($usuario)
        {
            $this->db->where('id_usuario', $usuario["idUsuarioVant"]);
            $result = $this->db->update('usuario_vant', [
                'id_rol' => 1,
                'id_persona' => $usuario["idPersona"],     
                'id_perfil' => $usuario["idPerfil"],    
                'usuario' => $usuario["usuario"],
                'pass' =>  md5($usuario["pass"])
            ]);
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            return;  
        }
        
        
    }
?>