<?php
class Zonas_influencia_model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
                $this->load->database();                
        }

        public function guardar_zona($zonas)
        {   
            $nombre_capa = $zonas["nombre_zona"];
            $radio = $zonas["radio_zona"];
            $detalle = $zonas["detalle_zona"];
            $features = json_decode( $zonas["archivo"], true );
            foreach ($features["features"] as $ft) {
                $geom = json_encode($ft["geometry"]);
                $id = $ft["properties"]["id"];
                $props = json_encode($ft["properties"]);
                $dataInsert = array('id' => $id,
                                'nombre_capa'  => $nombre_capa,    
                                'geometria' => $geom,
                                'propiedades' => $props,
                                'radio' => $radio,
                                'detalle' => $detalle);                
                $str = "ID :".$id.";NOMBRE CAPA :".$nombre_capa.", RADIO :".$radio.",DETALLE :".$detalle.",GEOM : ".$geom."PROP:".$props; 
                file_put_contents('C:\Users\winwin\Desktop\vardump.txt', $str);
                $this->db->insert('zona_influencia', $dataInsert);                                        
            }
        }

        public function eliminar_zona($data)
        {
          //$id = strval($data["id"]);
          //$this->db->delete('zona_temporal', array('id' => $id));
        }
}
?>
