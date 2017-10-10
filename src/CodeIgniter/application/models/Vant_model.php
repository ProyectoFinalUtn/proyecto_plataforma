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
        
        public function obtener_cantidad_por_peso()
        {        
            $sql = 'vant.peso, count(*) cantidadvant ';
            $by = 'vant.peso';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->where('activo = ', 1);
            $this->db->group_by($by);
            $this->db->order_by('vant.peso', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_marca()
        {        
            $sql = 'vant.marca, count(*) cantidadvant ';
            $by = 'vant.marca';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->where('activo = ', 1);
            $this->db->group_by($by);
            $this->db->order_by('vant.marca', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_modelo()
        {        
            $sql = 'vant.modelo, count(*) cantidadvant ';
            $by = 'vant.modelo';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->where('activo = ', 1);
            $this->db->group_by($by);
            $this->db->order_by('vant.modelo', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_fabric()
        {        
            $sql = 'vant.fabricante, count(*) cantidadvant ';
            $by = 'vant.fabricante';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->where('activo = ', 1);
            $this->db->group_by($by);
            $this->db->order_by('vant.fabricante', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_origen()
        {        
            $sql = 'vant.lugar_fabricacion, count(*) cantidadvant ';
            $by = 'vant.lugar_fabricacion';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->where('activo = ', 1);
            $this->db->group_by($by);
            $this->db->order_by('vant.lugar_fabricacion', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_anio()
        {        
            $sql = 'vant.anio_fabricacion, count(*) cantidadvant ';
            $by = 'vant.anio_fabricacion';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->where('activo = ', 1);
            $this->db->group_by($by);
            $this->db->order_by('vant.anio_fabricacion', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_altmax()
        {        
            $sql = 'vant.alt_max, count(*) cantidadvant ';
            $by = 'vant.alt_max';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->where('activo = ', 1);
            $this->db->group_by($by);
            $this->db->order_by('vant.alt_max', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_velmax()
        {        
            $sql = 'vant.vel_max, count(*) cantidadvant ';
            $by = 'vant.vel_max';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->where('activo = ', 1);
            $this->db->group_by($by);
            $this->db->order_by('vant.vel_max', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_alto()
        {        
            $sql = 'vant.alto, count(*) cantidadvant ';
            $by = 'vant.alto';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->where('activo = ', 1);
            $this->db->group_by($by);
            $this->db->order_by('vant.alto', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_ancho()
        {        
            $sql = 'vant.ancho, count(*) cantidadvant ';
            $by = 'vant.ancho';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->where('activo = ', 1);
            $this->db->group_by($by);
            $this->db->order_by('vant.ancho', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_largo()
        {        
            $sql = 'vant.largo, count(*) cantidadvant ';
            $by = 'vant.largo';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->where('activo = ', 1);
            $this->db->group_by($by);
            $this->db->order_by('vant.largo', 'asc');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function obtener_cantidad_por_color()
        {        
            $sql = 'vant.color, count(*) cantidadvant ';
            $by = 'vant.color';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->where('activo = ', 1);
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
