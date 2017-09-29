<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends MY_Controller
{

	 public function __construct()
    {
        parent::__construct();
        $this->load->library('Multi_menu');     
    }

	public function index()
	{
		 $this->load->model("Menu_model", "menu");		 
 		 $items = $this->menu->all(); 		 
 		 $this->multi_menu->set_items($items);
 		 $this->load->view('Header'); 		 
 		 $menu = array('menu' => $this->multi_menu->render());
 		 $this->load->view('Panel',$menu); 		 
 		 $this->load->view('Footer'); 		 
	}
}
