<div class="pull-right col-md-4 col-sm-4 col-xs-12">
	<div id="sidebar" class="clearfix">
		<div class="widget">
			<div id="imaginary_container"> 
				<md-input-container class="md-block col-md-12" flex-gt-sm>
					<input name="searchText" ng-model="searchPostsText" />
					<md-icon><i class="material-icons">search</i></icon>
				</md-input-container>
			</div>
		</div><!-- end widget -->

		<div class="widget wow fadeIn">
			<div class="widget-title">
				<h3>Posts récents</h3>
			</div><!-- end widget title -->
			<div class="featured-widget" ng-show="recentPosts.length > 0">
				<ul ng-repeat="post in recentPosts">
					<li>
						<img src="<?php echo base_url("assets/blog/img/post/")?>{{post.image}}" alt="{{post.title}}" class="alignleft">
						<h3> <a href="#">post.title</a></h3>
						<span class="metabox">
							<a href ng-click="viewPost(post)">INFOS</a> <span>{{post.date}}</span>
						</span>
					</li>
				</ul>
			</div><!-- end featured-widget -->
			<div ng-show="recentPosts.length > 0">
				<p>Aucun article disponible.</p>
			</div>
		</div><!-- end widget -->
	</div><!-- end col -->
</div><!-- end sidebar -->
