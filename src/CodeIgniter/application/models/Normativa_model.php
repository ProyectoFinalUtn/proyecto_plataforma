<?php
    class Normativa_model extends CI_Model {

        public function __construct()
        {
            parent::__construct();
            $this->load->database();       
        }
              
        public function obtener_datos_normativas()
        {        
            $sql = 'id_normativa, descripcion, fecha_desde, fecha_hasta';
            $this->db->select($sql);
            $this->db->from('normativa');
            $this->db->order_by('id_normativa');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        public function crear_contenido($contenido)
        {
            $header = '<html><head><meta charset="utf-8">'
                    .'<meta name="viewport" content="width=device-width, initial-scale=1">'
                    .'<link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet" type="text/css">'
                    .'</head><body>';
            $footer = '</body></html>';
            return $header.$contenido.$footer;
        }
        
        public function guardar_normativa($normativa)
        {
            $contenidoHTML = $this->crear_contenido($normativa['contenido']);
            if ($normativa['fecha_hasta'] == '') {
                $fechaHasta = null;
            } else {
                $fechaHasta = $normativa['fecha_hasta'];
            }
            $result = $this->db->insert('normativa', [
                'descripcion' => $normativa['descripcion'],     
                'fecha_desde' => $normativa['fecha_desde'],
                'fecha_hasta' => $fechaHasta,
                'contenido' => $contenidoHTML
            ]);
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            $id_normativa = $this->db->insert_id();
            
            return $id_normativa;
        }
        
    }
?>
