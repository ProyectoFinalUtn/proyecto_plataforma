<?php
    class vant_model extends CI_Model {

        public function __construct()
        {
            parent::__construct();
            $this->load->database();       
        }
              
        public function obtener_vant_por_usuario($idUsuario)
        {        
            $sql = 'id_vant idVant, id_usuario_vant idUsuarioVant, marca, modelo, nro_serie, fabricante, '. 
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
            $sql = 'id_vant idVant, id_usuario_vant idUsuarioVant, marca, modelo, nro_serie, fabricante, '. 
                   'lugar_fabricacion lFab, anio_fabricacion anioFab, alto, ancho, largo, vel_max velMax, '.
                   'alt_max altMax, peso, color, lugar_guardado lGuardado';
            $this->db->select($sql);
            $this->db->from('vant');
            $this->db->where('id_vant = ', $idVant);
            $this->db->where('activo = ', 1);
            $query = $this->db->get()->row();
            return $query;
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
            $this->modificar_vant($vant);
            
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                throw new Exception("Se producto un error al modificar el vant");
            }
            else
            {
                $this->db->trans_commit();
                return;
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
            return;  
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
