$(document).ready(function()
{
    var rootScope = angular.element($("html")).scope();
    
    rootScope.$apply(function()
    {
        
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

        rootScope.searchInMyList = { value: false};
        
        /**
         * List of optimized cart store product items
         */
        rootScope.optimized_cart = [];
        
        /**
         * When this variable is true, the application is loading store optimizations. 
         * We display the progress bar
         */
        rootScope.loading_store_products = false;

        rootScope.travel_distance = 0;
        
        /**
         *  This is called whenever we want to record a click
         *  on an item
         * @param {type} table_name
         * @param {type} id
         */
        rootScope.hit = function(table_name, id)
        {
            var formData = new FormData();
            formData.append("table_name", table_name);
            formData.append("id", id);
            
            $.post(rootScope.site_url.concat("/admin/hit"), {table_name : table_name, id : id}).then(function(data)
            {
                
            });
        };
        
        rootScope.clearSessionItems = function()
        {
            window.sessionStorage.removeItem("store_id");
            window.sessionStorage.removeItem("category_id");
        };
        
        rootScope.select_category = function($event)
        {
            rootScope.clearSessionItems();
            var element = $event.target;
            var category_id = parseInt(element.id);
            rootScope.hit("eapp_product_category ",category_id);
            window.sessionStorage.setItem("category_id", category_id);    
            window.location =  rootScope.site_url.concat("/shop");
        };
        
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


                        rootScope.$apply(function()
                        {
                            if(rootScope.cart === null || typeof rootScope.cart === 'undefined')
                            {
                                rootScope.cart = [];
                            }
                            
                            rootScope.cart.push(cart_item);
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
                        rootScope.$apply(function()
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
            if ('https:' === document.location.protocol && "geolocation" in navigator && !window.localStorage.getItem("longitude") && !window.localStorage.getItem("latitude")) 
            {
                navigator.geolocation.getCurrentPosition(function(position) 
                {
                    rootScope.longitude = position.coords.longitude;
                    rootScope.latitude = position.coords.latitude;
                    window.localStorage.setItem("longitude", rootScope.longitude);
                    window.localStorage.setItem("latitude", rootScope.latitude);
                });
            }
        };
        
	rootScope.promptForZipCode = function(ev) 
        {
            rootScope.longitude = window.localStorage.getItem("longitude");
            rootScope.latitude = window.localStorage.getItem("latitude");

            if(!window.localStorage.getItem("longitude") && !window.localStorage.getItem("latitude") && !rootScope.isUserLogged && false)
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
