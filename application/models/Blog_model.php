<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Admin_model
 *
 * @author besong
 */
class Blog_model extends CI_Model 
{
    public function __construct()
    {
	    parent::__construct();
	    // Your own constructor code
    }
    
    public function get_recent_stat_posts()
    {
        return null;
    }
}
