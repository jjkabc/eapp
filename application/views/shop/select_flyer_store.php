<script>
$(document).ready(function(){
    
    var scope = angular.element($("#admin-container")).scope();
    
    scope.$apply(function()
    {
        scope.retailers = JSON.parse('<?php echo $retailers; ?>');
    });
})
</script>

<!-- Main Script -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!-- Animate CSS -->
<link rel="stylesheet" href="<?php echo base_url("assets/css/shop.css")?>">

<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>Circulaires</h2>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End Page title area -->

<div id="admin-container" class="container" ng-controller="ShopController">    

        <div id="signupbox" style=" margin-top:50px" class="container">
	    <div class="panel panel-info">
                
                <md-toolbar style="background-color: #1abc9c;">
                    <div>
                        <h2 class="md-toolbar-tools">Sélectionnez le magasin pour afficher le contenu du circulaire</h2>
                    </div>
                </md-toolbar>
		  
		<md-content id="retailer-contents" style="padding : 10px;">
                    <div class="form-group-inline" ng-repeat="store in retailers">
                        <div class="col-md-3 col-sm-4" style="height: 160px;">
                            <a href><img  ng-click="select_retailer($event)" id="{{store.id}}" ng-src="<?php echo base_url("assets/img/stores/"); ?>{{store.image}}" alt="{{store.name}}" style="height: 80px; display: block; margin: 0 auto;" class="img-thumbnail img-check"></a>
                            <input type="checkbox" name="store_{{store.id}}" value="{{store.id}}" class="hidden" autocomplete="off">
                            <a href ng-click="select_retailer($event)" id="{{store.id}}">
                            <p class="md-otiprix-text" style="text-align: center;">{{store.department_store.address}}, {{store.department_store.city}}</p>
                            <p class="md-otiprix-text" style="text-align: center;"><span ng-show="store.department_store.state">{{store.department_store.state}},</span> <span ng-show="store.department_store.postcode">{{store.department_store.postcode}}</span></p>
                            </a>
                        </div>
                    </div>
                </md-content>
	    </div>
         </div> 
    </div>
    
   
        
    
    
