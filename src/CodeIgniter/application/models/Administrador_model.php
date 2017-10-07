<?php
class Administrador_model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
                $this->load->database();                
        }

        public function get_password($nombre)
        {
                $this->db->select('password');
                $query = $this->db->get_where('usuario_admin', array('usuario =' => $nombre))->row();
                if (count($query) > 0) {
                   return $query->password;
                }else {
                    return NULL;
                }
                
        }
        
        public function obtener_datos_usuarios_admin()
        {   $this->db->select('id_usuario, usuario');    
            $this->db->from('usuario_admin');
            return $this->db->get()->result_array();
        }
        
        public function obtener_id_admin($usuarioAdmin)
        {   $this->db->select('id_usuario');
            $this->db->from('usuario_admin');
            $this->db->where('usuario = ', $usuarioAdmin);
            $this->db->limit(1);
            $query = $this->db->get()->row();
            return $query;
        }
        
        public function obtener_datos_admin($idUsuarioAdmin)
        {   
            $sql = 'adm.id_usuario, adm.id_persona, adm.usuario, pers.nombre, pers.apellido, '.
            'pers.nro_documento, pers.edad, pers.sexo, pers.calle, pers.numero, pers.piso, pers.dpto,'.
            'pers.provincia, pers.localidad, pers.telefono, pers.email';
            $this->db->select($sql);
            $this->db->from('usuario_admin adm');
            $this->db->join('persona pers', 'adm.id_persona = pers.id_persona', 'left outer ');
            $this->db->where('adm.id_usuario = ', $idUsuarioAdmin);
            $query = $this->db->get()->row();
            return $query;
        }
        
        private function insertar_persona_usuario_admin($usuarioAdmin)
        {
            $result = $this->db->insert('persona', [
                'nombre' => $usuarioAdmin['nombre'],     
                'apellido' => $usuarioAdmin['apellido'],
                'nro_documento' => $usuarioAdmin['documento'],
                'email' => $usuarioAdmin['email'],
            ]);
            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            }
            return $this->db->insert_id();  
        }
        
        private function asociar_persona_admin($id_persona, $id_usuario)
        {
            $this->db->where('id_usuario', $id_usuario);
            $result = $this->db->update('usuario_admin', [
            'id_persona' => $id_persona
            ]);

            if(!$result){
                $db_error = $this->db->error();
                throw new Exception($db_error);
            } 
        }
        
        public function cambiar_datos_admin($usuarioAdmin)
        {
            if ($usuarioAdmin['id_persona'] != null) {
                $this->db->where('id_persona', $usuarioAdmin['id_persona']);
                $result = $this->db->update('persona', [
                'nombre' => $usuarioAdmin['nombre'],
                'apellido' => $usuarioAdmin['apellido'],
                'nro_documento' => $usuarioAdmin['documento'],
                'email' => $usuarioAdmin['email']
                ]);

                if(!$result){
                    $db_error = $this->db->error();
                    throw new Exception($db_error);
                }
            }
            else {
                $id_persona = $this->insertar_persona_usuario_admin($usuarioAdmin);
                $this->asociar_persona_admin($id_persona, $usuarioAdmin['id_usuario']);
            }
            
            return $usuarioAdmin['id_usuario'];  
        }

/*********************************************************************************** 
       public function insert_entry()
        {
                $this->title    = $_POST['title']; // please read the below note
                $this->content  = $_POST['content'];
                $this->date     = time();

                $this->db->insert('entries', $this);
        }

        public function update_entry()
        {
                $this->title    = $_POST['title'];
                $this->content  = $_POST['content'];
                $this->date     = time();

                $this->db->update('entries', $this, array('id' => $_POST['id']));
        }
**********************************************************************************/
}
?>
