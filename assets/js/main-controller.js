jQuery(document).ready(function($){
    
    
    
    $('.product-carousel').owlCarousel({
        loop:true,
        nav:true,
        autoplay:true,
        autoplayTimeout: 1000,
        autoplayHoverPause:true,
        margin:0,
        responsiveClass:true,
        
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:6
            }
        }
    });  
        
    $('.brand-list').owlCarousel({
        loop:true,
        nav:true,
        margin:20,
        responsiveClass:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:4
            },
            1000:{
                items:6
            }
        }
    });    
       
});

function convert_to_string_date(date)
{
    return date.getFullYear().toString() + "-" + date.getMonth().toString() + "-" + date.getDate().toString();
}

angular.isNullOrUndefined = function(value)
{
    return angular.isUndefined(value) || value === null;
};

// Define the `eapp Application` module
var eappApp = angular.module('eappApp', ['ngMaterial', 'md.data.table', 'lfNgMdFileInput', 'ngMessages', 'ngSanitize', 'mdCountrySelect', 'ngNotificationsBar', 'ngRoute', 'ngAnimate', 'angularCountryState']);

// Create eapp service to get and update our data
eappApp.factory('eapp', ['$http','$rootScope', function($http, $rootScope)
{
    var eappService = {};
    
    eappService.getProduct = function(productId)
    {
        return $http.post(eappService.getSiteUrl().concat("cart/get_product/").concat(productId.toString()), null);
    };
    
    eappService.getSiteUrl = function()
    {
        var siteName = window.location.hostname.toString();
        
        if(siteName == "localhost")
        {
            siteName = siteName.concat("/eapp/");
        }
        
        return "http://" + siteName + "/index.php/";
    };
    
    
    eappService.siteUrl = function()
    {
        return $http.post(eappService.getSiteUrl().concat("eapp/site_url"), null);
    };
    
    eappService.baseUrl = function()
    {
        return $http.post(eappService.getSiteUrl().concat("eapp/base_url"), null);
    };
    
    eappService.getRetailers = function()
    {
        return $http.post(eappService.getSiteUrl().concat("eapp/get_retailers"), null);
    };
    
    eappService.getLatestProducts = function()
    {
        return $http.post(eappService.getSiteUrl().concat("cart/get_latest_products"), null);
    };
    
    eappService.getCategoryProducts = function(id, query)
    {
        var formData = new FormData();
        formData.append("page", query.page);
        formData.append("limit", query.limit);
        formData.append("filter", query.filter);
        formData.append("order", query.order);
        
        if(!angular.isNullOrUndefined(id))
        {
            formData.append("category_id", id);
        }
        
        return $http.post(eappService.getSiteUrl().concat("/shop/get_store_products"), formData, { transformRequest: angular.identity, headers: {'Content-Type': undefined}});

    };
    
    eappService.getFlyerProducts = function(id, query)
    {
        var formData = new FormData();
        formData.append("page", query.page);
        formData.append("limit", query.limit);
        formData.append("filter", query.filter);
        formData.append("order", query.order);
        
        if(!angular.isNullOrUndefined(id))
        {
            formData.append("store_id", id);
        }
        
        return $http.post(eappService.getSiteUrl().concat("/shop/get_store_products"), formData, { transformRequest: angular.identity, headers: {'Content-Type': undefined}});

    };
    
    eappService.getStoreProducts = function(query)
    {
        var formData = new FormData();
        formData.append("page", query.page);
        formData.append("limit", query.limit);
        formData.append("filter", query.filter);
        formData.append("order", query.order);
        
        return $http.post(eappService.getSiteUrl().concat("/shop/get_store_products"), formData, { transformRequest: angular.identity, headers: {'Content-Type': undefined}});

    };
    
    eappService.addProductToList = function(product)
    {
        var formData = new FormData();
        formData.append("product_id", product.id);
        
        return $http.post(eappService.getSiteUrl().concat("/eapp/add_product_to_list"), formData, { transformRequest: angular.identity, headers: {'Content-Type': undefined}});
    };
    
    eappService.removeProductFromList = function(product)
    {
        var formData = new FormData();
        formData.append("product_id", product.id);
        
        return $http.post(eappService.getSiteUrl().concat("/eapp/remove_product_from_list"), formData, { transformRequest: angular.identity, headers: {'Content-Type': undefined}});
    };
    
    eappService.getCart = function()
    {
        return $http.post(eappService.getSiteUrl().concat("eapp/get_cart_contents"), null);
    };
    
    eappService.removeFromCart = function(rowid)
    {
        var formData = new FormData();
        formData.append("rowid", rowid);
        
        return $http.post(eappService.getSiteUrl().concat("cart/remove"), formData, { transformRequest: angular.identity, headers: {'Content-Type': undefined}});
    };
    
    eappService.clearCart = function()
    {
        return $http.post(eappService.getSiteUrl().concat("cart/destroy"), null);
    };
    
    eappService.changeDistance = function(distToChange, newValue)
    {
        var formData = new FormData();
        formData.append("distance_to_change", distToChange);
        formData.append("value", newValue);
        return $http.post(eappService.getSiteUrl().concat("eapp/change_distance"), formData, { transformRequest: angular.identity, headers: {'Content-Type': undefined}});
    };
    
    eappService.getCategories = function()
    {
        return $http.post(eappService.getSiteUrl().concat("eapp/get_categories"), null);  
    };
    
    eappService.getCloseRetailers = function(distance)
    {
        var formData = new FormData();
        formData.append("distance", distance);
        formData.append("longitude", $rootScope.longitude);
        formData.append("latitude", $rootScope.latitude);
        
        return $http.post(eappService.getSiteUrl().concat("eapp/get_close_retailers"), formData, { transformRequest: angular.identity, headers: {'Content-Type': undefined}});
    };
    
    eappService.recordHit = function(tableName, id)
    {
        var formData = new FormData();
        formData.append("table_name", tableName);
        formData.append("id", id);
        return $http.post(eappService.getSiteUrl().concat("admin/hit"), formData, { transformRequest: angular.identity, headers: {'Content-Type': undefined}});
    };
    
    eappService.saveFavoriteStores = function(favoriteStores)
    {
        var formData = new FormData();
        formData.append("selected_retailers", favoriteStores);
        return $http.post(eappService.getSiteUrl().concat("account/save_favorite_stores"), formData, { transformRequest: angular.identity, headers: {'Content-Type': undefined}});
    };
    
    eappService.getFavoriteStores = function()
    {
        return $http.post(eappService.getSiteUrl().concat("account/get_favorite_stores"), null);
    };
    
    eappService.updateUserProfile = function(userObject)
    {
        var formData = new FormData();
        formData.append("profile[firstname]", userObject.profile.firstname);
        formData.append("profile[lastname]", userObject.profile.lastname);
        formData.append("profile[country]", userObject.profile.country);
        formData.append("profile[state]", userObject.profile.state);
        formData.append("profile[city]", userObject.profile.city);
        formData.append("profile[address]", userObject.profile.address);
        formData.append("profile[postcode]", userObject.profile.postcode);
        
        return $http.post(eappService.getSiteUrl().concat("account/save_profile"), formData, { transformRequest: angular.identity, headers: {'Content-Type': undefined}});

    };
    
    eappService.registerUser = function(user)
    {
        // Create form data
        var formData = new FormData();
        formData.append("account[email]", user.email);
        formData.append("account[password]", user.password);
        formData.append("account[security_question_id]", user.security_question_id);
        formData.append("account[security_question_answer]", user.security_question_answer);

        formData.append("profile[firstname]", user.firstname);
        formData.append("profile[lastname]", user.lastname);
        formData.append("profile[country]", user.country);
        formData.append("profile[state]", user.state);
        formData.append("profile[city]", user.city);
        formData.append("profile[address]", user.address);
        formData.append("profile[postcode]", user.postcode);
        
        return $http.post(eappService.getSiteUrl().concat("account/registration"), formData, { transformRequest: angular.identity, headers: {'Content-Type': undefined}});

    };
    
    eappService.getSecurityQuestions = function()
    {
        return $http.post(eappService.getSiteUrl().concat("eapp/get_security_questions"), null);
    };
    
    eappService.sendPasswordReset = function(email)
    {
        var formData = new FormData();
        formData.append("email", email);
        
        return $http.post(eappService.getSiteUrl().concat("account/send_password_reset"), formData, { transformRequest: angular.identity, headers: {'Content-Type': undefined}});
    };
    
    eappService.resetPassword = function(password, reset_token)
    {
        var formData = new FormData();
        formData.append("password", password);
        formData.append("reset_token", reset_token);
        return $http.post(eappService.getSiteUrl().concat("account/modify_password"), formData, { transformRequest: angular.identity, headers: {'Content-Type': undefined}});

    };
        

    return eappService;
}]);

eappApp.directive('equals', function() {
  return {
    restrict: 'A', // only activate on element attribute
    require: '?ngModel', // get a hold of NgModelController
    link: function(scope, elem, attrs, ngModel) {
      if(!ngModel) return; // do nothing if no ng-model

      // watch own value and re-validate on change
      scope.$watch(attrs.ngModel, function() {
        validate();
      });

      // observe the other value and re-validate on change
      attrs.$observe('equals', function (val) {
        validate();
      });

      var validate = function() {
        // values
        var val1 = ngModel.$viewValue;
        var val2 = attrs.equals;

        // set validity
        ngModel.$setValidity('equals', ! val1 || ! val2 || val1 === val2);
      };
    }
  };
});

eappApp.filter('trustUrl', function ($sce) {
    return function(url) {
      var trustedurl =  $sce.trustAsResourceUrl(url);
      
      return trustedurl;
    };
});

eappApp.factory('Form', [ '$http', 'notifications', function($http, notifications) 
{
    this.postForm = function (formData, url, redirect_url) 
    {       
        $http({
            url: url,
            method: 'POST',
            data: formData,
            //assign content-type as undefined, the browser
            //will assign the correct boundary for us
            headers: { 'Content-Type': undefined},
            //prevents serializing payload.  don't do it.
            transformRequest: angular.identity
        }).
        then(
        function successCallback(response) 
        {
            
            if(response.data.success)
            {
                if(redirect_url != null)
                {
                    window.location.href = redirect_url;
                }
                
                notifications.showSuccess(response.data.message);
            }
            else
            {
                notifications.showError(response.data.message);
            }
            
        }, 
        function errorCallback(response) 
        {
            notifications.showError("An unexpected server error occured. Please try again later. ");
        });
    };
    
    return this;
}]);

eappApp.controller('ProductsController', ['$scope','$rootScope', function($scope, $rootScope) {
  
    /**
     * This are the products displayed on the home page. The most recent products.
     */
    $scope.products = [];
    
    /**
     * Products currently in the cart
     */
    $scope.cart_items = [];
    
    $scope.add_to_cart = function(product_id)
    {
        
    };
    
    $scope.remove_to_cart = function(product_id)
    {
        
    };
    
    $scope.cart_total = function()
    {
        
    };
  
}]);

eappApp.controller('HomeController', ["$scope", "$http", function($scope, $http) 
{
    $scope.contact = 
    {
        name : "",
        email : "",
        subject : "",
        comment : ""
    };
    
    $scope.contactus = function()
    {
        if($scope.contactusForm.$valid)
        {
            var formData = new FormData();
            formData.append("name", $scope.contact.name);
            formData.append("email", $scope.contact.email);
            formData.append("subject", $scope.contact.subject);
            formData.append("comment", $scope.contact.comment);

            $http.post( $scope.site_url.concat("/home/contactus"), formData, {
                    transformRequest: angular.identity,
                    headers: {'Content-Type': undefined}
            }).then(function(response)
            {
                if(response.data.result)
                {
                    $scope.message = "Votre message a bien été envoyé.";
                    $scope.contact = 
                    {
                        name : "",
                        email : "",
                        subject : "",
                        comment : ""
                    };
                    $scope.contactusForm.$setPristine();
                    $scope.contactusForm.$setValidity();
                    $scope.contactusForm.$setUntouched();
                }
                else
                {
                    $scope.errorMessage = "Une erreur de serveur inattendue s'est produite. Veuillez réessayer plus tard.";
                }

            });
        }        
    };
}]);




