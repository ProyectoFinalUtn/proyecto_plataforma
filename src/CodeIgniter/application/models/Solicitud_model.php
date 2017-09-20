<?php
    class Solicitud_model extends CI_Model {

        public function __construct()
        {
            parent::__construct();
            $this->load->database();       
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
        
        public function obtener_solicitudes_por_usuario($idUsuario)
        {        
            $this->db->select('usuario_vant.id_usuario, usuario_vant.id_rol, usuario_vant.usuario, usuario_vant.pass, pers.*, perf.* ');    
            $this->db->from('usuario_vant');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->where('pers.id', $idUsuario);
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_solicitud_por_id($idSolicitud)
        {        
            $this->db->select('usuario_vant.id_usuario, usuario_vant.id_rol, usuario_vant.usuario, usuario_vant.pass, pers.*, perf.* ');    
            $this->db->from('usuario_vant');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->where('pers.id', $idSolicitud);
            $query = $this->db->get()->row();
            return $query;
        }
        
        public function crear_solicitud($solicitud)
        {        
            $this->db->trans_begin();  
            $id_solicitud = $this->guardar_solicitud($solicitud);
            $solicitud["idSolicitud"] = $id_solicitud;
            $solicitud['idEstadoSolicitud'] = 1;
            $this->guardar_vant_solicitud($solicitud);
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                throw new Exception("Se producto un error al guardar la solicitud");
            }
            else
            {
                $this->db->trans_commit();
                return $id_solicitud;
            }
        }
        
        public function cambiar_solicitud($solicitud)
        {
            $this->db->trans_begin();  
            $this->modificar_solicitud($solicitud);
            $solicitud['idEstadoSolicitud'] = 1;
            $this->modificar_vant_solicitud($solicitud);
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                throw new Exception("Se producto un error al modificar la solicitud");
            }
            else
            {
                $this->db->trans_commit();
                return;
            }
        }
        
        private function guardar_vant_solicitud($solicitud)
        {
            for ($i = 0; $i <= count($solicitud['vants']); $i++) {
                $result = $this->db->insert('solicitud', [
                    'id_solicitud' => $solicitud["idSolicitud"],
                    'id_vant' => $solicitud['idVant']
                ]);
                if(!$result){
                    $db_error = $this->db->error();
                    throw new Exception($db_error);
                }
            }
            return;  
        }
        
        private function guardar_solicitud($solicitud)
        {
            $result = $this->db->insert('solicitud', [
                'id_usuario_vant' => $solicitud["fotoPerfil"],
                'id_tipo_solicitud' => $solicitud['logueadoEnCad'],     
                'id_estado_solicitud' => $solicitud['idEstadoSolicitud'],
                'latitud' => $solicitud['latitud'],
                'longitud' => $solicitud['longitud'],
                'radio_vuelo' => $solicitud['longitud'],
                'fecha_hora_vuelo' => $solicitud['longitud']
            ]);
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            return $this->db->insert_id();  
        }
        
        private function modificar_vant_solicitud($solicitud)
        {
            $this->db->where('id_solicitud', $solicitud["idSolicitud"]);
            $this->db->delete('vants_por_solicitud');
            $this->db->where('solicitud', $solicitud["idSolicitud"]);
            $this->guardar_vant_solicitud($solicitud);            
        }
    }
?>
