<!DOCTYPE html>
<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>Details</h2>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End Page title area -->

<section id="blog-container" class="section-white clearfix" ng-controller="BlogController">
    <div class="container">
        <div id="blog-page" class="row clearfix">
            <div id="content" class="col-lg-8 col-md-8 col-sm-12">
                <div class="blog-item">
                    <div class="meta">
                        <span><a href="#">INFOS</a> | {{post.date}}</span>
                    </div><!-- end meta -->

                    <div class="single-blog-title">
                        <h3>{{post.name}}</h3>
                    </div><!-- end title -->
                    
                    <div class="ImageWrapper">
                        <img src="<?php echo base_url("assets/blog/img/")?>{{post.image}}" alt="" class="img-responsive">
                        <div class="ImageOverlayLi"></div>
                        <div class="Buttons StyleH">
                            <a href="#" title="Like it"><span class="bubble border-radius"><i class="fa fa-heart-o"></i> 3</span></a>
                        </div>
                    </div>

                    <div class="single-blog-desc">
                        <p>{{post.article}}</p>
                    </div><!-- end desc -->

                    <div class="blog-share text-center">
                        <div class="social-icons">
                            <span><a data-rel="tooltip" data-toggle="tooltip" data-trigger="hover" data-placement="bottom" data-title="Facebook" href="#"><i class="fa fa-facebook"></i></a></span>
                            <span><a data-rel="tooltip" data-toggle="tooltip" data-trigger="hover" data-placement="bottom" data-title="Google Plus" href="#"><i class="fa fa-google-plus"></i></a></span>
                            <span><a data-rel="tooltip" data-toggle="tooltip" data-trigger="hover" data-placement="bottom" data-title="Twitter" href="#"><i class="fa fa-twitter"></i></a></span>
                            <span><a data-rel="tooltip" data-toggle="tooltip" data-trigger="hover" data-placement="bottom" data-title="Dribbble" href="#"><i class="fa fa-dribbble"></i></a></span>
                            <span><a data-rel="tooltip" data-toggle="tooltip" data-trigger="hover" data-placement="bottom" data-title="Pinterest" href="#"><i class="fa fa-pinterest"></i></a></span>
                        </div><!-- end social icons -->
                    </div><!-- end button -->
                </div><!-- end blog -->
            </div><!-- end col -->
            {recent_posts}
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end section white -->
<!-- /#wrapper -->

<script>
	var scope = angular.element($("#blog-container")).scope;
	
	scope.$apply(function()
 	{
		scope.blog = JSON.parse('<?php echo $post; ?>');
	});
</script>
   
