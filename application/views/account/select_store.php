<script>
$(document).ready(function(){
    
    var scope = angular.element($("#admin-container")).scope();
    
    scope.$apply(function()
    {
        scope.retailers = JSON.parse('<?php echo $retailers; ?>');
        
        if(sessionStorage.getItem("registered_email"))
        {
	    scope.registered_email = sessionStorage.getItem("registered_email");
            window.sessionStorage.removeItem("registered_email");
        }
        else
        {
            // redirect to home page
            window.location = scope.site_url.concat("/home");
        }
    });
})
</script>

<div id="admin-container" class="container" ng-controller="AccountController">    
    <div id="select-store-container" ng-include="'<?php echo base_url(); ?>/assets/templates/select-favorite-stores.html'"></div>
    <div class="form-group">
        <!-- Button -->                                        
        <div class="col-md-offset-0 col-md-3 pull-right" style="padding-top:25px;">
            <button id="btn-signup"  ng-click="submit_favorite_stores()" type="button" class="btn btn-info col-md-12"><i class="icon-hand-right"></i> &nbsp Terminer l'inscription</button>
        </div>
    </div>
</div>
    

   
        
    
    
