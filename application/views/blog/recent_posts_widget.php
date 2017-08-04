<div class="pull-right col-md-4 col-sm-4 col-xs-12">
	<div id="sidebar" class="clearfix">
		<div class="widget">
			<div id="imaginary_container"> 
				<div class="input-group stylish-input-group">
					<input type="text" class="form-control"  placeholder="Rechercher" >
					<span class="input-group-addon">
						<button type="submit">
							<span class="glyphicon glyphicon-search"></span>
						</button>  
					</span>
				</div>
			</div>
		</div><!-- end widget -->

		<div class="widget wow fadeIn">
			<div class="widget-title">
				<h3>Posts récents</h3>
			</div><!-- end widget title -->
			<div class="featured-widget">
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
		</div><!-- end widget -->
						
	</div><!-- end col -->
</div><!-- end sidebar -->
