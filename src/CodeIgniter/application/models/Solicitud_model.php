<?php
    class Solicitud_model extends CI_Model {

        public function __construct()
        {
            parent::__construct();
            $this->load->database();       
        }
              
        public function obtener_solicitudes()
        {        
            $sql = 'sol.id_solicitud idSolicitud, id_usuario_vant idUsuarioVant, pers.nombre nombre, pers.apellido apellido, pers.nro_documento documento, '. 
                   'pers.edad edad, pers.email email, id_tipo_solicitud idTipoSolicitud, '.
                   'id_usuario_aprobador idUsuarioAprobador, adm.usuario usuarioAprobador, sol.id_estado_solicitud idEstadoSolicitud, '.
                   'es.descripcion descripcionEstadoSolicitud, latitud, longitud, radio_vuelo radioVuelo, '.
                   "to_char(fecha_vuelo, 'YYYY-MM-DD') fecha, hora_vuelo_desde horaVueloDesde, hora_vuelo_hasta horaVueloHasta";
            $this->db->select($sql);
            $this->db->from('solicitud sol');
            $this->db->join('estado_solicitud es', 'sol.id_estado_solicitud = es.id_estado_solicitud');
            $this->db->join('usuario_vant uv', 'sol.id_usuario_vant = uv.id_usuario');
            $this->db->join('persona pers', 'uv.id_persona = pers.id_persona');
            $this->db->join('usuario_admin adm', 'sol.id_usuario_aprobador = adm.id_usuario', 'left outer ');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_solicitud_por_estado($idEstadoSolicitud)
        {        
            $sql = 'sol.id_solicitud idSolicitud, id_usuario_vant idUsuarioVant, id_tipo_solicitud idTipoSolicitud, '. 
                   'id_usuario_aprobador idUsuarioAprobador, sol.id_estado_solicitud idEstadoSolicitud, '.
                   'es.descripcion descripcionEstadoSolicitud, latitud, longitud, radio_vuelo radioVuelo, '.
                   "to_char(fecha_vuelo, 'DD/MM/YYYY') fecha, hora_vuelo_desde horaVueloDesde, hora_vuelo_hasta horaVueloHasta";
            $this->db->select($sql);
            $this->db->from('solicitud sol');
            $this->db->join('estado_solicitud es', 'sol.id_estado_solicitud = es.id_estado_solicitud');
            $query = $this->db->get();
            $this->db->where('sol.id_estado_solicitud = ', $idEstadoSolicitud);
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_solicitud_por_usuario($idUsuario)
        {        
            $sql = 'sol.id_solicitud idSolicitud, id_usuario_vant idUsuarioVant, id_tipo_solicitud idTipoSolicitud, '. 
                   'id_usuario_aprobador idUsuarioAprobador, sol.id_estado_solicitud idEstadoSolicitud, '.
                   'es.descripcion descripcionEstadoSolicitud, latitud, longitud, radio_vuelo radioVuelo, '.
                   "to_char(fecha_vuelo, 'DD/MM/YYYY') fecha, hora_vuelo_desde horaVueloDesde, hora_vuelo_hasta horaVueloHasta";
            $this->db->select($sql);
            $this->db->from('solicitud sol');
            $this->db->join('estado_solicitud es', 'sol.id_estado_solicitud = es.id_estado_solicitud');
            $this->db->where('id_usuario_vant = ', $idUsuario);
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_solicitud_por_id($idSolicitud)
        {        
            $sql = 'sol.id_solicitud idSolicitud, id_usuario_vant idUsuarioVant, id_tipo_solicitud idTipoSolicitud, '. 
                   'id_usuario_aprobador idUsuarioAprobador, sol.id_estado_solicitud idEstadoSolicitud, '.
                   'es.descripcion descripcionEstadoSolicitud, latitud, longitud, radio_vuelo radioVuelo, '.
                   "to_char(fecha_vuelo, 'YYYY-MM-DD') fecha, hora_vuelo_desde horaVueloDesde, hora_vuelo_hasta horaVueloHasta";
            $this->db->select($sql);
            $this->db->from('solicitud sol');
            $this->db->join('estado_solicitud es', 'sol.id_estado_solicitud = es.id_estado_solicitud');
            $this->db->where('sol.id_solicitud = ', $idSolicitud);
            $query = $this->db->get()->row();
            return $query;
        }
        
        public function obtener_detalle_solicitud_por_id($idSolicitud)
        {        
            $sql = 'sol.id_solicitud idSolicitud, id_usuario_vant idUsuarioVant, pers.nombre nombre, pers.apellido apellido, pers.nro_documento documento, '. 
                   'pers.edad edad, pers.email email, id_tipo_solicitud idTipoSolicitud, '.
                   'id_usuario_aprobador idUsuarioAprobador, adm.usuario usuarioAprobador, sol.id_estado_solicitud idEstadoSolicitud, '.
                   'es.descripcion descripcionEstadoSolicitud, latitud, longitud, radio_vuelo radioVuelo, '.
                   "to_char(fecha_vuelo, 'YYYY-MM-DD') fecha, hora_vuelo_desde horaVueloDesde, hora_vuelo_hasta horaVueloHasta";
            $this->db->select($sql);
            $this->db->from('solicitud sol');
            $this->db->join('estado_solicitud es', 'sol.id_estado_solicitud = es.id_estado_solicitud');
            $this->db->join('usuario_vant uv', 'sol.id_usuario_vant = uv.id_usuario');
            $this->db->join('persona pers', 'uv.id_persona = pers.id_persona');
            $this->db->join('usuario_admin adm', 'sol.id_usuario_aprobador = adm.id_usuario');
            $this->db->where('sol.id_solicitud = ', $idSolicitud);
            $query = $this->db->get()->row();
            return $query;
        }
        
        public function obtener_vants_por_solicitud($idSolicitud)
        {        
            $sql = 'id_solicitud idSolicitud, id_vant idVant ';
            $this->db->select($sql);
            $this->db->from('vants_por_solicitud');
            $this->db->where('id_solicitud = ', $idSolicitud);
            $query = $this->db->get();
            return $query->result_array();
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
            $idSolicitud = $this->modificar_vant_solicitud($solicitud);
            
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                throw new Exception("Se producto un error al modificar el solicitud");
            }
            else
            {
                $this->db->trans_commit();
                return $idSolicitud;
            }
        }
        
        private function guardar_vant_solicitud($solicitud)
        {
            for ($i = 0; $i < count($solicitud['vants']); $i++) {
                $this->insertar_vant_solicitud($solicitud["idSolicitud"], $solicitud['vants'][$i]);
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
                'fecha_vuelo' => $solicitud['fecha'],
                'hora_vuelo_desde' => $solicitud['horaVueloDesde'],
                'hora_vuelo_hasta' => $solicitud['horaVueloHasta']
            ]);
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            return $this->db->insert_id();  
        }
        
        public function modificar_solicitud($solicitud)
        {
            $this->db->where('id_solicitud', $solicitud["idSolicitud"]);
            $result = $this->db->update('solicitud', [
                'id_usuario_vant' => $solicitud["idUsuarioVant"],
                'id_tipo_solicitud' => $solicitud['idTipoSolicitud'],     
                'id_estado_solicitud' => $solicitud['idEstadoSolicitud'],
                'latitud' => $solicitud['latitud'],
                'longitud' => $solicitud['longitud'],
                'radio_vuelo' => $solicitud['radioVuelo'],
                'fecha_vuelo' => $solicitud['fecha'],
                'hora_vuelo_desde' => $solicitud['horaVueloDesde'],
                'hora_vuelo_hasta' => $solicitud['horaVueloHasta']
            ]);
            
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            return $solicitud["idSolicitud"];  
        }
        
        public function modificar_vant_solicitud($solicitud)
        {
            $this->eliminar_vant_solicitud($solicitud);
            for ($i = 0; $i < count($solicitud['vants']); $i++) {
                $this->insertar_vant_solicitud($solicitud["idSolicitud"], $solicitud['vants'][$i]);
            }
            return;  
        }
        
        public function eliminar_solicitud($idSolicitud)
        {
            $this->db->where('id_solicitud', $idSolicitud);
            $result = $this->db->update('s', [
                'activo' => 0
            ]);
            
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            return;  
        }
        
        public function eliminar_vant_solicitud($solicitud)
        {
            $result = $this->db->delete('vants_por_solicitud', array('id_solicitud = ' => $solicitud["idSolicitud"]));
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            return;  
        }
        
        private function insertar_vant_solicitud($id_solicitud, $vant_solicitud){
            $result = $this->db->insert('vants_por_solicitud', [
                'id_solicitud' => $id_solicitud,
                'id_vant' => $vant_solicitud['idVant']
            ]);
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
        }
    }
?>
