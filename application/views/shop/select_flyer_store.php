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
                        <div class="col-md-2 col-sm-4" style="padding-top:25px;">
                            <label class="btn item-block">
                                <md-tooltip md-direction="top">{{store.name}}</md-tooltip>
                                <img  ng-click="select_retailer($event)" id="{{store.id}}" ng-src="<?php echo base_url("assets/img/stores/"); ?>{{store.image}}" alt="{{store.name}}" class="img-thumbnail img-check">
                                <input type="checkbox" name="store_{{store.id}}" value="{{store.id}}" class="hidden" autocomplete="off">
                            </label>
                        </div>
                    </div>
                </md-content>
	    </div>
         </div> 
    </div>
    
   
        
    
    
