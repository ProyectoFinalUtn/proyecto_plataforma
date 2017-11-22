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
        
        public function obtener_datos_normativa($id_normativa)
        {        
            $sql = 'id_normativa, descripcion, fecha_desde, fecha_hasta, contenido, contenido_html';
            $this->db->select($sql);
            $this->db->from('normativa');
            $this->db->where('id_normativa = ', $id_normativa);
            $query = $this->db->get()->row();
            return $query;
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
            $contenidoHTML = $this->crear_contenido($normativa['contenido_html']);
            if ($normativa['fecha_hasta'] == '') {
                $fechaHasta = null;
            } else {
                $fechaHasta = $normativa['fecha_hasta'];
            }
            $result = $this->db->insert('normativa', [
                'descripcion' => $normativa['descripcion'],     
                'fecha_desde' => $normativa['fecha_desde'],
                'fecha_hasta' => $fechaHasta,
                'contenido' => $normativa['contenido'],
                'contenido_html' => $contenidoHTML
            ]);
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            $id_normativa = $this->db->insert_id();
            
            return $id_normativa;
        }
        
        public function cambiar_datos_normativa($normativa)
        {
            $contenidoHTML = $this->crear_contenido($normativa['contenido_html']);
            if ($normativa['fecha_hasta'] == '') {
                $fechaHasta = null;
            } else {
                $fechaHasta = $normativa['fecha_hasta'];
            }
            $this->db->where('id_normativa', $normativa['id_normativa']);
            $result = $this->db->update('normativa', [
                'descripcion' => $normativa['descripcion'],     
                'fecha_desde' => $normativa['fecha_desde'],
                'fecha_hasta' => $fechaHasta,
                'contenido' => $normativa['contenido'],
                'contenido_html' => $contenidoHTML
            ]);

            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            
            return $normativa['id_normativa'];  
        }
        
        public function dar_baja_normativa($id_normativa)
        {
            date_default_timezone_set('UTC');
            $this->db->where('id_normativa', $id_normativa);
            $result = $this->db->update('normativa', [
            'fecha_hasta' => date("Y-m-d")
            ]);

            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            
            return $id_normativa;
        }
        
        public function obtener_normativas()
        {        
            $sql = 'id_normativa, descripcion, fecha_desde, fecha_hasta, contenido, contenido_html';
            $this->db->select($sql);
            $this->db->from('normativa');
            $this->db->where('fecha_hasta >= ', 'now()');
            $this->db->or_where('fecha_hasta', null);
            $query = $this->db->get();
            return $query->result_array();
        }
        
    }
?>
