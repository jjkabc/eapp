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
		
	rootScope.can_add_to_cart = function(product_id)
     {
        for(var key in rootScope.cart)
		{
			if(parseInt(rootScope.cart[key].store_product.product_id) === parseInt(product_id))
			{
				return false;
			}
		}

		return true;
    };
		
	rootScope.getRowID = function(product_id)
    {
        var rowid = -1;
        
        for(var key in rootScope.cart)
		{
            if(parseInt(rootScope.cart[key].store_product.product_id) === parseInt(product_id))
            {
                rowid = rootScope.cart[key].rowid;
                break;
            }
		}
        
        return rowid;
    };
		
	rootScope.removeItemFromCart = function(product_id)
    {
        var index = -1;
        
        for(var key in rootScope.cart)
		{
			if(parseInt(rootScope.cart[key].store_product.product_id) === parseInt(product_id))
			{
				index = key;
				break;
			}
		}
        
        if(index > -1)
        {
            rootScope.cart.splice(index, 1);
        }
    };
		
	rootScope.remove_product_from_cart = function(product_id)
    {
        
        var data = 
		{
				rowid : rootScope.getRowID(product_id)
		};

		$.ajax({
				type: 'POST',
				url:   rootScope.site_url.concat("/cart/remove"),
				data: data,
				success: function(response)
				{
					var response_data = JSON.parse(response);

					if(Boolean(response_data.success))
					{
						// Remove from Global Cart list
						// Get the root scope. That's where the cart will reside. 
						var scope = angular.element($("html")).scope();

						scope.$apply(function()
						{
							rootScope.removeItemFromCart(product_id);
						});
					}
				},
				async:true
		});
    };
	
	rootScope.getUserCoordinates = function()
    {
        // Get the current geo location only if it's not yet the case
        if ('https:' == document.location.protocol && "geolocation" in navigator && !window.localStorage.getItem("longitude") && !window.localStorage.getItem("latitude")) 
        {
            navigator.geolocation.getCurrentPosition(function(position) 
            {
                rootScope.longitude = position.coords.longitude;
                rootScope.latitude = position.coords.latitude;
                window.localStorage.setItem("longitude", rootScope.longitude);
                window.localStorage.setItem("latitude", rootScope.latitude);
                rootScope.getCartContents();
            });
        }
        else
        {
			rootScope.getCartContents();
        }
    };
        
	rootScope.promptForZipCode = function(ev) 
    {
        rootScope.longitude = window.localStorage.getItem("longitude");
        rootScope.latitude = window.localStorage.getItem("latitude");

        if(!window.localStorage.getItem("longitude") && !window.localStorage.getItem("latitude") && !rootScope.isUserLogged)
        {
            // Appending dialog to document.body to cover sidenav in docs app
            var confirm = $mdDialog.prompt()
              .title('Veillez entrer votre code postale. ')
              .textContent('Ceci vas aider a optimiser les resultats.')
              .placeholder('Votre Code Postale E.g. H1H 1H1')
              .ariaLabel('Code Postale')
              .initialValue('')
              .targetEvent(ev)
              .ok('Valider!')
              .cancel('Annuler');

            $mdDialog.show(confirm).then(function(result) 
            {
                    var address = result;
                    var geocoder = new google.maps.Geocoder();
                    geocoder.geocode( { 'address': address}, function(results, status) 
                    {
                            if (status === google.maps.GeocoderStatus.OK) 
                            {
								 rootScope.latitude = results[0].geometry.location.lat();
								 rootScope.longitude = results[0].geometry.location.lng();
								 window.localStorage.setItem("longitude", rootScope.longitude);
								 window.localStorage.setItem("latitude", rootScope.latitude);
								 rootScope.getCartContents();
                            }
                            else
                            {
								rootScope.getUserCoordinates();
                            }
                    });


            }, function() 
            {
                rootScope.getUserCoordinates();
            });
        }
        else
        {
            rootScope.getCartContents();
        }
    };
    
    rootScope.getCartContents = function()
    {   
        var formData = new FormData();
        formData.append("longitude", rootScope.longitude);
        formData.append("latitude", rootScope.latitude);
        
        $.post(rootScope.site_url.concat("/cart/get_cart_contents"),{ longitude : rootScope.longitude, latitude : rootScope.latitude})
        .done(function(data)
        {
            var parsedData = JSON.parse(data);
            
            if(parsedData)
            {
                var scope = angular.element($("html")).scope();

                scope.$apply(function()
                {
                    rootScope.cart = parsedData;
                });
                
            }
        });
    };
		
		
	
		
		
	/* CART END*/
		
	/* ACCOUNT */
		
		rootScope.addToMyList = function(product)
		{
			product.quantity = 1;

			rootScope.currentProduct = product;

			rootScope.AddProductToList();

			rootScope.saveMyList();
		};

		rootScope.removeFromMyList = function(product)
		{
			rootScope.removeProductFromList(product.id, null);
			rootScope.saveMyList();
		};

		rootScope.favoriteChanged = function(product)
		{
			if(product.favorite)
			{
				rootScope.addToMyList(product);
			}
			else
			{
				rootScope.removeFromMyList(product);
			}
		};
		
		rootScope.inMyList = function(product_id)
		{
			if(rootScope.isUserLogged)
			{
				for(var key in rootScope.loggedUser.grocery_list)
				{
					if(parseInt(rootScope.loggedUser.grocery_list[key].id) === parseInt(product_id))
					{
						return true;
					}
				}
			}

			return false;
		};
		
	/*ACCOUNT END*/
        
        // THis is called for a non logged user to prompt for his zip code
        // If that's not already the case. 
        if(typeof rootScope.promptForZipCode !== "undefined")
        {
                rootScope.promptForZipCode();
        }
        
    });

});
