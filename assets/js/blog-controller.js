/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

angular.module("eappApp").controller("BlogController", ["$scope", "$http", function($scope, $http) 
{
	
	/*
	* This function increments the number of likes for a given post
	* for a given user. 
	*/
	$scope.like = function(post_id)
	{
		var formdata = new FormData();
		formdata.append("post_id", post_id);
		
		$http.post( $scope.site_url.concat("/blog/like"), 
		formdata, { transformRequest: angular.identity, headers: {'Content-Type': undefined}}).then(
		function(response)
		{
			var likes = response.data.likes;
			$scope.RecentPosts[post_id].likes = likes;
		});
	};
	
	$scope.dislike = function(post_id)
	{
		var formdata = new FormData();
		formdata.append("post_id", post_id);
		
		$http.post( $scope.site_url.concat("/blog/dislike"), 
		formdata, { transformRequest: angular.identity, headers: {'Content-Type': undefined}}).then(
		function(response)
		{
			var likes = response.data.likes;
			$scope.RecentPosts[post_id].likes = likes;
		});
	};
	
	$scope.canLike(post_id)
	{
		for(var i in $scope.RecentPosts[post_id].likes)
		{
			var like = $scope.RecentPosts[post_id].likes[i];
			
			if(parseInt(like.user_account_id) === parseInt(loggedUser.id))
			{
				return false;
			}
		}
		
		return true;
	}
	
	
}]);
