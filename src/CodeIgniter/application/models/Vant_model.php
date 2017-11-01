<?php
    class Vant_model extends CI_Model {

        public function __construct()
        {
            parent::__construct();
            $this->load->database();       
        }
              
        public function obtener_vant_por_usuario($idUsuario)
        {        
            $sql = 'id_vant idVant, id_usuario_vant idUsuarioVant, marca, modelo, nro_serie nroSerie, fabricante, '. 
                   'lugar_fabricacion lFab, anio_fabricacion anioFab, alto, ancho, largo, vel_max velMax, '.
                   'alt_max altMax, peso, color, lugar_guardado lGuardado';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->where('id_usuario_vant = ', $idUsuario);
            $this->db->where('activo = ', 1);
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_vant_por_id($idVant)
        {        
            $sql = 'id_vant idVant, id_usuario_vant idUsuarioVant, marca, modelo, nro_serie nroSerie, fabricante, '. 
                   'lugar_fabricacion lFab, anio_fabricacion anioFab, alto, ancho, largo, vel_max velMax, '.
                   'alt_max altMax, peso, color, lugar_guardado lGuardado';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->where('id_vant = ', $idVant);
            $this->db->where('activo = ', 1);
            $query = $this->db->get()->row();
            return $query;
        }
        
        public function obtener_datos_vant()
        {        
            $sql = 'id_vant idVant, id_usuario_vant idUsuarioVant, marca, modelo, nro_serie nroSerie, fabricante, '. 
                   'lugar_fabricacion lFab, anio_fabricacion anioFab, alto, ancho, largo, vel_max velMax, '.
                   'alt_max altMax, peso, color, lugar_guardado lGuardado';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->where('activo = ', 1);
            $this->db->order_by('vant.id_vant', 'desc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_peso($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "perf.fecha_registro >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "perf.fecha_registro <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and pers.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and pers.localidad = " . $localidad;
            }
            $filtro = $filtro . " and activo = 1";
            
            $sql = 'vant.peso, count(*) cantidadvant ';
            $by = 'vant.peso';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->join('usuario_vant', 'vant.id_usuario_vant = usuario_vant.id_usuario');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->where($filtro);
            $this->db->group_by($by);
            $this->db->order_by('vant.peso', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_marca($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "perf.fecha_registro >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "perf.fecha_registro <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and pers.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and pers.localidad = " . $localidad;
            }
            $filtro = $filtro . " and activo = 1";
            
            $sql = 'vant.marca, count(*) cantidadvant ';
            $by = 'vant.marca';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->join('usuario_vant', 'vant.id_usuario_vant = usuario_vant.id_usuario');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->where($filtro);
            $this->db->group_by($by);
            $this->db->order_by('vant.marca', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_modelo($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "perf.fecha_registro >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "perf.fecha_registro <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and pers.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and pers.localidad = " . $localidad;
            }
            $filtro = $filtro . " and activo = 1";
            
            $sql = 'vant.modelo, count(*) cantidadvant ';
            $by = 'vant.modelo';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->join('usuario_vant', 'vant.id_usuario_vant = usuario_vant.id_usuario');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->where($filtro);
            $this->db->group_by($by);
            $this->db->order_by('vant.modelo', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_fabric($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "perf.fecha_registro >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "perf.fecha_registro <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and pers.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and pers.localidad = " . $localidad;
            }
            $filtro = $filtro . " and activo = 1";
            
            $sql = 'vant.fabricante, count(*) cantidadvant ';
            $by = 'vant.fabricante';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->join('usuario_vant', 'vant.id_usuario_vant = usuario_vant.id_usuario');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->where($filtro);
            $this->db->group_by($by);
            $this->db->order_by('vant.fabricante', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_origen($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "perf.fecha_registro >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "perf.fecha_registro <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and pers.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and pers.localidad = " . $localidad;
            }
            $filtro = $filtro . " and activo = 1";
            
            $sql = 'vant.lugar_fabricacion, count(*) cantidadvant ';
            $by = 'vant.lugar_fabricacion';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->join('usuario_vant', 'vant.id_usuario_vant = usuario_vant.id_usuario');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->where($filtro);
            $this->db->group_by($by);
            $this->db->order_by('vant.lugar_fabricacion', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_anio($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "perf.fecha_registro >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "perf.fecha_registro <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and pers.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and pers.localidad = " . $localidad;
            }
            $filtro = $filtro . " and activo = 1";
            
            $sql = 'vant.anio_fabricacion, count(*) cantidadvant ';
            $by = 'vant.anio_fabricacion';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->join('usuario_vant', 'vant.id_usuario_vant = usuario_vant.id_usuario');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->where($filtro);
            $this->db->group_by($by);
            $this->db->order_by('vant.anio_fabricacion', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_altmax($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "perf.fecha_registro >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "perf.fecha_registro <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and pers.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and pers.localidad = " . $localidad;
            }
            $filtro = $filtro . " and activo = 1";
            
            $sql = 'vant.alt_max, count(*) cantidadvant ';
            $by = 'vant.alt_max';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->join('usuario_vant', 'vant.id_usuario_vant = usuario_vant.id_usuario');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->where($filtro);
            $this->db->group_by($by);
            $this->db->order_by('vant.alt_max', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_velmax($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "perf.fecha_registro >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "perf.fecha_registro <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and pers.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and pers.localidad = " . $localidad;
            }
            $filtro = $filtro . " and activo = 1";
            
            $sql = 'vant.vel_max, count(*) cantidadvant ';
            $by = 'vant.vel_max';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->join('usuario_vant', 'vant.id_usuario_vant = usuario_vant.id_usuario');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->where($filtro);
            $this->db->group_by($by);
            $this->db->order_by('vant.vel_max', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_alto($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "perf.fecha_registro >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "perf.fecha_registro <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and pers.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and pers.localidad = " . $localidad;
            }
            $filtro = $filtro . " and activo = 1";
            
            $sql = 'vant.alto, count(*) cantidadvant ';
            $by = 'vant.alto';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->join('usuario_vant', 'vant.id_usuario_vant = usuario_vant.id_usuario');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->where($filtro);
            $this->db->group_by($by);
            $this->db->order_by('vant.alto', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_ancho($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "perf.fecha_registro >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "perf.fecha_registro <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and pers.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and pers.localidad = " . $localidad;
            }
            $filtro = $filtro . " and activo = 1";
            
            $sql = 'vant.ancho, count(*) cantidadvant ';
            $by = 'vant.ancho';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->join('usuario_vant', 'vant.id_usuario_vant = usuario_vant.id_usuario');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->where($filtro);
            $this->db->group_by($by);
            $this->db->order_by('vant.ancho', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_largo($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "perf.fecha_registro >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "perf.fecha_registro <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and pers.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and pers.localidad = " . $localidad;
            }
            $filtro = $filtro . " and activo = 1";
            
            $sql = 'vant.largo, count(*) cantidadvant ';
            $by = 'vant.largo';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->join('usuario_vant', 'vant.id_usuario_vant = usuario_vant.id_usuario');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->where($filtro);
            $this->db->group_by($by);
            $this->db->order_by('vant.largo', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_color($fecha_desde, $fecha_hasta, $provincia, $localidad)
        {
            if ($fecha_desde == '') {
                $filtro_fecha_desde = '1=1';
            } else {
                $filtro_fecha_desde = "perf.fecha_registro >= '".$fecha_desde."'";
            }
            if ($fecha_hasta == '') {
                $filtro_fecha_hasta = '1=1';
            } else {
                $filtro_fecha_hasta = "perf.fecha_registro <= '".$fecha_hasta."'";
            }
            
            $filtro = $filtro_fecha_desde . " and " . $filtro_fecha_hasta;
            
            if ($provincia != '0') {
                $filtro = $filtro . " and pers.provincia = " . $provincia;
            }
            
            if ($localidad != '0') {
                $filtro = $filtro . " and pers.localidad = " . $localidad;
            }
            $filtro = $filtro . " and activo = 1";
            
            $sql = 'vant.color, count(*) cantidadvant ';
            $by = 'vant.color';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->join('usuario_vant', 'vant.id_usuario_vant = usuario_vant.id_usuario');
            $this->db->join('persona pers', 'usuario_vant.id_persona = pers.id_persona');
            $this->db->join('perfil perf', 'usuario_vant.id_perfil = perf.id_perfil');
            $this->db->where($filtro);
            $this->db->group_by($by);
            $this->db->order_by('vant.color', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function crear_vant($vant)
        {        
            $this->db->trans_begin();  
            $id_vant = $this->guardar_vant($vant);
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                throw new Exception("Se producto un error al guardar la vant");
            }
            else
            {
                $this->db->trans_commit();
                return $id_vant;
            }
        }
        
        public function cambiar_vant($vant)
        {
            $this->db->trans_begin();  
            $idVant = $this->modificar_vant($vant);
            
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                throw new Exception("Se producto un error al modificar el vant");
            }
            else
            {
                $this->db->trans_commit();
                return $idVant;
            }
        }
        
        private function guardar_vant($vant)
        {
            $result = $this->db->insert('vant', [
                'id_usuario_vant' => $vant["idUsuarioVant"],  
                'marca' => $vant['marca'],
                'modelo' => $vant['modelo'],
                'nro_serie' => $vant['nroSerie'],
                'fabricante' => $vant['fabricante'],
                'lugar_fabricacion' => $vant['lFab'],
                'anio_fabricacion' => $vant['anioFab'],
                'alto' => $vant['alto'],
                'ancho' => $vant['ancho'],
                'largo' => $vant['largo'],
                'vel_max' => $vant['velMax'],
                'alt_max' => $vant['altMax'],
                'peso' => $vant['peso'],
                'color' => $vant['color'],
                'lugar_guardado' => $vant['lGuardado'],
                'activo' => 1
            ]);
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            return $this->db->insert_id();  
        }
        
        public function modificar_vant($vant)
        {
            $this->db->where('id_vant', $vant["idVant"]);
            $result = $this->db->update('vant', [
                'id_usuario_vant' => $vant["idUsuarioVant"],  
                'marca' => $vant['marca'],
                'modelo' => $vant['modelo'],
                'nro_serie' => $vant['nroSerie'],
                'fabricante' => $vant['fabricante'],
                'lugar_fabricacion' => $vant['lFab'],
                'anio_fabricacion' => $vant['anioFab'],
                'alto' => $vant['alto'],
                'ancho' => $vant['ancho'],
                'largo' => $vant['largo'],
                'vel_max' => $vant['velMax'],
                'alt_max' => $vant['altMax'],
                'peso' => $vant['peso'],
                'color' => $vant['color'],
                'lugar_guardado' => $vant['lGuardado'],
                'activo' => 1
            ]);
            
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            return $vant["idVant"];  
        }
        
        public function eliminar_vant($idVant)
        {
            $this->db->where('id_vant', $idVant);
            $result = $this->db->update('vant', [
                'activo' => 0
            ]);
            
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            return;  
        }
    }
?>
