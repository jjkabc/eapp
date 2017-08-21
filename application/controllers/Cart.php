<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function sort_by_stores($itemA, $itemB)
{
	$al = strtolower($itemA->store_product->retailer->name);
	$bl = strtolower($itemB->store_product->retailer->name);
	if ($al == $bl) 
	{
		return 0;
	}
	return ($al > $bl) ? +1 : -1;
}

class Cart extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('cart');
        $this->load->library('geo');
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
        $this->data['body'] = $this->load->view('cart/index', '', TRUE);
        $this->data['distance_from_home'] = 'Distance from home';
        $this->rememberme->recordOrigPage();
        $this->parser->parse('eapp_template', $this->data);
    }
    
    public function product($id)
    {
        // get best product
        $best_store_product = $this->cart_model->get_best_store_product($id, DEFAULT_DISTANCE, MAX_DISTANCE, $this->user);
        $store_product = $this->cart_model->getStoreProduct($best_store_product->id);
        $data["relatedProducts"] = $store_product->related_products;
        $data["retailer"] = $store_product->retailer;
        $data['store_product'] = addslashes(json_encode($store_product));
        $data['products'] = addslashes(json_encode($this->admin_model->get_all(PRODUCT_TABLE)));
        $this->data['body'] = $this->load->view('cart/product', $data, TRUE);
        $this->rememberme->recordOrigPage();
        $this->parser->parse('eapp_template', $this->data);
    }
    
    public function insert_batch() 
    {
        $items = json_decode($this->input->post("items"));
        
        foreach ($items as $item) 
        {
            $store_product = $this->cart_model->get_cheapest_store_product($item->product_id);
            
            if($store_product == null)
            {
                continue;
            }

            $data = array
            (
                'id'      => $item->product_id,
                'qty'     => 1,
                'price'   => $store_product->price,
                'name'    => 'name_'.$item->product_id
            );	    

            $this->cart->insert($data);
        }
    }
    
    /**
     * Inserts a well formated item to the cart
     * and returns the rowid of the item inserted
     */
    public function insert()
    {
        $product_id = $this->input->post("product_id");
        
        $result = array
	(
            "success" => false,
	);
	
        // Get best match close to user
        $store_product = $this->cart_model->get_cheapest_store_product($product_id);
        
        if($store_product == null)
        {
            echo json_encode($result);
            return;
        }
	
	$data = array
        (
            'id'      => $store_product->product_id,
            'qty'     => 1,
            'price'   => $store_product->price,
            'name'    => 'name_'.$store_product->product_id
	);	    
        
        $rowid = $this->cart->insert($data);
		
	if($rowid)
	{
            $result["rowid"] = $rowid;
            $result["success"] = true;
            $result["store_product"] = $store_product;
            $result["product"] = $this->cart_model->get(PRODUCT_TABLE, $product_id);
	}
		
        echo json_encode($result);
    }
    
    public function update()
    {
        $item = json_decode($this->input->post("item"));
        
        $return = $this->cart->update($item);
        
        echo json_encode($return);
    }
    
    public function remove() 
    {
        
        $rowid = $this->input->post("rowid");
        
        $result = array
	(
            "success" => false,
	);
        
        if($this->cart->remove($rowid))
        {
            $result["success"] = true;
        }
        
        echo json_encode($result);
    }
    
    /**
     * Descroy the cart
     */
    public function destroy()
    {
        $this->cart->destroy();
    }
    
    public function get_cart_contents() 
    {
        echo $this->get_cached_cart_contents();
    }
    
    /**
     * Get cart contents
     */
    public function get_contents() 
    {
        echo json_encode($this->cart->contents(TRUE));
    }
    
    /**
     * Method that gets an optimized list from a list of cart items
     * within a given distance
     */
    public function update_cart_list()
    {
        // list of products found within the distance
        $optimizedList = array();   
        // list of products that were not found within the distance
        $products_not_found_list = array();
        // get the distance
        $distance = $this->input->post("distance");
        // get the cart products
        $products = json_decode($this->input->post("products"));
        $search_all = $this->input->post("searchAll") == "true" ? true : false;
        $coords = array("longitude" => $this->input->post("longitude"), "latitude" => $this->input->post("latitude"));

        foreach($products as $product)
        {
            // get the best store product based on price
            $store_product = $this->cart_model->get_best_store_product($product->id, $distance, $distance, $this->user, $search_all, $coords);
            $cart_item = new stdClass();
            $cart_item->store_product = $store_product;
            $cart_item->store_product->product->in_user_grocery_list = $this->inUserList($product->id);
            $cart_item->product = $this->cart_model->get_product($product->id);
            $cart_item->product->in_user_grocery_list = $this->inUserList($product->id);
            $cart_item->rowid = $product->rowid;
            $cart_item->quantity = $product->quantity;
            
            // distance of 0 means it wasn't found within the distance specified
            if($store_product->price == 0)
            {
                array_push($products_not_found_list, $cart_item);
            }
            else
            {
                array_push($optimizedList, $cart_item);
            }
        }
		
        // Order by store
        usort($optimizedList, "sort_by_stores");
        usort($products_not_found_list, "sort_by_stores");
        
        // Merge Lists putting the found items at the top
        $final_list = array_merge($optimizedList, $products_not_found_list);
		
        // returns an array where the items not found are on the bottom of the list
        $res = json_encode($final_list);
        
        if(!$res)
        {
        	echo json_last_error();
        }
        else
        {
        	echo $res;
        }
    }
	
    public function optimize_product_list_by_store()
    {
        $result = array();
        // convert km to mile
    	$distance = $this->input->post("distance");
        $products = json_decode($this->input->post("products"));
        $coords = array("longitude" => $this->input->post("longitude"), "latitude" => $this->input->post("latitude"));  
        $search_all = $this->input->post("searchAll") == "true" ? true : false;
    	// get top 5 or less closest department stores 
        // that contain at least one of the products
        $close_stores = $this->cart_model->get_closest_stores($this->user, $distance, $products, $search_all, $coords);
        
        $result['products'] = array();
        
        foreach($products as $product_item)
        {
            $store_product = $this->cart_model->get_best_store_product($product_item->id, $distance, $distance, $this->user, $search_all, $coords);
            $cart_item = new stdClass();
            $cart_item->store_product = $store_product;
            $cart_item->product = $this->cart_model->get_product($product_item->id);
            $cart_item->rowid = $product_item->rowid;
            $cart_item->quantity = $product_item->quantity;
            $cart_item->store_products = array();
            
            foreach($close_stores as $store)
            {
                // Check if the product exists for that store
                $current_store_product = $this->cart_model->get_specific(STORE_PRODUCT_TABLE, array("product_id" => $product_item->id, "retailer_id" => $store->store->chain_id));
                
                if($current_store_product != null)
                {
                    array_push($cart_item->store_products, $this->cart_model->getStoreProduct($current_store_product->id, false, false));
                }
                else
                {
                    array_push($cart_item->store_products, $this->cart_model->create_empty_store_product());
                }
            }
            
            array_push($result['products'], $cart_item);
        }
        
        $result['close_stores'] = $close_stores;
        echo json_encode($result);
	
    }
}
