<!DOCTYPE html>

    <!-- page builer -->
    <section id="blog-container" class="section-white clearfix blog" ng-controller="BlogController">
        <div class="container">
            <div class="row">
                <div class="pull-left col-md-8 col-sm-8 col-xs-12">
                    <div id="blog-page" class="row clearfix">
                        <div class="col-md-12 col-sm-12 col-xs-12 wow fadeIn" ng-class="$index % 2 == 0 ? 'first' : 'last'" ng-repeat="post in RecentPosts">
                            <div class="blog-item">
                                <div class="ImageWrapper">
                                    <img src="<?php echo base_url("assets/blog/"); ?>img/posts/{{post.image}}" alt="" class="img-responsive">
                                    <div class="ImageOverlayLi"></div>
                                    <div class="Buttons StyleH">
                                        <a ng-show="canLike() && userLogged" href ng-click="like(post.id)" title="Aimer"><span class="bubble border-radius"><i class="fa fa-heart-o"></i> {{post.likes}}</span></a>
										<a ng-show="!canLike() && userLogged" href ng-click="like(post.id)" title="Pas aimer"><span class="bubble border-radius"><i class="fa fa-thumbs-down"></i></span></a>
                                        <a href="<?php echo base_url("blog/comments/")?>{{post.id}}" title="Voir Commentaires"><span class="bubble border-radius"><i class="fa fa-comment-o"></i>{{post.comments.length}}</span></a>
                                    </div>
                                </div>
                                <div class="meta">
                                    <span><a href >INFOS</a> | {{post.date | date}}</span>
                                </div><!-- end meta -->
                                <div class="blog-title">
                                    <h3><a href="<?php echo base_url("blog/view/")?>{{post.id}}" title="">{{post.title}}</a></h3>
                                </div><!-- end title -->
                                <div class="blog-desc">
                                    <p>{{post.description}}</p>
                                </div><!-- end desc -->
                                <div class="blog-button">
                                    <a href="<?php echo base_url("blog/comments/")?>{{post.id}} title="" class="btn btn-primary border-radius">Lire</a>
                                </div><!-- end button -->
                            </div><!-- end blog -->
                        </div><!-- end col -->
                    </div><!-- end blog -->

                    <nav class="text-center"> 
                        <ul class="pagination">
                            <li><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li>
                                <a href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div><!-- end pull-right -->
				
				{recent_posts}

        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end section white -->

<script>
	var scope = angular.element($("#blog-container")).scope();
	scope.$apply(function()
 	{
		scope.recentPosts = JSON.Parse('<?php echo $recentPosts; ?>');
	});
</script>

