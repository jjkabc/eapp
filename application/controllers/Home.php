<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

     public function __construct()
    {
        parent::__construct();
        $this->load->library('cart');
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
    public function index()
    {
        $this->data['stores'] = $this->admin_model->get_chains();
        $this->data['latestProducts'] = $this->home_model->get_store_products_limit(25, 0)["products"];
        $this->data['body'] = $this->load->view('home/index', $this->data, TRUE);
        $this->rememberme->recordOrigPage();
        $this->parser->parse('eapp_template', $this->data);
    }

    public function change_location()
    {
        $this->data['body'] = $this->load->view('home/change-location', $this->data, TRUE);
        $this->parser->parse('eapp_template', $this->data);
    }
    
    public function contact_us()
    {
        $this->data['body'] = $this->load->view('home/contact-us', $this->data, TRUE);
        $this->parser->parse('eapp_template', $this->data);
    }
    
    public function goback() 
    {
        $redirect_url = $this->rememberme->getOrigPage();
                
        if(!$redirect_url)
        {
            $redirect_url = "home";
        }
        
        redirect($redirect_url);
    }
}
