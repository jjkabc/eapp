<!DOCTYPE html>
<html lang="en" ng-app="eappApp">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{title}</title>
    
     <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBdUBJq3Y93iEd29Q6GAK5SHQJniqZiHu0"></script> 
     <!-- Angular Material style sheet -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.4/angular-material.min.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/lf-ng-md-file-input.css")?>">
      
    <!-- Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,100' rel='stylesheet' type='text/css'>
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap-slider.css")?>">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo base_url("assets/css/owl.carousel.css")?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/style.css")?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/responsive.css")?>">
    <!-- Admin CSS -->
    <link rel="stylesheet" href="<?php echo base_url("assets/css/admin.css")?>">
    <!-- International Phone numbers CSS CSS -->
    <link rel="stylesheet" href="<?php echo base_url("assets/css/intlTelInput.css")?>">
    
    <!-- Animate CSS -->
    <link rel="stylesheet" href="<?php echo base_url("assets/css/animate.css")?>">
    <!-- ngNotificationsBar CSS -->
    <link rel="stylesheet" href="<?php echo base_url("assets/css/ngNotificationsBar.min.css")?>">
    <!-- Bootstrap Select CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
    <!-- MD Table CSS -->
    <link rel="stylesheet" href="<?php echo base_url("assets/css/md-data-table.css")?>">
    
    {css}
    
    <!-- JS Scripts -->
	 
	<!-- Latest jQuery form server -->
    <script src="https://code.jquery.com/jquery.min.js"></script>
	  
	<!-- Angular Material requires Angular.js Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-animate.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-aria.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-messages.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.min.js"></script>
    <script src="<?php echo base_url("assets/js/lf-ng-md-file-input.js")?>"></script>

    <!-- Angular Material Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.4/angular-material.min.js"></script>  
        
    
    <!-- Bootstrap JS form CDN -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url("assets/js/bootstrap-slider.min.js")?>"></script>
    
    <!-- jQuery sticky menu -->
    <script src="<?php echo base_url("assets/js/owl.carousel.min.js")?>"></script>
    <script src="<?php echo base_url("assets/js/jquery.sticky.js")?>"></script>
    
    <!-- jQuery easing -->
    <script src="<?php echo base_url("assets/js/jquery.easing.1.3.min.js")?>"></script>
    
    <!-- Angular JS Country/State Select -->
    <script src="<?php echo base_url("assets/js/md-country-select.js")?>"></script>
    
    <!-- Angular JS Country/State Select -->
    <script src="<?php echo base_url("assets/js/angular-country-state.js")?>"></script>
    
    <!-- Main Script -->
    <script src="<?php echo base_url("assets/js/main-controller.js")?>"></script>
    
    <!-- Admin Script -->
    <script src="<?php echo base_url("assets/js/admin.js")?>"></script>
    
    <!-- Menu Controller Script -->
    <script src="<?php echo base_url("assets/js/menu-controller.js")?>"></script>
    
    <!-- Cart Controller Script -->
    <script src="<?php echo base_url("assets/js/cart-controller.js")?>"></script>
    
    <!-- Shop Controller Script -->
    <script src="<?php echo base_url("assets/js/shop-controller.js")?>"></script>
	  
	<!-- Blog Controller Script -->
    <script src="<?php echo base_url("assets/js/blog-controller.js")?>"></script> 
    
    <!-- ngNotificationsBar Script -->
    <script src="<?php echo base_url("assets/js/ngNotificationsBar.min.js")?>"></script>
    
    <!-- File Styles Script -->
    <script src="<?php echo base_url("assets/js/bootstrap-filestyle.js")?>"></script>
    
    <!-- Bootstrap Select Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    
    <!-- International Phone Number Angular Module -->
    <script src="<?php echo base_url("assets/js/utils.js")?>"></script>
    <script src="<?php echo base_url("assets/js/intlTelInput.js")?>"></script>
    <script src="<?php echo base_url("assets/js/md-data-table.js")?>"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
     <!-- Initialize angular root scope -->
    <script>
		$(document).ready(function()
		{
			var rootScope = angular.element($("html")).scope();

			rootScope.$apply(function()
			{
				
				
				rootScope.base_url = "<?php echo $base_url; ?>";
				rootScope.site_url = "<?php echo $site_url; ?>";
				rootScope.controller = "<?php echo $controller; ?>";
				rootScope.method = "<?php echo $method; ?>";
				rootScope.hit = function(table_name, id)
				{
					var formData = new FormData();
					formData.append("table_name", table_name);
					formData.append("id", id);
					
					$.post(rootScope.site_url.concat("admin/hit"), {table_name : table_name, id : id});
				};
				rootScope.longitude = 0;
				rootScope.latitude = 0;
				rootScope.cart = [];
				rootScope.is_loading = false;
				rootScope.valid = true;
				rootScope.success_message = "";
				rootScope.error_message = "";
				var user = '<?php echo $user; ?>';
				if(user === "" || user == "null")
				{
					rootScope.loggedUser = null;
				}
				else
				{
					rootScope.loggedUser = JSON.parse(user);
				}

				rootScope.hideSearchArea = (rootScope.controller == "account" && (rootScope.method == "login" || rootScope.method == "register"));

				rootScope.isUserLogged = rootScope.loggedUser !== null;

				// THis is called for a non logged user to prompt for his zip code
				// If that's not already the case. 
				if(typeof rootScope.promptForZipCode !== "undefined")
				{
					rootScope.promptForZipCode();
				}
			});
		});
    </script>
  </head>
  <body>
    <notifications-bar class="notifications"></notifications-bar>

    <div class="container search-box" id="search-box" ng-controller="ShopController" ng-hide="hideSearchArea" style="margin-top: 60px;">
        <div class="row">
            <form ng-submit="searchProducts(searchText)" class="col-md-12 col-sm-12">
                <div class="row">
                    <md-input-container class="col-md-12 col-sm-12">
                        <label>Rechercher articles</label>
                        <input name="searchText" ng-model="searchText" aria-label="Search" />
                        <md-icon><i class="material-icons">search</i></icon>
                    </md-input-container>
                </div>
            </form>
            
        </div>
    </div>
    
    <div id="mainmenu-area" class="mainmenu-area" class="navbar-wrapper">
        <div class="container-fluid">
            <nav class="navbar navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"><img src="<?php echo base_url("assets/img/logo.png"); ?>" class="eapp-logo" /></a>
                    </div>
                    
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav"  ng-controller="MenuController">
                            
                            <li class=" dropdown" ng-show="loggedUser.subscription > 0">
                                <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li ng-show="loggedUser.subscription == 2"><a  href="<?php echo addslashes(site_url("admin/uploads")); ?>">Uploads</a></li>
                                    <li><a href="<?php echo addslashes(site_url("admin/create_store_product")); ?>">Create Product</a></li>
                                    <li><a href="<?php echo addslashes(site_url("admin/store_products")); ?>">View Products</a></li>
                                </ul>
                            </li>
                            
                            <li class="active"><a href="<?php echo site_url("home"); ?>" class="">Accueil</a></li>
                            
                            <li class=" dropdown">
                                <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Réduisez vos dépenses<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo site_url("account/my_grocery_list"); ?>">Votre liste d'épicerie</a></li>
                                    <li><a href="<?php echo site_url("shop/select_flyer_store"); ?>">Les circulaires des magasins</a></li>
                                    <li><a href="<?php echo site_url("shop/categories"); ?>">Les catégories de produits</a></li>
                                </ul>
                            </li>
                            <li><a href ng-click="gotoShop()">Trouvez un produit</a></li>
                            <li><a href="<?php echo site_url("cart"); ?>">Votre panier</a></li>
                            <li class=" dropdown"><a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Blogue<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo site_url("blog/press_release"); ?>">Épicerie dans la presse</a></li>
                                    <li><a href="<?php echo site_url("blog/stats"); ?>">STAT</a></li>
                                    <li><a href="<?php echo site_url("blog/videos"); ?>">Vidéo</a></li>
                                    <!--<li><a href="<?php echo site_url("home/store_policy"); ?>">Politiques des magasins</a></li>-->
                                    <li><a href="<?php echo site_url("home/about_us"); ?>">À propos</a></li>
                                </ul>
                            </li>
                            <li class=" dropdown"><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Contact <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo site_url("home/contact"); ?>">Formulaire</a></li>
                                </ul>
                            </li>

                        </ul>
                        <ul class="nav navbar-nav pull-right"  ng-controller="AccountController">
                            <li ng-hide="isUserLogged"><a href="<?php echo site_url("account/login"); ?>"><i class="fa fa-user"></i>s'identifier</a></li>
                            <li ng-hide="isUserLogged"><a href="<?php echo site_url("account/register"); ?>"><i class="fa fa-user"></i>créer un compte</a></li>
                            <li ng-show="isUserLogged" class=" dropdown"><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Bonjour <span ng-show="loggedUser.profile.firstname">{{loggedUser.profile.firstname}},</span> {{loggedUser.profile.lastname}}  <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a  href="<?php echo site_url("account/account"); ?>"><i class="fa fa-user"></i>Mon compte</a></li>
                                    <li><a href="#"><i class="fa fa-heart"></i>Ma liste d'épicerie</a></li>
                                    <li><a href ng-click="logout()">Logout</a></li>
                                </ul>
                            </li>
                            
                            <li>
                                <a href="<?php echo site_url("cart"); ?>" class="md-icon-button" aria-label="Cart">
                                    <md-icon style="color: #1abc9c;"><i class="material-icons">shopping_cart</i> </md-icon>
                                    <span class="badge"  style="background-color: #1abc9c; color : #333;" ng-show="get_cart_item_total() > 0">{{get_cart_item_total()}} | CAD {{get_cart_total_price() | number : 2}}</span>
                                </a>
                                
                            </li>
                        </ul>
                    </div>
            </div>
        </nav>
    </div>
</div>
	  
    <!-- End mainmenu area -->
    <div id="main-body">	
    	{body}
    </div>

    <div class="footer-top-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="footer-about-us">
                        <h2>e<span>Electronics</span></h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis sunt id doloribus vero quam laborum quas alias dolores blanditiis iusto consequatur, modi aliquid eveniet eligendi iure eaque ipsam iste, pariatur omnis sint! Suscipit, debitis, quisquam. Laborum commodi veritatis magni at?</p>
                        <div class="footer-social">
                            <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                            <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                            <a href="#" target="_blank"><i class="fa fa-youtube"></i></a>
                            <a href="#" target="_blank"><i class="fa fa-linkedin"></i></a>
                            <a href="#" target="_blank"><i class="fa fa-pinterest"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu">
                        <h2 class="footer-wid-title">User Navigation </h2>
                        <ul>
                            <li><a href="#">My account</a></li>
                            <li><a href="#">Order history</a></li>
                            <li><a href="#">Wishlist</a></li>
                            <li><a href="#">Vendor contact</a></li>
                            <li><a href="#">Front page</a></li>
                        </ul>                        
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu">
                        <h2 class="footer-wid-title">Categories</h2>
                        <ul>
                            <li><a href="#">Mobile Phone</a></li>
                            <li><a href="#">Home accesseries</a></li>
                            <li><a href="#">LED TV</a></li>
                            <li><a href="#">Computer</a></li>
                            <li><a href="#">Gadets</a></li>
                        </ul>                        
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="footer-newsletter">
                        <h2 class="footer-wid-title">Newsletter</h2>
                        <p>Sign up to our newsletter and get exclusive deals you wont find anywhere else straight to your inbox!</p>
                        <div class="newsletter-form">
                            <form action="#">
                                <input type="email" placeholder="Type your email">
                                <input type="submit" value="Subscribe">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End footer top area -->
    
    <div class="footer-bottom-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="copyright">
                        <p>&copy; 2015 eElectronics. All Rights Reserved. Coded with <i class="fa fa-heart"></i> by <a href="http://wpexpand.com" target="_blank">WP Expand</a></p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="footer-card-icon">
                        <i class="fa fa-cc-discover"></i>
                        <i class="fa fa-cc-mastercard"></i>
                        <i class="fa fa-cc-paypal"></i>
                        <i class="fa fa-cc-visa"></i>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End footer bottom area -->
   {scripts}
  </body>
</html>
