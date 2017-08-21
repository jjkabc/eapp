/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

angular.module("eappApp").controller("CartController", ["$scope","$rootScope", "$http", "$mdDialog", "$sce", function($scope, $rootScope, $http, $mdDialog, $sce) 
{
    /**
     * List of selected cart items. 
     * With this list we can batch remove cart items. 
     */
    $scope.selected = [];
    
    /**
     * The query object
     */
    $scope.query = 
    {
      order: 'nameToLower',
      limit: 5,
      page: 1
    };
    
    /**
     * Callback method when the user changes his optimization preference
     * @returns void
     */
    $scope.optimization_preference_changed = function()
    {
        if($rootScope.viewing_cart_optimization.value)
        {
            $scope.update_cart_list();
        }
        else
        {
            $rootScope.stores = $scope.getListByStore();
            
            // Select the first store
            if($rootScope.stores.length > 0)
            {
                $scope.storeTabSelected($rootScope.stores[0]);
            }
            
            $scope.getStoreDrivingDistances();
            //$scope.update_product_list_by_store();
        }
    };
    
    /**
     * Set distance
     */
    $scope.distance = 10;
    
    $scope.true_value = true;
    $scope.false_value = false;
    
    /**
     * Updates the cart list by finding cheap products 
     * close to you
     * @returns {undefined}
     */
    $scope.update_cart_list = function()
    {
        // Clear items
        $rootScope.optimized_cart = [];
        // Create array with selected store_product id's
        var store_products = [];
        // Get optimized list here
        for(var index in $rootScope.cart)
        {
            var cartItem = $rootScope.cart[index];
            var data = 
            {
                    id : cartItem.product.id,
                    rowid : cartItem.rowid,
                    quantity : cartItem.quantity
            };
            store_products.push(data);
        }
		
		$rootScope.cart = [];
		
        var formData = new FormData();
        formData.append("products", JSON.stringify(store_products));
        formData.append("distance", $scope.distance);
        formData.append("longitude", $scope.longitude);
        formData.append("latitude", $scope.latitude);
        formData.append("searchAll", !$rootScope.searchInMyList.value);
        // Send request to server to get optimized list 	
        $scope.promise = 
            $http.post( $scope.site_url.concat("/cart/update_cart_list"), 
            formData, { transformRequest: angular.identity, headers: {'Content-Type': undefined}}).then(
            function(response)
            {
                // Create ordered array list
                for(var x in response.data)
                {
                        $rootScope.cart.push(response.data[x]);
                }
                $scope.getDrivingDistances();
                $scope.update_price_optimization();
            });
        
    };
    
    $scope.getListByStore = function()
    {
        var stores = [];
        
        for(var i in $rootScope.cart)
        {
            var item = $rootScope.cart[i].store_product;
            
            // each related product represents a store
            for(var x in item.related_products)
            {
                // get a product store product
                var store_product = item.related_products[x];
                store_product.related_products = item.related_products;
                // check if the store for this related product has already been added to the array
                var index = stores.map(function(e) { return e.id; }).indexOf(store_product.retailer.id); 
                
                if(index >= 0)
                {
                    var product_index = stores[index].store_products.map(function(e){ return e.product.id; }).indexOf(store_product.product.id);
                    if(product_index === -1)
                    {
                        stores[index].store_products.push(store_product);
                    }
                }
                else
                {
                    var retailer = store_product.retailer;
                    retailer.department_store = store_product.department_store;
   
                    stores.push(retailer);
                    stores[stores.length - 1].store_products = [];
                    stores[stores.length - 1].store_products.push(store_product);
                }
            }
        }
        
        for(var i in $rootScope.cart)
        {
            var item = $rootScope.cart[i];
            
            for(var x in stores)
            {
                
                                
                index = stores[x].store_products.map(function(e) { return e.product.id; }).indexOf(item.store_product.product.id); 
                
                // The product does not exist in that store
                if(index === -1)
                {
                    if(typeof stores[x].missing_products === 'undefined')
                    {
                        stores[x].missing_products = [];
                    }
                    
                    stores[x].missing_products.push(item);
                }
            }
            
        }
        
        
        return stores;
    };
    
    $scope.storeTabSelected = function(store)
    {
        for(var i in $rootScope.cart)
        {
            var related_products = $rootScope.cart[i].store_product.related_products;
            if(typeof related_products !== 'undefined')
            {
                $rootScope.cart[i].store_product = related_products[related_products.length - 1];
                $rootScope.cart[i].store_product.related_products = related_products;
            }
            
            // reset the product price
            for(var x in store.store_products)
            {
                if(parseInt($rootScope.cart[i].store_product.product.id) === parseInt(store.store_products[x].product.id))
                {
                    $rootScope.cart[i].store_product = store.store_products[x];
                }
            }
        }
        
        $scope.update_price_optimization();
    };
	
	// This method computes the distance to each product stores
    $scope.getDrivingDistances = function()
    {
    	// construct ordered list of origins and destinations
        var origins = [];
        var destinations = [];
        var mode = "DRIVING";

        for(var i in $rootScope.cart)
        {
            var currentStoreProduct = $rootScope.cart[i].store_product;
            origins.push(new google.maps.LatLng(parseFloat($scope.loggedUser.profile.latitude), parseFloat($scope.loggedUser.profile.longitude)));
            destinations.push(new google.maps.LatLng(parseFloat(currentStoreProduct.department_store.latitude), parseFloat(currentStoreProduct.department_store.longitude)));
        }

        var service = new google.maps.DistanceMatrixService();
        service.getDistanceMatrix(
        {
            origins: origins,
            destinations: destinations,
            travelMode: mode,
            avoidHighways: false,
            avoidTolls: false
        }, function(response, status)
        {
            if(response === null || typeof response === "undefined")
            {
                return;
            }

            $rootScope.$apply(function()
            {
                for(var x in response.rows)
                {
                    var distance = 0;
                    var time = 0;
                    if(typeof response.rows[x].elements[0].status !== 'undefined' && response.rows[x].elements[0].status === "ZERO_RESULTS")
                    {
                        $rootScope.cart[x].store_product.department_store.time = time;
                        $rootScope.cart[x].store_product.department_store.distance = distance;
                        continue;
                    }
                    else
                    {
                        distance = parseFloat(response.rows[x].elements[0].distance.value) / 1000;
                        time = parseFloat(response.rows[x].elements[0].duration.value) / 60;
                    }

                    $rootScope.cart[x].store_product.department_store.time = time;
                    $rootScope.cart[x].store_product.department_store.distance = distance;
                }

                $scope.update_travel_distance();
            });

        });
	  
    };
    
    $scope.getStoreDrivingDistances = function()
    {
    	// construct ordered list of origins and destinations
        var origins = [];
        var destinations = [];
        var mode = "DRIVING";

        for(var i in $rootScope.stores)
        {
            var department_store = $rootScope.stores[i].department_store;
            origins.push(new google.maps.LatLng(parseFloat($scope.loggedUser.profile.latitude), parseFloat($scope.loggedUser.profile.longitude)));
            destinations.push(new google.maps.LatLng(parseFloat(department_store.latitude), parseFloat(department_store.longitude)));

                
        }
        
        var service = new google.maps.DistanceMatrixService();
        service.getDistanceMatrix(
        {
                origins: origins,
                destinations: destinations,
                travelMode: mode,
                avoidHighways: false,
                avoidTolls: false
        }, function(response, status)
        {
            if(response === null || typeof response === "undefined")
            {
                return;
            }

            $rootScope.$apply(function()
            {
                for(var x in response.rows)
                {
                    var distance = 0;
                    var time = 0;
                    if(typeof response.rows[x].elements[0].status !== 'undefined' && response.rows[x].elements[0].status === "ZERO_RESULTS")
                    {
                        $rootScope.stores[x].department_store.distance = distance;
                        $rootScope.stores[x].department_store.time = time;
                        continue;
                    }
                    else
                    {
                        distance = parseFloat(response.rows[x].elements[0].distance.value) / 1000;
                        time = parseFloat(response.rows[x].elements[0].duration.value) / 60;
                    }
                    
                    $rootScope.stores[x].department_store.distance = distance;
                    $rootScope.stores[x].department_store.time = time;

                    
                }
                $scope.update_travel_distance();
            });

        });
	  
    };
    
    $scope.storeChanged = function(currentStoreProduct)
    {
        for(var i in $rootScope.cart)
        {
            var item = $rootScope.cart[i];
			var mode = "DRIVING";
            
            if(parseInt(item.product.id) === parseInt(currentStoreProduct.product.id))
            {
                currentStoreProduct.related_products = $rootScope.cart[i].store_product.related_products;
                
                var origin = new google.maps.LatLng(parseFloat(currentStoreProduct.department_store.latitude), parseFloat(currentStoreProduct.department_store.longitude));
                var destination = new google.maps.LatLng(parseFloat($scope.loggedUser.profile.latitude), parseFloat($scope.loggedUser.profile.longitude));
                
                var service = new google.maps.DistanceMatrixService();
                service.getDistanceMatrix(
                {
                    origins: [origin],
                    destinations: [destination],
                    travelMode: mode,
                    avoidHighways: false,
                    avoidTolls: false
                }, function(response, status)
                {
                    var distance = parseFloat(response.rows[0].elements[0].distance.value) / 1000;
                    currentStoreProduct.department_store.distance = distance;
                    $rootScope.$apply(function()
                    {
                        $rootScope.cart[i].store_product = currentStoreProduct;
                        $scope.update_distance_price_optimization();
                    });
                    
                });
                
                break;
            }
        }
    };
	
    $scope.update_price_optimization = function()
    {
            $scope.distance_optimization = 0;
            $scope.price_optimization = 0;

            for(var key in $scope.cart)
            {
                var cart_item = $scope.cart[key];

                if(typeof cart_item.store_product.worst_product === "undefined" || cart_item.store_product.worst_product === null)
                {
                    continue;
                }
                $scope.price_optimization += parseFloat(cart_item.store_product.worst_product.price) - parseFloat(cart_item.store_product.price);
            }
    };
    
    /**
     * Optimize product list by finding items in stores
     * close to you.
     * @returns {undefined}
     */
    $scope.update_product_list_by_store = function()
    {
        $rootScope.close_stores = [];
        $rootScope.store_products = [];
        $rootScope.loading_store_products = true;
        // Create array with selected store_product id's
        var store_products = [];
        // Get optimized list here
        for(var index in $rootScope.cart)
        {
            var cartItem = $rootScope.cart[index];
            var data = 
            {
                id : cartItem.product.id,
                rowid : cartItem.rowid,
                quantity : cartItem.quantity
            };
            store_products.push(data);
        }

        var formData = new FormData();
        formData.append("products", JSON.stringify(store_products));
        formData.append("distance", $scope.distance);
        formData.append("longitude", $scope.longitude);
        formData.append("latitude", $scope.latitude);
	formData.append("searchAll", !$rootScope.searchInMyList);
        // Send request to server to get optimized list 	
        $scope.store_cart_promise = 
            $http.post( $scope.site_url.concat("/cart/optimize_product_list_by_store"), 
            formData, { transformRequest: angular.identity, headers: {'Content-Type': undefined}}).then(
            function(response)
            {
                
                $rootScope.close_stores = response.data.close_stores;
                $rootScope.store_products = response.data.products;
                                
                var close_stores_array = $.map($rootScope.close_stores, function(value, index) {
                    return [value];
                });
                
                var store_products_array = $.map($rootScope.store_products, function(value, index) {
                    return [value];
                });
                
                $rootScope.close_stores = close_stores_array;
                $rootScope.cart = store_products_array;
                $rootScope.loading_store_products = false;
                
            });
        
    };
    
    $scope.get_price_label = function(store_product, product)
    {
        return parseFloat(store_product.price) === 0 ? "Item pas disponible" : "CAD " + store_product.price * product.quantity;
    };
    
    /**
     * This method applies the selected store
     * @param {type} index
     * @returns {void}
     */
    $scope.store_selected = function(index)
    {
        for(var store_index in $rootScope.close_stores)
        {
            if(parseInt(store_index) !== parseInt(index))
            {
                $rootScope.close_stores[store_index].selected = false;
            }
            else
            {
                $rootScope.travel_distance = $rootScope.close_stores[store_index].distance;
            }
        }
        
        for(var product_index in $rootScope.cart)
        {
            $rootScope.cart[product_index].store_product = $rootScope.cart[product_index].store_products[index];
        }
    }; 
    
    $scope.update_travel_distance = function()
    {
        var traval_distance = 0;
        var stores = [];
        
        for(var key in $rootScope.cart)
        {
            var product = $rootScope.cart[key];
            
            if(typeof product.store_product.department_store !== 'undefined' && $.inArray(product.store_product.department_store.id, stores) === -1)
            {
                stores.push(product.store_product.department_store.id);
                traval_distance += parseInt(product.store_product.department_store.distance);
            }
        }
        
        $rootScope.travel_distance = traval_distance;
    };
    
    $rootScope.clearCart = function($event)
    {
        var confirmDialog = $rootScope.createConfirmDIalog($event, "Cela effacera tous les contenus de votre panier.");
        
        $mdDialog.show(confirmDialog).then(function() 
        {
            $http.post($rootScope.site_url.concat("/cart/destroy"), null).then(function(response)
            {
                $rootScope.cart = [];
                $rootScope.stores = [];
            });

        });
        
        
    };
     
    $rootScope.relatedProductsAvailable = function()
    {
        if(typeof $scope.storeProduct !== 'undefined')
        {
            if(typeof $scope.storeProduct.related_products !== 'undefined' && $scope.storeProduct.related_products.length > 0)
            {
                return true;
            }
        }
        
        return false;
    };
    
    $rootScope.getCartContents = function()
    {                
        var formData = new FormData();
        formData.append("longitude", $rootScope.longitude);
        formData.append("latitude", $rootScope.latitude);
        // Send request to server to get optimized list 	
        $scope.promise = $http.post($scope.site_url.concat("/cart/get_cart_contents"), 
        formData, { transformRequest: angular.identity, headers: {'Content-Type': undefined}}).then(
        function(response)
        {
            if(response.data)
            {
                $rootScope.cart = response.data;
            }
        });
    };
	
}]);
