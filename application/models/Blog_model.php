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
    
	/**
	* Get all recent posts of type statistics
	*/
    public function get_recent_stat_posts()
    {
        return $this->get_recent_posts(POST_TYPE_STAT);
    }
	
	/**
	* Get all recent posts 
	*/
	public function get_recent_posts($type = -1)
	{
		$result_array = array();
		
		if($type = -1)
		{
			$this->db->where(array("type" => $type));
			$result = $this->db->get(BLOG_POSTS);
		}
		else
		{
			$result = $this->db->get(BLOG_POSTS);
		}
		
		foreach($result->result() as $post)
		{
			// get post comments
			$post->comments = $this->get_post_data($post->id, BLOG_POSTS_COMMENTS);
			
			// get post likes
			$post->likes = $this->get_post_data($post->id, BLOG_POSTS_LIKES);;
			
			$result_array[$post->id] = $post;
		}
		
		return $result_array;
	}
	
	private function get_post_data($post_id, $table_name)
	{
		$result_array = array();
		$this->db->where(array("post_id" => $post_id));
		$res = $this->db->get($table_name);
		
		foreach($res->result() as $data)
		{
			$result_array[$data->id] = $data;
		}
		
		return $result_array;
	}
}
