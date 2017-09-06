<!DOCTYPE html>

<div id="home-container">

    <div id="admin-container" class="slider-area" >
        <div class="zigzag-bottom"></div>
        <div id="slide-list" class="carousel carousel-fade slide" data-ride="carousel">
            <div class="slide-bulletz">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <ol class="carousel-indicators slide-indicators">
                                <li data-target="#slide-list" data-slide-to="0" class="active"></li>
                                <li data-target="#slide-list" data-slide-to="1"></li>
                                <li data-target="#slide-list" data-slide-to="2"></li>
                            </ol>                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <div class="single-slide">
                        <div class="slide-bg slide-one"></div>
                        <div class="slide-text-wrapper">
                            <div class="slide-text">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6 col-md-offset-6">
                                            <div class="slide-content">
                                                <h2>Browse Categories</h2>
                                                <p> Use our wonderful services to browse different categories and find the different products that make up your shopping list.!</p>
                                                <p>Simple fast, reliable and up to date. Start today.</p>
                                                <a href="" class="readmore">Browse Categories</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single-slide">
                        <div class="slide-bg slide-two"></div>
                        <div class="slide-text-wrapper">
                            <div class="slide-text">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6 col-md-offset-6">
                                            <div class="slide-content">
                                                <h2>Browse Flyers</h2>
                                                <p>Every week, visit us for new flyers with amazing prices. Saving money begins with a click!</p>
                                                <a href="" class="readmore">Browse Flyers</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single-slide">
                        <div class="slide-bg slide-three"></div>
                        <div class="slide-text-wrapper">
                            <div class="slide-text">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6 col-md-offset-6">
                                            <div class="slide-content">
                                                <h2>Find Product</h2>
                                                <p>Know what you are looking for?</p>
                                                <p>In a few clicks you are ready to find the best deals.</p>
                                                <a href="" class="readmore">Find Product</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>        
    </div> <!-- End slider area -->
    
    <div class="promo-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-8">
                    <div class="single-promo">
                        
                        <h2>Votre liste d'épicerie</h2>
<!--                        <i class="fa fa-heart"></i>-->
                        <p>Créez votre liste d'épicerie et économisez sur les dépenses.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-8">
                    <div class="single-promo">
<!--                        <i class="fa fa-unlock"></i>-->
                        <h2>Les Circulaires</h2>
                        <p>Utilisez nos circulaires pour créer votre panier d'épicerie et économisez sur les dépenses</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-8">
                    <div class="single-promo">
                        <h2>Les catégories de produits</h2>
<!--                        <i class="fa fa-calendar"></i>-->
                        <p>Utilisez nos catégories de produits pour créer votre panier d'épicerie et économiser sur les dépenses.</p>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End promo area -->
    
    <div class="maincontent-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="latest-product" ng-controller="CartController">
                        <h2 class="section-title">Derniers Produits</h2>
                        <div class="product-carousel row">
                            <?php foreach($latestProducts as $product): ?>
                                <div class="single-product col-md-12 col-sm-12">
                                    <div class="product-f-image">
                                        <img ng-src="<?php echo base_url("assets/img/products/").$product->product->image;?>" style="height: 100%;" alt="">
                                        <div class="product-hover">
                                            <a href ng-show="can_add_to_cart(<?php echo $product->product_id; ?>)" class="add-to-cart-link" ng-click="add_product_to_cart(<?php echo $product->product_id; ?>)"><i class="fa fa-shopping-cart"></i>Ajouter</a>
                                            <a href ng-hide="can_add_to_cart(<?php echo $product->product_id; ?>)" class="add-to-cart-link" ng-click="remove_product_from_cart(<?php echo $product->product_id; ?>)"><i class="fa fa-shopping-cart"></i>Retirer</a>
                                            <a href="<?php echo site_url("cart/product/").$product->product_id; ?>" class="view-details-link"><i class="fa fa-link"></i>Détails</a>
                                        </div>
                                    </div>

                                    <h2 style="font-size: 14px; text-align: center;"><a href="<?php echo site_url("cart/product/").$product->product_id; ?>"><?php echo $product->product->name; ?></a></h2>

                                    <div class="product-carousel-price" ng-hide="true">
                                        <ins>CAD <?php echo $product->price; ?></ins><del>CAD <?php echo $product->regular_price; ?></del>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End main content area -->
    
    <div class="brands-area">
        <div class=""></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="brand-wrapper">
                        <h2 class="section-title">Stores</h2>
                        <div class="brand-list">
                            <?php foreach($stores as $store): ?>
                            <img src="<?php echo base_url("assets/img/stores/").$store->image; ?>" style="width: 270px; height: 120px;" width="270" height="120" alt="">    
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Stores area -->
    
    <div class="product-widget-area" ng-hide="true">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="single-product-widget">
                        <h2 class="product-wid-title">Meilleures ventes</h2>
                        <a href="" class="wid-view-more">Voir tout</a>
                        <div class="single-wid-product">
                            <a href="single-product.html"><img src="" alt="" class="product-thumb"></a>
                            <h2><a href="single-product.html">Sony Smart TV - 2015</a></h2>
                            <div class="product-wid-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <div class="product-wid-price">
                                <ins>$400.00</ins> <del>$425.00</del>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-product-widget">
                        <h2 class="product-wid-title">Vu récemment</h2>
                        <a href="#" class="wid-view-more">Voir tout</a>
                        <div class="single-wid-product">
                            <a href="single-product.html"><img src="" alt="" class="product-thumb"></a>
                            <h2><a href="single-product.html">Sony playstation microsoft</a></h2>
                            <div class="product-wid-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product-wid-price">
                                <ins>$400.00</ins> <del>$425.00</del>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-product-widget">
                        <h2 class="product-wid-title">Nouveau</h2>
                        <a href="#" class="wid-view-more">Voir tout</a>
                        <div class="single-wid-product">
                            <a href="single-product.html"><img src="" alt="" class="product-thumb"></a>
                            <h2><a href="single-product.html">Apple new i phone 6</a></h2>
                            <div class="product-wid-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product-wid-price">
                                <ins>$400.00</ins> <del>$425.00</del>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End product widget area -->
    
</div>
    
<script>
    $(document).ready(function()
    {

        var rootScope = angular.element($("html")).scope();

        rootScope.$apply(function()
        {
            rootScope.menu = "home";
        });
    });
</script>
