/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

angular.module("eappApp").controller("MenuController", ["$rootScope", "$http", "$mdDialog", "eapp", function($rootScope, $http, $mdDialog, eapp) 
{
    
    $rootScope.isHome = false;
    
    $rootScope.loadPage = function(url)
    {

    };
	
    $rootScope.gotoShop = function()
    {
        window.sessionStorage.removeItem("store_id");
        window.sessionStorage.removeItem("category_id");
        window.location =  $rootScope.site_url.concat("/shop");
    };

	
}]);

