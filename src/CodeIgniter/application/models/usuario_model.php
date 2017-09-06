<?php
class UsuarioModel extends CI_Model {

    public function __construct()
    {
            parent::__construct();
            $this->load->database();                
    }

    public function get_password($nombre)
    {
            $this->db->select('password');
            $query = $this->db->get_where('administrador', array('nombre =' => $nombre))->row();
            if (count($query) > 0) {
               return $query->password;
            }else {
                return NULL;
            }
    }
    
    public function guardar_perfil($perfil)
    {
            $this->rest->db
            ->insert(
                $this->config->item('usuario_vant'), [
                'idRol' => 1,
                'idPersona' => $this->_args ? ($this->config->item('rest_logs_json_params') === TRUE ? json_encode($this->_args) : serialize($this->_args)) : NULL,
                'idPerfil' => isset($this->rest->key) ? $this->rest->key : '',
                'usuario' => $this->input->ip_address(),
                'pass' => time(),
                'authorized' => $authorized
            ]);
    }
}



?>