<?php
class Zonas_temporales_model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
                $this->load->database();                
        }

        public function guardar_zona($zona)
        {   
            $query = $this->db->query("SELECT id FROM zona_temporal WHERE id = ".$zona["id"]." limit 1");

            $dataInsert = array('id' => $zona["id"],
                          'nombre'  => $zona["nombre"],    
                          'detalle' => $zona["detalle"],
                          'geometria' => $zona["geometria"],
                          'propiedades' => $zona["propiedades"],
                          'fecha_inicio' => $zona["fecha_inicio"],
                          'fecha_fin' => $zona["fecha_fin"]);

            $dataUpdate = array('nombre'  => $zona["nombre"],    
                          'detalle' => $zona["detalle"],
                          'geometria' => $zona["geometria"],
                          'propiedades' => $zona["propiedades"],
                          'fecha_inicio' => $zona["fecha_inicio"],
                          'fecha_fin' => $zona["fecha_fin"]);

            if ($query->num_rows() == 0){
                return $this->db->insert('zona_temporal', $dataInsert);
            }else { 
                $this->db->where('id', $zona["id"]);
                return $this->db->update('zona_temporal', $dataUpdate);
            };                        
        }

        public function get_zona_within_radius($punto)
        {
            /*$columnas = 'id, nombre';
            $this->db->select($columnas);
            $this->db->from('zona_temporal');
            $where = '( ST_DWithin( 
                       ( ST_SetSRID(( ST_GeomFromGeoJSON (geometria::Text)),3857)),                  
                       ( ST_SetSRID(ST_MakePoint('.strval($punto["long"]).','.strval($punto["lat"]).'),3857)),'.strval($punto["rad"]).')) AND '."'".strval($punto["fecha_inicio"])."'".' BETWEEN fecha_inicio AND fecha_fin';
            $this->db->where($where);
            $query = $this->db->get()->row();
            return $query;  */
            $columnas = 'id, nombre, ST_AsGeoJSON(ST_Transform(ST_SetSRID((ST_GeomFromGeoJSON (geometria::Text)),3857), 4326)) geometria, propiedades';
            $this->db->select($columnas);
            $this->db->from('zona_temporal');
            $where = "( ST_DWithin( 
                        ( ST_SetSRID(( ST_GeomFromGeoJSON (geometria::Text)),3857)),                  
                        ( ST_SetSRID(ST_Transform(ST_GeomFromText('POINT(".strval($punto["long"])." ".strval($punto["lat"]).")', 4326), 3857),3857)), "
                        .strval($punto["rad"]).")) AND '".strval($punto["fecha_inicio"])."' BETWEEN fecha_inicio AND fecha_fin";
            $this->db->where($where);
            $query = $this->db->get();
            return $query->result_array();
        }

        public function buscar_zonas($data)
        {          
          $columnas = 'geometria, propiedades';
          $this->db->select($columnas);
          $this->db->from('zona_temporal');

          switch (strval($data["filtro"])) {
                case "ACTIVAS":
                    $where = '('."'".strval($data["fecha_inicio"])."'".' BETWEEN fecha_inicio AND fecha_fin)';
                    $this->db->where($where);           
                    break;
                case "FUTURAS":
                    $where = '('."'".strval($data["fecha_inicio"])."'".'< fecha_inicio)';
                    $this->db->where($where);           
                    break;
                case "TODAS":
                    break;
          }                    
          
          $query = $this->db->get();
          return $query->result_array();
        }

        public function eliminar_zona($data)
        {
          $id = strval($data["id"]);
          $this->db->delete('zona_temporal', array('id' => $id));
        }
}
?>
