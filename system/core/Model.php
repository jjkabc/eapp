<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2017, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2017, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

function cmp_store_product_asc_name($a, $b)
{
    return strcmp($a->product->name, $b->product->name);
}

function cmp_store_product_desc_name($a, $b)
{
    return strcmp($b->product->name, $a->product->name);
}

function cmp_store_product_asc_date($a, $b)
{
    if(strtotime($a->period_from) < strtotime($b->period_from))
    {
        return -1;
    }
    else if(strtotime($a->period_from) > strtotime($b->period_from))
    {
        return 1;
    }
    else
    {
        return 0;
    }
}

function cmp_store_product_desc_date($a, $b)
{
    if(strtotime($a->period_from) < strtotime($b->period_from))
    {
        return 1;
    }
    else if(strtotime($a->period_from) > strtotime($b->period_from))
    {
        return -1;
    }
    else
    {
        return 0;
    }
}




/**
 * Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/libraries/config.html
 */
class CI_Model {

    public $latest_products_condition;
    public $store_product_product_join;
    public $store_product_subcategory_join;
    
    /**
     * Class constructor
     *
     * @return	void
     */
    public function __construct()
    {
        log_message('info', 'Model Class Initialized');
        $this->latest_products_condition = 'period_from <= CURDATE() AND period_to >= CURDATE()';
        $this->store_product_product_join = sprintf("%s.product_id = %s.id", STORE_PRODUCT_TABLE, PRODUCT_TABLE);
        $this->store_product_subcategory_join = sprintf("%s.subcategory_id = %s.id", PRODUCT_TABLE, SUB_CATEGORY_TABLE);
    }

    // --------------------------------------------------------------------

    /**
     * __get magic
     *
     * Allows models to access CI's loaded classes using the same
     * syntax as controllers.
     *
     * @param	string	$key
     */
    public function __get($key)
    {
		// Debugging note:
		//	If you're here because you're getting an error message
		//	saying 'Undefined Property: system/core/Model.php', it's
		//	most likely a typo in your model code.
		return get_instance()->$key;
    }
        
    public function eapp_get($table_name, $id)
    {
        $this->db->select("*");
        $this->db->from($table_name);
        $this->db->where('id', $id);
        $query = $this->db->get();
        if($query != null)
        {
            return $query->row();
        }
        else
        {
            return null;
        }
    }
        
    public function get($table_name, $id, $columns = "*")
    {
        $this->db->select($columns);
        $this->db->from($table_name);
        $this->db->where('id', $id);
        $query = $this->db->get();
        if($query != null)
        {
            return $query->row();
        }
        else
        {
            return null;
        }
    }
    
    public function get_specific($table_name, $data)
    {
        $this->db->select("*");
        $this->db->where($data);
        $query = $this->db->get($table_name);
        if($query != null)
        {
            return $query->row();
        }
        else
        {
            return null;
        }
    }
    
    public function getStoreProduct($id, $includeRelatedProducts = true, $latestProduct = true, $minified = false) 
    {
        // Get the store product object
	if($latestProduct)
	{
            $this->db->where('period_from <= CURDATE() AND period_to >= CURDATE()', NULL, FALSE);
	}
	
        $store_product_columns = "*";
        $chain_columns = "*";
        $units_columns = "*";
        $brand_columns = "*";
        if($minified)
        {
            $store_product_columns = "id, product_id, retailer_id, brand_id, unit_id, country, state, organic, format, size, quantity, price, unit_price, period_from, period_to";
            $chain_columns = "id, name, image";
            $units_columns = "id, name";
            $brand_columns = "id, name, image";
        }
        
        $store_product = $this->get(STORE_PRODUCT_TABLE, $id, $store_product_columns);

        if($store_product != null)
        {
            // Get associated product
            $store_product->product = $this->get_product($store_product->product_id, $minified);
            
            // If the name of the store product is not set, use that of the product
            if(!isset($store_product->name) || empty($store_product->name))
            {
                $store_product->name = $store_product->product->name;
            }
            
            // Get product store
            $store_product->retailer = $this->get_retailer($store_product->retailer_id, $chain_columns);
            // Get product unit
            $store_product->unit = $this->get(UNITS_TABLE, $store_product->unit_id, $units_columns);
            // Get subcategory
            if($store_product->product != null && $includeRelatedProducts)
            {
                $store_product->similar_products = $this->get_related_products($store_product);
            }
            
            // Get the brand from the database
            $store_product->brand = $this->get(PRODUCT_BRAND_TABLE, $store_product->brand_id, $brand_columns);
            // If the brand contains a web image and the product has no image
            if($store_product->brand != null 
                    && strpos($store_product->brand->image, 'http') !== FALSE
                    && (empty($store_product->product->image) || isset($store_product->product->image)))
            {
                $store_product->product->image = $store_product->brand->image;
            }
            else if($store_product->brand != null 
                    && file_exists(base_url("/assets/img/products/").$store_product->brand->image) !== FALSE
                    && (empty($store_product->product->image) || isset($store_product->product->image)))
            {
                $store_product->product->image = base_url("/assets/img/products/").$store_product->brand->image;
            }
            
            // The store product has its own specific image. 
            // Override the product image. 
            if(!empty($store_product->image) && strpos($store_product->image, 'http') === true)
            {
                $store_product->product->image = $store_product->image;
            }
            
            // It has it's own store name. Override the product name with this
            if(!empty($store_product->store_name))
            {
                $store_product->product->name = $store_product->store_name;
            }
        }
        
        return $store_product;
    }
    
    public function get_all($table_name)
    {
        $result = array();
        
        $query =  $this->db->get($table_name);
        
        foreach ($query->result() as $value) 
        {
            $result[$value->id] = $value;
        }
        
        return $result;
    }
	
    public function get_products()
    {
        $products = $this->get_all(PRODUCT_TABLE);

        foreach($products as $product)
        {

        }

        return $products;
    }
    
    public function get_chains()
    {
        
        $chains = $this->get_all(CHAIN_TABLE);
        
        foreach ($chains as $key => $value) 
        {
            $store_image_path = ASSETS_DIR_PATH."img/stores/".$value->image;
            
            if(!file_exists($store_image_path) || empty($value->image))
            {
                $chains[$key]->image = "no_image_available.png";
            }
            
            $chains[$key]->image = base_url('/assets/img/stores/').$chains[$key]->image;
        }
        
        return $chains;
    }
        
    /**
     * This method gets the other store products related to this store product
     * @param type $storeProduct
     */
    private function get_related_products($storeProduct, $latestProduct = true) 
    {
        $related_products = array();
        
        $array = array("product_id" => $storeProduct->product_id, STORE_PRODUCT_TABLE.".id !=" => $storeProduct->id);
        $get = sprintf("%s.id", STORE_PRODUCT_TABLE);
        $this->db->select($get);
        $this->db->from(STORE_PRODUCT_TABLE);
        $this->db->where($array);
        // Get the store product object
        if($latestProduct)
        {
            $this->db->where('period_from <= CURDATE() AND period_to >= CURDATE()', NULL, FALSE);
        }
        $ids = $this->db->get()->result();
        
        foreach ($ids as $value) 
        {
            array_push($related_products, $this->getStoreProduct($value->id, false));
        }
        
        return $related_products;
        
    }
    
    public function get_all_limit($table_name, $limit, $offset)
    {
        $result = array();
        
        $this->db->limit($limit, $offset);
        
        $query =  $this->db->get($table_name);
        
        foreach ($query->result() as $value) 
        {
            $result[$value->id] = $value;
        }
        
        return $result;
    }
    
    public function get_product($product_id, $get_store_products = true, $minified = false) 
    {
        $product_columns = "*";
        $subcategory_columns = "*";
        $category_columns = "*";
        
        if($minified)
        {
            $product_columns = "id, name, subcategory_id, image";
            $subcategory_columns = "id, name, product_category_id";
            $category_columns = "id, name";
        }
        
        $value = $this->get(PRODUCT_TABLE, $product_id, $product_columns);
                        
        $store_image_path = ASSETS_DIR_PATH."img/products/".$value->image;
        
        if(strpos($value->image, 'http') === false)
        {
            // File doesn't exist or image value is empty, set the empty image value
            if((!file_exists($store_image_path) || empty($value->image)))
            {
                $value->image = "no_image_available.png";
            }
            
            $value->image = base_url("/assets/img/products/").$value->image;
        }
        
        $value->subcategory = $this->get(SUB_CATEGORY_TABLE, $value->subcategory_id, $subcategory_columns);
        
        // Get category
        if($value->subcategory != null)
        {
            $value->category = $this->get(CATEGORY_TABLE, $value->subcategory->product_category_id, $category_columns);
        }
        
        if($get_store_products)
        {
            $value->store_products = $this->get_flyer_products($product_id, $minified);
        }	 

        return $value;
    }
    
    public function get_retailer($retailer_id, $chain_columns) 
    {
        $retailer = $this->get(CHAIN_TABLE, $retailer_id, $chain_columns);
            
        if($retailer == null)
        {
            return $retailer;
        }
        
        $store_image_path = base_url('/assets/img/stores/').$retailer->image;

        // Retailer Image does not contain http, set its path
        if(strpos($retailer->image, 'http') === FALSE)
        {
            if(!file_exists($store_image_path) || empty($retailer->image))
            {
                $retailer->image = base_url('/assets/img/stores/no_image_available.png');
            }

            $retailer->image = $store_image_path;
        }
        
        return $retailer;
        
    }
	
    private function get_flyer_products($product_id, $minified)
    {
        $store_product_columns = "*";
        
        if($minified)
        {
            $store_product_columns = "id, product_id, retailer_id, brand_id, unit_id, country, state, organic, format, size, quantity, price";
        }
        $this->db->where('period_from <= CURDATE() AND period_to >= CURDATE()', NULL, FALSE);
        $this->db->select($store_product_columns.", ".PRODUCT_BRAND_TABLE.".name as brandName, ".PRODUCT_BRAND_TABLE.".id as brand_id");
        $this->db->where(array(STORE_PRODUCT_TABLE.".product_id" => $product_id, "in_flyer" => 1));
        $this->db->join(PRODUCT_BRAND_TABLE, PRODUCT_BRAND_TABLE.".id = ".STORE_PRODUCT_TABLE.".brand_id", "left outer");
        $result = $this->db->get(STORE_PRODUCT_TABLE);

        return $result->result();
    }
    
    /**
     * Create an EAPP object
     * @param type $table_name
     * @param type $data
     */
    public function create($table_name, $data, $is_new = false)
    {
        if(isset($data['id']) && !$is_new)
        {
            $query = $this->db->get_where($table_name, array('id' => $data['id']));
            $count = $query->num_rows(); 
            if($count === 0)
            {
                $data['date_created'] = date("Y-m-d H:i:s");
                $this->db->insert($table_name, $data);
                return $this->db->insert_id();
            }
            else
            {
                $this->db->where('id', $data['id']);
                $this->db->update($table_name, $data);
                return $data['id'];
            }
        }
        else
        {
            $this->db->insert($table_name, $data);
            return $this->db->insert_id();
        }
        
        
    }
    
    public function get_store_products_limit($limit, $offset, $latest_products = true, $filter = null, $order = null, $store_id = null, $category_id = null)
    {
        $result = array();
        // Get the distinct product id's present 
        $this->db->limit($limit, $offset);
        
        // Perform sorting here if required
        if($order)
        {
            if(strpos($order, "-") !== false) // sort in descending order
            {
                $order = str_replace("-", "", $order);
                
                if($order == 'date_modified')
                {
                    $order = STORE_PRODUCT_TABLE.".".$order;
                }
                
                if($order == 'name')
                {
                    $order = PRODUCT_TABLE.".".$order;
                }
                
                $this->db->order_by($order, "DESC");
            }
            else
            {
                if($order == 'date_modified')
                {
                    $order = STORE_PRODUCT_TABLE.".".$order;
                }
                
                if($order == 'name')
                {
                    $order = PRODUCT_TABLE.".".$order;
                }
                
                $this->db->order_by($order, "ASC");
            }
        }
		
        // Get the store product object
        if($latest_products)
        {
            $result = $this->get_latest_products($filter, $store_id, $category_id);
        }
        else
        {
            // since we are not getting the latest products, return all the products
            $result = $this->get_all_products($filter, $store_id, $category_id);
        }
        return $result;
    }
    
    private function get_latest_products($filter = null, $store_id = null, $category_id = null)
    {
        $result = array();
        $products = array();
        
        // Get products that satisfy conditions
        $product_ids = $this->get_distinct_latest_products($filter, $store_id, $category_id);
		
        $non_limited_product_ids = $this->get_distinct_latest_products($filter, $store_id, $category_id);
        $result["count"] = sizeof($non_limited_product_ids);
        
        // Get cheapest store product for each product
        // close to the user    
        foreach($product_ids as $product_id)
        {
            $res = $this->get_best_latest_store_product($product_id->product_id, $filter, $store_id, $category_id);

            if($res)
            {
                $store_product = $this->getStoreProduct($res->id, false, true);
                $store_product->quantity = 1;
                $products[$store_product->id] = $store_product;
                $this->db->reset_query();
            }
        }
        
        $result["products"] = $products;
        return $result;
    }
	
    private function get_distinct_latest_products($filter, $store_id, $category_id)
    {
        $this->db->join(PRODUCT_TABLE, $this->store_product_product_join);
        
        if($filter != null)
        {
            $this->db->like(PRODUCT_TABLE.".name", $filter);
        }

        if($store_id != null)
        {
            $this->db->where(array("retailer_id" => $store_id));
        }
        if($category_id != null)
        {
            $this->db->join(SUB_CATEGORY_TABLE, $this->store_product_subcategory_join);	
            $this->db->where(array(SUB_CATEGORY_TABLE.".product_category_id" => $category_id));
        } 
                
        // Get products that satisfy conditions
        $product_ids = $this->get_distinct(STORE_PRODUCT_TABLE, "product_id", $this->latest_products_condition);

        return $product_ids;
    }
	
    private function get_best_latest_store_product($product_id, $filter, $store_id, $category_id)
    {
        $this->db->limit(1);

        if($filter != null)
        {
            $this->db->like("name", $filter);
        }
        
        $this->db->order_by("price", "ASC");
        $this->db->select(STORE_PRODUCT_TABLE.".id, price, product_id, ".PRODUCT_TABLE.".name");
        $this->db->join(PRODUCT_TABLE, $this->store_product_product_join);
        $this->db->where("product_id", $product_id);
        $this->db->where($this->latest_products_condition, NULL, FALSE);
        
        if($store_id != null)
        {
            $this->db->where(array("retailer_id" => $store_id));
        }
        if($category_id != null)
        {
            $this->db->join(SUB_CATEGORY_TABLE, $this->store_product_subcategory_join);	
            $this->db->where(array(SUB_CATEGORY_TABLE.".product_category_id" => $category_id));
        }
        return $this->db->get(STORE_PRODUCT_TABLE)->row();
    }
    
    private function get_all_products($filter = null, $store_id = null, $category_id = null)
    {
        $result = array();
        $products = array();
        // Executed with the limit clause
        $product_ids = $this->get_distinct_products($filter, $store_id, $category_id);

        // This is executed without the limit clause
        $non_limited_product_ids = $this->get_distinct_products($filter, $store_id, $category_id);
        $result["count"] = sizeof($non_limited_product_ids);
        
        // Get all products
        foreach($product_ids as $product_id)
        {
            $res = $this->get_best_store_product($product_id->id, $filter, $store_id, $category_id);
            
            if($res)
            {
                $store_product = $this->getStoreProduct($product_id->id, false, false);
                $store_product->quantity = 1;
                $products[$store_product->id] = $store_product;
                $this->db->reset_query();
            }
        }
        
        $result["products"] = $products;
        
        return $result;
    }
	
    private function get_distinct_products($filter, $store_id, $category_id)
    {
        $this->db->join(PRODUCT_TABLE, $this->store_product_product_join);
        
        if($filter != null)
        {
            $this->db->like(PRODUCT_TABLE.".name", $filter);
        }
        if($store_id != null)
        {
            $this->db->where(array("retailer_id" => $store_id));
        }
        if($category_id != null)
        {
            $this->db->join(SUB_CATEGORY_TABLE, $this->store_product_subcategory_join);	
            $this->db->where(array(SUB_CATEGORY_TABLE.".product_category_id" => $category_id));
        }

        return $this->get_distinct(STORE_PRODUCT_TABLE, STORE_PRODUCT_TABLE.".id", null);
    }
	
    private function get_best_store_product($product_id, $filter, $store_id, $category_id)
    {
        // Add filter for search puroses
        $this->db->limit(1);
		
        if($filter != null)
        {
            $this->db->like("name", $filter);
        }
        if($store_id != null)
        {
            $this->db->where(array("retailer_id" => $store_id));
        }
        
        $this->db->order_by("price", "ASC");
        $this->db->select(STORE_PRODUCT_TABLE.".id, price, product_id, ".PRODUCT_TABLE.".name");
        $this->db->join(PRODUCT_TABLE, $this->store_product_product_join);
        $this->db->where(STORE_PRODUCT_TABLE.".id", $product_id);
		
        if($category_id != null)
        {
            $this->db->join(SUB_CATEGORY_TABLE, $this->store_product_subcategory_join);	
            $this->db->where(array(SUB_CATEGORY_TABLE.".product_category_id" => $category_id));
        }

        return $this->db->get(STORE_PRODUCT_TABLE)->row();
    }

    public function get_distinct($table_name, $columns, $where)
    {
    	$this->db->distinct();

        $this->db->select($columns);

        if($where != null)
        {
            $this->db->where($where, NULL, FALSE);
        }
        return $this->db->get($table_name)->result();
    }
	
    /*
    * Method to get for a given user the different stores
    */
    public function get_favorite_stores($user_id)
    {
        $this->db->select(CHAIN_TABLE.".*");
        $this->db->join(USER_FAVORITE_STORE_TABLE, USER_FAVORITE_STORE_TABLE.'.retailer_id = '.CHAIN_TABLE.'.id');
        $this->db->where(array("user_account_id" => $user_id));
        return $this->db->get(CHAIN_TABLE)->result();
    }
    
    public function delete($table_name, $data)
    {
        $this->db->where($data);
        $this->db->delete($table_name);
    }
	
    /*
    * This is called when an item is clicked on the front end
    */
    public function hit($table_name, $id)
    {
        $this->db->set('hits', 'hits + 1', FALSE);
        $this->db->where("id", $id);
        $this->db->update($table_name);
    }
    
    public function get_mostviewed_categories() 
    {
        $this->db->order_by("hits", "DESC");
        $this->db->limit(5);
        $query = $this->db->get_compiled_select(CATEGORY_TABLE);
        return $this->db->query($query)->result();
    }

}
