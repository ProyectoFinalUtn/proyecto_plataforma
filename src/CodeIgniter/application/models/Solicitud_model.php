<?php
    class Solicitud_model extends CI_Model {

        public function __construct()
        {
            parent::__construct();
            $this->load->database();       
        }
              
        public function obtener_vant_por_usuario($idUsuario)
        {        
            $sql = 'id_vant idVant, id_usuario_vant idUsuarioVant, marca, modelo, nro_serie, fabricante, lugar_fabricacion lFab '. 
                   'anio_fabricacion anioFab, alto, ancho, largo, vel_max velMax, '.
                   'alt_max altMax, peso, color, lugar_guardado lGuardado';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->where('id_usuario_vant = ', $idUsuario);
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_vant_por_id($idVant)
        {        
            $sql = 'id_vant idVant, id_usuario_vant idUsuarioVant, marca, modelo, nro_serie, fabricante, lugar_fabricacion lFab '. 
                   'anio_fabricacion anioFab, alto, ancho, largo, vel_max velMax, '.
                   'alt_max altMax, peso, color, lugar_guardado lGuardado';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->where('id_vant = ', $idVant);
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
                $result = $this->db->insert('vants_por_solicitud', [
                    'id_solicitud' => $solicitud["idSolicitud"],
                    'id_vant' => $solicitud['vants'][$i]['idVant']
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
                'id_usuario_vant' => $solicitud["idUsuarioVant"],
                'id_tipo_solicitud' => $solicitud['idTipoSolicitud'],     
                'id_estado_solicitud' => $solicitud['idEstadoSolicitud'],
                'latitud' => $solicitud['latitud'],
                'longitud' => $solicitud['longitud'],
                'radio_vuelo' => $solicitud['radioVuelo'],
                'fecha_hora_vuelo' => $solicitud['fechaHoraVuelo']
            ]);
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            return $this->db->insert_id();  
        }
        
        public function modifica_solicitud($solicitud)
        {
            $this->db->where('id_solicitud', $solicitud["idSolicitud"]);
            $result = $this->db->update('solicitud', [
                'id_usuario_vant' => $solicitud["idUsuarioVant"],
                'id_tipo_solicitud' => $solicitud['idTipoSolicitud'],     
                'id_estado_solicitud' => $solicitud['idEstadoSolicitud'],
                'latitud' => $solicitud['latitud'],
                'longitud' => $solicitud['longitud'],
                'radio_vuelo' => $solicitud['radioVuelo'],
                'fecha_hora_vuelo' => $solicitud['fechaHoraVuelo']
            ]);
            
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            return;  
        }
        
        public function modifica_vant_solicitud($solicitud)
        {
            $this->db->where('id_solicitud', $solicitud["idSolicitud"]);
            $result=$this->db->delete('vants_por_solicitud');   
            
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            
            $this->guardar_vant_solicitud($solicitud);
            return;  
        }
    }
?>
