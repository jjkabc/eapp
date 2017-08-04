<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

    public function __construct()
    {
        
        parent::__construct();
		$data["recentPosts"] = addslashes(json_encode($this->blog_model->get_recent_posts()));
        $this->data['css'] = $this->load->view('blog/css', $this->data, TRUE);
        $this->data['scripts'] = $this->load->view('blog/scripts', $this->data, TRUE);
	    $this->data['recent_posts'] = $this->load->view('blog/recent_posts_widget', $this->data, TRUE);
		
    }
    
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function press_release()
    {
		$this->rememberme->recordOrigPage();
        $this->data['body'] = $this->parser->parse("blog/press-release", $this->data, TRUE);
        $this->parser->parse('eapp_template', $this->data);
    }  
	
	public function detail($post_id)
    {
		$this->rememberme->recordOrigPage();
		$data["post"] = addslashes(json_encode($this->blog_model->get(BLOG_POSTS, $post_id)));
        $this->data['body'] = $this->parser->parse("blog/stat-detail", $this->data, TRUE);
        $this->parser->parse('eapp_template', $this->data);
    } 
	
	public function stats()
    {
		$this->rememberme->recordOrigPage();
		$data["recentStats"] = addslashes(json_encode($this->blog_model->get_recent_stat_posts()));
        $this->data['body'] = $this->parser->parse("blog/stat", $this->data, TRUE);
        $this->parser->parse('eapp_template', $this->data);
    }
	
	public function like()
	{
		$id = $this->input->post("post_id");
		
		$this->blog_model->like($id, $this->user))
		
		echo  json_encode(addslashes($this->blog_model->get_post_data($id, BLOG_POSTS_LIKES)));	
	}
	
	public function dislike()
	{
		$id = $this->input->post("post_id");
		
		$this->blog_model->dislike($id, $this->user))
		
		return json_encode(addslashes($this->blog_model->get_post_data($id, BLOG_POSTS_LIKES)));	
	}
}
