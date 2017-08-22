<!DOCTYPE html>

<script>
    $(document).ready(function()
    {
        var scope = angular.element($("#cart-container")).scope();
        
        scope.$apply(function()
        {
            scope.getUserProductList();
            scope.optimization_preference_changed();
        });
    })
</script>
    
<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>Mon Panier</h2>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End Page title area -->

<md-content id="cart-container" class="admin-container" ng-controller="CartController">
    
    <div>
        <md-content class="eapp-container md-whiteframe-3dp">
            <fieldset>
                <md-subheader class="md-primary">Configurez votre optimization du panier</md-subheader>
                <md-radio-group class="col-md-6 col-sm-12" ng-model="viewing_cart_optimization.value" ng-change="optimization_preference_changed()">
                    <md-radio-button ng-value="true_value">Vue du panier</md-radio-button>
                    <md-radio-button ng-value="false_value">Vue par magasin</md-radio-button>
                </md-radio-group>
                <div  class="col-md-6 col-sm-12">
                    <md-radio-group ng-model="searchInMyList.value" ng-change="optimization_preference_changed()">
                        <md-radio-button ng-value="true_value" ng-disabled="!isUserLogged">Rechercher dans votre liste de magasins</md-radio-button>
                        <md-radio-button ng-value="false_value">Rechercher dans tout les magasins</md-radio-button>
                    </md-radio-group>
                </div>
                
                <div layout class="col-sm-12">
                    <div flex="15" layout layout-align="center center">
                      <span class="md-body-1">Distance : {{distance}} Km</span>
                    </div>
                    <md-slider flex class="md-primary" md-discrete ng-model="distance" step="1" min="1" max="100" aria-label="Distance">
                    </md-slider>
                    <md-button class="md-raised" ng-click="optimization_preference_changed()">Mettre à jour</md-button>
                </div>
                
            </fieldset>
    	</md-content>
    </div>

    <div id="cart-optimization-container" ng-show="viewing_cart_optimization.value">
        <!-- Cart Optimizations -->
        <md-content class="container" ng-repeat="departmentStore in departmenStores">
            
            <md-subheader class="" ng-show="departmentStore.distance > 0">
                <img alt="{{ product.name }}" ng-src="{{base_url}}/assets/img/stores/{{departmentStore.image}}" style="height : 44px;" />
                <b> {{departmentStore.address}}, {{departmentStore.city}}, {{departmentStore.state}}, {{departmentStore.postcode}}, {{departmentStore.distance}} Km en voiture (environs {{departmentStore.time | number : 0}} Minutes)</b>
            </md-subheader>
            <md-subheader class="md-warn" ng-hide="departmentStore.distance > 0">
                <img alt="{{ product.name }}" ng-src="{{base_url}}/assets/img/stores/{{departmentStore.image}}" style="height : 44px;" />
                <b> Le magasin n'est pas disponible près de chez vous.</b>
            </md-subheader>

            <md-table-container>
                <table  md-table cellspacing="0" ng-model="selected"  md-progress="promise">
                    <thead md-head md-order="query.order" md-on-reorder="update_cart_list">
                        <tr md-row ng-show="$index === 0">
                        <th md-column>&nbsp;</th>
                        <th md-column>Changer Magasin / Format</th>
                        <th md-column>Product</th>
                        <th md-column>Description du produit</th>
                        <th md-column md-numeric>Quantité</th>
                        <th md-column md-numeric>Total ($ CAD)</th>
                        <th md-column  ng-show="isUserLogged"><i class="fa fa-heart"></i></th>
                        <th md-column ng-hide="true">Coupon</th>
                    </tr>
                </thead>
                    <tbody>
                    <tr  md-row md-select="item"  md-select-id="name" class="cart_item" ng-repeat="item in departmentStore.products">

                        <td md-cell>
                            <a title="Remove this item" class="remove" href ng-click="remove_product_from_cart(item.product.id)">×</a> 
                        </td>

                        <td md-cell width = "20%">
                            <div ng-hide="true">
                                <a href><img alt="item.store_product.product.name" class="admin-image" ng-src="{{base_url}}/assets/img/stores/{{item.store_product.retailer.image}}" ></a>
                            </div>
                            <md-button class="md-raised" ng-disabled="item.different_store_products.length === 0">Changer Marchand</md-button>
                        </td>

                        <td md-cell width = "20%">
                            <a href><img alt="poster_1_up" class="admin-image" ng-src="{{base_url}}/assets/img/products/{{item.store_product.product.image}}"></a>
                        </td>

                        <td md-cell width = "25%">
                            <p><b><a href="single-product.html">{{item.store_product.product.name}}</a></b></p>
                            <p ng-show="item.store_product.size">{{item.store_product.size}}</p>
                            <p ng-show="item.store_product.brand">{{item.store_product.brand.name}}</p>
                            <div>
                                {{item.store_product.format}} {{item.store_product.unit.name}}
                                <md-button class="md-raised" ng-disabled="item.different_format_products.length === 0">Changer Format</md-button>
                            </div>
                            <p ng-show="item.store_product.state">Origine : {{item.store_product.state}}</p>
                            <p  ng-show="item.store_product.price > 0"><b><span class="amount">$ CAD {{item.store_product.price | number: 2}}</span> </b><span ng-show="item.store_product.brand"> / {{item.store_product.brand.name}}</span></p>
                        </td>

                        <td md-cell>
                            <md-input-container>
                                <input aria-label="Qty" style="width : 50px;" type="number" ng-model="item.quantity">
                            </md-input-container>
                        </td>

                        <td md-cell>
                            <span class="amount">$ CAD {{item.store_product.price * item.quantity | number : 2}} </span> 
                        </td>

                        <td md-cell ng-show="isUserLogged">
                        <md-checkbox ng-model="item.store_product.product.in_user_grocery_list" aria-label="Add to my list" ng-init="item.store_product.product.in_user_grocery_list" ng-checked="item.store_product.product.in_user_grocery_list" ng-change="favoriteChanged(item.store_product.product)">
                            </md-checkbox>
                        </td>

                        <td md-cell ng-hide="true">
                            <md-checkbox ng-model="item.apply_coupon" aria-label="Apply coupon">
                            </md-checkbox> 
                        </td>
                    </tr>
                </tbody>
                </table>
            </md-table-container>
        </md-content>
    </div>

    <div class="container" ng-cloak ng-hide="viewing_cart_optimization.value">
        <md-content>
          
            <md-tabs md-dynamic-height md-border-bottom>
              
                <md-tab label="{{store.name}} ({{store.store_products.length}} / {{cart.length}})" ng-repeat="store in stores" md-on-select="storeTabSelected(store)">
                  <md-content class="md-padding">
                      <md-subheader class="md-primary">{{store.department_store.address}}, {{store.department_store.city}}, {{store.department_store.state}}, {{store.department_store.postcode}}, {{store.department_store.distance}} Km en voiture</md-subheader>
                      <md-list-item ng-repeat="product in store.store_products" class="noright">
                          <img alt="{{ product.name }}" ng-src="{{base_url}}/assets/img/products/{{ product.product.image }}" class="md-avatar" />
                          <p>{{ product.product.name }}, <span ng-show="product.brand">, Marque : {{product.brand.name}}</span> <span ng-show="product.format">, Format : {{product.format}}</span> </p>
                          <md-input-container class="md-secondary">
                              <p><b>$ CAD {{product.price}} <span ng-show="product.unit"> / {{product.unit.name}}</span></b></p>
                          </md-input-container>
                      </md-list-item>
                      
                      <md-subheader class="md-warn">Produits indisponibles</md-subheader>
                      <md-list-item ng-repeat="item in store.missing_products" class="noright">
                          <img alt="{{ item.store_product.product.name }}" ng-src="{{base_url}}/assets/img/products/{{ item.store_product.product.image }}" class="md-avatar" />
                          
                          <p>{{ item.store_product.product.name }}, <span ng-show="item.store_product.brand">, Marque : {{item.store_product.brand.name}}</span> <span ng-show="item.store_product.format">, Format : {{item.store_product.format}}</span> </p>
                          <img  alt="{{ product.name }}" ng-src="{{base_url}}/assets/img/stores/{{item.store_product.retailer.image }}" class="md-secondary md-avatar" />
                          <md-input-container class="md-secondary">
                              <p><b>$ CAD {{item.store_product.price}} <span ng-show="item.store_product.unit"> / {{item.store_product.unit.name}}</span></b></p>
                          </md-input-container>
                          
                      </md-list-item>
                  </md-content>
              </md-tab>
            </md-tabs>
        </md-content>
    </div>

    <div>
        <div class="eapp-container container">

            <div class="cart_totals ">
                <h2>Détails d'optimisation</h2>

                <table>
                    <tbody>
                        <tr class="cart-subtotal">
                            <th>Total du panier</th>
                            <td><span class="amount md-warn"><b>$ CAD {{get_cart_total_price() | number : 2}}</b></span></td>
                        </tr>
			
                        <tr class="optimized-distance" ng-show="price_optimization > 0">
                            <th>Montant épargné</th>
                            <td><span class="amount"><b style="color : red"><b> $ CAD {{price_optimization | number : 2}} </b></span></td>
                        </tr>

                    </tbody>
                </table>
				
                <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>

                    <md-button class="md-fab md-warn"  ng-click="clearCart()" aria-label="Effacer votre panier">
                        <md-icon><i class="material-icons">clear_all</i></md-icon>
                    </md-button>
                    <md-button class="md-fab md-primary" aria-label="Impression" ng-click="printCart()">
                            <md-icon style="color: #1abc9c;"><i class="material-icons">print</i></md-icon>
                    </md-button>

                    <md-button class="md-fab md-primary" ng-click="sendListAsSMS($event)" aria-label="Envoyer à votre téléphone">
                      <md-icon style="color: #1abc9c;"><i class="material-icons">send</i></md-icon>
                    </md-button>

                    <md-button class="md-fab md-primary" aria-label="Partager">
                            <md-icon style="color: #1abc9c;"><i class="material-icons">share</i></md-icon>
                    </md-button>

                    <md-button class="md-fab md-primary" aria-label="Envoyer à votre courrier électronique">
                            <md-icon style="color: #1abc9c;"><i class="material-icons">email</i></md-icon>
                    </md-button>

                </section>
				
            </div>
        </div>
    </div>
</md-content>



    
        
    




