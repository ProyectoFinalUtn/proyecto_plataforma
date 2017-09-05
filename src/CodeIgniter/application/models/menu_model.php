<?php
class Menu_model extends CI_Model {

	public function __construct()
    {
            parent::__construct();
            $this->load->database();                
    }

	public function all()
	{
		return $this->db->get("menus")
					->result_array();
	}

}