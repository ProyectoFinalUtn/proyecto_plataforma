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
            $this->db->order_by('sol.id_solicitud', 'desc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function vencer_solicitudes()
        {
            $estadoPendiente = 1;
            $estadoVencida = 4;
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $fechaLimite = date('Y-m-d', time());
            $filtro = "id_estado_solicitud = ".$estadoPendiente." and fecha_vuelo <= '".$fechaLimite."'";
            $this->db->where($filtro);
            $result = $this->db->update('solicitud', [
                'id_estado_solicitud' => $estadoVencida
            ]);
            
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            return $result;
        }
        
        public function obtener_solicitudes_actualizadas()
        {
            $this->vencer_solicitudes();
            $estadoVencida = 4;
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $fechaLimite = date('Y-m-d', time());
            $filtro = "sol.id_estado_solicitud <> ".$estadoVencida." and sol.fecha_vuelo >= '".$fechaLimite."'";
            
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
            $this->db->where($filtro);
            $this->db->order_by('sol.id_solicitud', 'desc');
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
            $this->db->order_by('sol.id_solicitud', 'desc');
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
            $sql = 'sol.id_solicitud idSolicitud, sol.id_usuario_vant idUsuarioVant, pers.nombre nombre, pers.apellido apellido, pers.nro_documento documento, '. 
                   'pers.edad edad, pers.email email, id_tipo_solicitud idTipoSolicitud, '.
                   'id_usuario_aprobador idUsuarioAprobador, adm.usuario usuarioAprobador, sol.id_estado_solicitud idEstadoSolicitud, '.
                   'es.descripcion descripcionEstadoSolicitud, latitud, longitud, radio_vuelo radioVuelo, '.
                   'vant.marca, vant.modelo, vant.peso, '.
                   "to_char(fecha_vuelo, 'YYYY-MM-DD') fecha, hora_vuelo_desde horaVueloDesde, hora_vuelo_hasta horaVueloHasta";
            $this->db->select($sql);
            $this->db->from('solicitud sol');
            $this->db->join('estado_solicitud es', 'sol.id_estado_solicitud = es.id_estado_solicitud');
            $this->db->join('usuario_vant uv', 'sol.id_usuario_vant = uv.id_usuario');
            $this->db->join('persona pers', 'uv.id_persona = pers.id_persona');
            $this->db->join('usuario_admin adm', 'sol.id_usuario_aprobador = adm.id_usuario', 'left outer ');
            $this->db->join('vants_por_solicitud vxs', 'vxs.id_solicitud = sol.id_solicitud', 'left outer ');
            $this->db->join('vant', 'vant.id_vant = vxs.id_vant', 'left outer ');
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
            try {
                $this->load->model('Llamadasrest_model');
                $direccion = $this->Llamadasrest_model->obtener_direccion_lon_lat($solicitud['latitud'], $solicitud['longitud'], 'g.o.guide.project@gmail.com');
                $this->load->model('Provincia_model');
                $provincia = $this->Provincia_model->obtener_id_provincia_y_loc($direccion);
                $solicitud['provincia'] = $provincia['provincia'];
                $solicitud['localidad'] = $provincia['localidad'];
                $solicitud['zona_interes'] = $provincia['zona_interes'];
            }
            catch(Exception $exception){
                $solicitud['provincia'] = null;
                $solicitud['localidad'] = null;
                $solicitud['zona_interes'] = null;
            }
            
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
            $this->valida_modificacion_solicitud($solicitud["idSolicitud"]);
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
                'hora_vuelo_hasta' => $solicitud['horaVueloHasta'],
                'provincia' => $solicitud['provincia'],
                'localidad' => $solicitud['localidad'],
                'zona_interes' => $solicitud['zona_interes']
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
            $this->eliminar_vant_solicitud($solicitud["idSolicitud"]);
            for ($i = 0; $i < count($solicitud['vants']); $i++) {
                $this->insertar_vant_solicitud($solicitud["idSolicitud"], $solicitud['vants'][$i]);
            }
            return;  
        }
        
        public function eliminar_solicitud($idSolicitud)
        {
            $this->db->trans_begin();
            $this->valida_modificacion_solicitud($idSolicitud);
            /*$this->db->where('id_solicitud', $idSolicitud);
            $result = $this->db->update('s', [
                'activo' => 0
            ]);*/
            $this->eliminar_vant_solicitud($idSolicitud);
            $result =  $this->db->delete('solicitud', array('id_solicitud' => $idSolicitud)); 
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                throw new Exception("Se producto un error al eliminar el solicitud");
            }
            else
            {
                $this->db->trans_commit();
            }
        }
        
        public function eliminar_vant_solicitud($idSolicitud)
        {
            $result = $this->db->delete('vants_por_solicitud', array('id_solicitud = ' => $idSolicitud));
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
        
        private function valida_modificacion_solicitud($idSolicitud){
            $solAnterior = $this->obtener_solicitud_por_id($idSolicitud);
            if($solAnterior->idEstadoSolicitud != 1){
                throw new Exception("La solicitud fue procesada por el administrador no se puede modificar.");
            }
        }
        
        public function cambiar_estado_solicitud($idSolicitud,$estadoNuevo,$idUsuarioAprobador)
        {
            $this->db->where('id_solicitud', $idSolicitud);
            $result = $this->db->update('solicitud', [
                'id_estado_solicitud' => $estadoNuevo,
                'id_usuario_aprobador' => $idUsuarioAprobador
            ]);
            
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            return $idSolicitud;  
        }
        
        public function obtener_cantidad_por_fecha($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "fecha_vuelo >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "fecha_vuelo <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and localidad = " . $localidad;
            }
            
            $sql = 'fecha_vuelo, count(id_solicitud) cantidad';
            $this->db->select($sql);
            $this->db->from('solicitud');
            $this->db->where($filtro);
            $this->db->group_by('fecha_vuelo');
            $this->db->order_by('fecha_vuelo', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_horario($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "solicitud.fecha_vuelo >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "solicitud.fecha_vuelo <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and solicitud.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and solicitud.localidad = " . $localidad;
            }
            
            $sql = 'horario.rango, count(id_solicitud) cantidad';
            $innerjoin = "(solicitud.hora_vuelo_desde >= horario.rango_desde and solicitud.hora_vuelo_desde < horario.rango_hasta) "
                ."or (solicitud.hora_vuelo_hasta > horario.rango_desde and solicitud.hora_vuelo_hasta <= horario.rango_hasta) "
                ."or (solicitud.hora_vuelo_desde < horario.rango_desde and solicitud.hora_vuelo_hasta >= horario.rango_hasta)";
            
            $this->db->select($sql);
            $this->db->from('horario');
            $this->db->join('solicitud', $innerjoin);
            $this->db->where($filtro);
            $this->db->group_by('horario.rango');
            $this->db->order_by('horario.rango', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_marca($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "sol.fecha_vuelo >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "sol.fecha_vuelo <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and sol.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and sol.localidad = " . $localidad;
            }
            
            $sql = 'vant.marca, count(*) cantidad';
            $this->db->select($sql);
            $this->db->from('solicitud sol');
            $this->db->join('vants_por_solicitud vxs', 'vxs.id_solicitud = sol.id_solicitud');
            $this->db->join('vant', 'vant.id_vant = vxs.id_vant');
            $this->db->where($filtro);
            $this->db->group_by('vant.marca');
            $this->db->order_by('vant.marca', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_modelo($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "sol.fecha_vuelo >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "sol.fecha_vuelo <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and sol.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and sol.localidad = " . $localidad;
            }
            
            $sql = "(vant.marca || ' ' || vant.modelo) as modelo, count(*) cantidad";
            $this->db->select($sql);
            $this->db->from('solicitud sol');
            $this->db->join('vants_por_solicitud vxs', 'vxs.id_solicitud = sol.id_solicitud');
            $this->db->join('vant', 'vant.id_vant = vxs.id_vant');
            $this->db->where($filtro);
            $this->db->group_by('vant.marca, vant.modelo');
            $this->db->order_by('vant.marca', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_estado($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "sol.fecha_vuelo >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "sol.fecha_vuelo <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and sol.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and sol.localidad = " . $localidad;
            }
            
            $sql = 'es.id_estado_solicitud, es.descripcion, count(*) cantidad';
            $this->db->select($sql);
            $this->db->from('solicitud sol');
            $this->db->join('estado_solicitud es', 'es.id_estado_solicitud = sol.id_estado_solicitud');
            $this->db->where($filtro);
            $this->db->group_by('es.id_estado_solicitud, es.descripcion');
            $this->db->order_by('es.id_estado_solicitud', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_momento($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "solicitud.fecha_vuelo >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "solicitud.fecha_vuelo <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and solicitud.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and solicitud.localidad = " . $localidad;
            }
            
            $sql = 'momento.descripcion, count(id_solicitud) cantidad';
            $innerjoin = "(solicitud.hora_vuelo_desde >= horario.rango_desde and solicitud.hora_vuelo_desde < horario.rango_hasta) "
                ."or (solicitud.hora_vuelo_hasta > horario.rango_desde and solicitud.hora_vuelo_hasta <= horario.rango_hasta) "
                ."or (solicitud.hora_vuelo_desde < horario.rango_desde and solicitud.hora_vuelo_hasta >= horario.rango_hasta)";
            
            $this->db->select($sql);
            $this->db->from('horario');
            $this->db->join('solicitud', $innerjoin);
            $this->db->join('momento', 'momento.id_momento = horario.id_momento');
            $this->db->where($filtro);
            $this->db->group_by('momento.descripcion');
            $this->db->order_by('momento.descripcion', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_mes($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "fecha_vuelo >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "fecha_vuelo <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and localidad = " . $localidad;
            }
            
            $sql = 'extract(MONTH FROM fecha_vuelo) mes, count(*) cantidad';
            $this->db->select($sql);
            $this->db->from('solicitud');
            $this->db->where($filtro);
            $this->db->group_by('extract(MONTH FROM fecha_vuelo)');
            $this->db->order_by('1', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_dia($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "fecha_vuelo >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "fecha_vuelo <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and localidad = " . $localidad;
            }
            
            $sql = 'extract(DOW FROM fecha_vuelo) dia, count(*) cantidad';
            $this->db->select($sql);
            $this->db->from('solicitud');
            $this->db->where($filtro);
            $this->db->group_by('extract(DOW FROM fecha_vuelo)');
            $this->db->order_by('1', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_provincia($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "solicitud.fecha_vuelo >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "solicitud.fecha_vuelo <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and solicitud.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and solicitud.localidad = " . $localidad;
            }
            
            $sql = 'provincia.provincia, count(*) cantidad';
            $this->db->select($sql);
            $this->db->from('solicitud');
            $this->db->join('provincia', 'provincia.id_provincia = solicitud.provincia');
            $this->db->where($filtro);
            $this->db->group_by('provincia.provincia');
            $this->db->order_by('1', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_localidad($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "solicitud.fecha_vuelo >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "solicitud.fecha_vuelo <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and solicitud.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and solicitud.localidad = " . $localidad;
            }
            
            $sql = 'localidad.localidad, count(*) cantidad';
            $this->db->select($sql);
            $this->db->from('solicitud');
            $this->db->join('localidad', 'localidad.id_localidad = solicitud.localidad');
            $this->db->where($filtro);
            $this->db->group_by('localidad.localidad');
            $this->db->order_by('1', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_zona_interes($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "fecha_vuelo >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "fecha_vuelo <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and localidad = " . $localidad;
            }
            
            $sql = 'zona_interes, count(*) cantidad';
            $this->db->select($sql);
            $this->db->from('solicitud');
            $this->db->where('zona_interes is not null and '.$filtro);
            $this->db->group_by('zona_interes');
            $this->db->order_by('1', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
    }
?>
