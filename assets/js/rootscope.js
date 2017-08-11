$(document).ready(function()
{
    var rootScope = angular.element($("html")).scope();
    
    rootScope.$apply(function()
    {
        rootScope.hit = function(table_name, id)
        {
            var formData = new FormData();
            formData.append("table_name", table_name);
            formData.append("id", id);
            
            $.post(rootScope.site_url.concat("admin/hit"), {table_name : table_name, id : id});
        };
        
        rootScope.is_loading = false;
        rootScope.valid = true;
        rootScope.success_message = "";
        rootScope.error_message = "";
        
        /* CART */
        
        /**
         * When this is true, the user is viewing optimizations
         * based on the cart. When false, he is viewing optimization 
         * based on the closest stores. 
         */
        rootScope.viewing_cart_optimization = { value: true};

        rootScope.searchInMyList = false;
        
        /**
         * List of optimized cart store product items
         */
        rootScope.optimized_cart = [];
        
        /**
         * List of selected cart items
         */
        rootScope.cart = [];
        
        /**
         * When this variable is true, the application is loading store optimizations. 
         * We display the progress bar
         */
        rootScope.loading_store_products = false;

        rootScope.travel_distance = 0;
        
        rootScope.get_store_total = function(store_index)
        {        
            var total = 0;

            for(var key in rootScope.cart)
            {
                //$rootScope.store_products[index].store_products
                total += 
                        !rootScope.viewing_cart_optimization.value ? 
                            rootScope.cart[key].store_products[store_index].price * rootScope.cart[key].quantity : 
                            rootScope.cart[key].store_product.price * rootScope.cart[key].quantity;
            }

            return total;
        };
        
        rootScope.get_cart_total_price = function()
        {
            var total = 0;

            for(var key in rootScope.cart)
            {
                    total += parseFloat(rootScope.cart[key].quantity * rootScope.cart[key].store_product.price);
            }

            return total;
        };
        
        /*
        * Get total number of items in the cart
        */
        rootScope.get_cart_item_total = function()
        {
            var total = 0;

            for(var key in rootScope.cart)
            {
                if(parseFloat(rootScope.cart[key].store_product.price) !== 0)
                {
                    total++;
                }
            }

            return total;
        };
        
        rootScope.get_optimized_cart_details = function()
        {
            var total = 0;

            for(var key in rootScope.optimized_cart)
            {
                total += parseFloat(rootScope.optimized_cart[key].quantity * rootScope.optimized_cart[key].store_product.price);
            }

            return total;
        };
        
    rootScope.add_product_to_cart = function(product_id)
    {
        var data = 
        {
            product_id : product_id,
            longitude : rootScope.longitude,
            latitude : rootScope.latitude
        };
        
	    $.ajax({
            type: 'POST',
            url:   rootScope.site_url.concat("/cart/insert"),
            data: data,
            success: function(response)
            {
                var response_data = JSON.parse(response);

                if(Boolean(response_data.success))
                {
                    // Add Global Cart list
                    var cart_item = 
                    {
                        rowid : response_data.rowid,
                        store_product : response_data.store_product,
                        top_five_store_products : [],
                        quantity : 1
                    };

                    // Get the root scope. That's where the cart will reside. 
                    var scope = angular.element($("html")).scope();

                    scope.$apply(function()
                    {
                        if (typeof scope.cart === 'undefined') 
                        {
                            // Create new cart. 
                            scope.cart = [];
                        }
                        
                        if(scope.cart == null || typeof scope.cart === 'undefined')
                        {
                            scope.cart = [];
                        }
                        
                        scope.cart.push(cart_item);
                    });
                }
            },
            async:true
        });
    };
        
        /* CART END*/
        
        
        				

        
        
        
    });

});
