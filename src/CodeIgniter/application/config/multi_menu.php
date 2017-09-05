<?php defined('BASEPATH') OR exit('No direct script access allowed');

// $config["menu_id"]               = 'id';
// $config["menu_label"]            = 'name';
// $config["menu_parent"]           = 'parent';
// $config["menu_icon"] 			 = 'icon';
$config["menu_key"]              = 'slug';
$config["menu_order"]            = 'number';

$config["nav_tag_open"]          = '<ul>';
$config["nav_tag_close"]         = '</ul>';
$config["item_tag_open"]         = '<li>'; 
$config["item_tag_close"]        = '</li>';	
$config["parent_tag_open"]       = '<li>';	
$config["parent_tag_close"]      = '</li>';	
$config["parent_anchor_tag"]     = '<a lass="test2" href="%s">%s</a>';	
$config["children_tag_open"]     = '<ul>';	
$config["children_tag_close"]    = '</ul>';	
$config['icon_position']		 = 'left'; // 'left' or 'right'
$config['menu_icons_list']		 = array();
// these for the future version
$config['icon_img_base_url']	 = ''; 
//Bootstrap congig
/* DROPDOWN
$config["nav_tag_open"]          = '<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">';     
$config["parent_tag_open"]       = '<li class="dropdown-submenu">';
$config["parent_anchor_tag"]     = '<a tabindex="-1" href="%s">%s</a>'; 
$config["children_tag_open"]     = '<ul class="dropdown-menu">';
$config["item_divider"]          = "<li class='divider'></li>";
*/
//NAVVAR

$config["nav_tag_open"]          = '<ul class="nav navbar-nav">';
$config["parentl1_tag_open"]          = '<li class="dropdown">';
$config["parentl1_anchor"]          = '<a tabindex="0" data-toggle="dropdown" href="%s">%s<span class="caret"></span></a>';
$config["parent_tag_open"]          = '<li class="dropdown-submenu">';
$config["parent_anchor"]          = '<a class="test" href="%s" data-toggle="dropdown">%s</a>';
$config["children_tag_open"]          = '<ul class="dropdown-menu">';



