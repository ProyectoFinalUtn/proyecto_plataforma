<?php
class AdministradorModelo extends CI_Model {

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