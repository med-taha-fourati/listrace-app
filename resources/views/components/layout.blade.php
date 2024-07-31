<!doctype html>
<html class="no-js" lang="en">

    <head>
        <!-- meta data -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <!--font-family-->
		<link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        
        <!-- title of site -->
        <title>Directory Landing Page</title>

        <!-- For favicon png -->
		<link rel="shortcut icon" type="image/icon" href="{{ asset('assets/logo/favicon.png') }}"/>
       
        <!--font-awesome.min.css-->
        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">

        <!--linear icon css-->
		<link rel="stylesheet" href="{{ asset('assets/css/linearicons.css') }}">

		<!--animate.css-->
        <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">

		<!--flaticon.css-->
        <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">

		<!--slick.css-->
        <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/css/slick-theme.css') }}">
		
        <!--bootstrap.min.css-->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
		
		<!-- bootsnav -->
		<link rel="stylesheet" href="{{ asset('assets/css/bootsnav.css') }}" >	
        
        <!--style.css-->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        
        <!--responsive.css-->
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		
        <!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>
        <!--header-top start -->
		<header id="header-top" class="header-top">
			<ul>
				<li>
					<div class="header-top-left">
						<ul>
							<li class="select-opt">
								<select name="language" id="language">
									<option value="default">EN</option>
									<option value="Bangla">BN</option>
									<option value="Arabic">AB</option>
								</select>
							</li>
							<li class="select-opt">
								<select name="currency" id="currency">
									<option value="usd">USD</option>
									<option value="euro">Euro</option>
									<option value="bdt">BDT</option>
								</select>
							</li>
							<li class="select-opt">
								<a href="#"><span class="lnr lnr-magnifier"></span></a>
							</li>
						</ul>
					</div>
				</li>
				<li class="head-responsive-right pull-right">
					<div class="header-top-right">
						<ul>
							<li class="header-top-contact">
								+1 222 777 6565
							</li>
							@guest
								<li class="header-top-contact">
									<a href="{{ route('auth.login') }}">sign in</a>
								</li>
								<li class="header-top-contact">
									<a href="{{ route('auth.create') }}">register</a>
								</li>
							@endguest
							@auth
								<li class="header-top-contact">
									<form action="{{ route('auth.logout') }}" method="post">
										@csrf
										@method('POST')
										<button type="submit">Logout</button>
									</form>
								</li>
								<li class="header-top-contact">
									<a href="{{ route('auth.profile') }}">{{ auth()->user()->name }}</a>
								</li>
								@if (auth()->user()->admin_id != null) 
									<li class="header-top-contact">
										<a href="{{ route('admin.panel') }}">Admin Panel</a>
									</li>
								@endif
							@endauth
						</ul>
					</div>
				</li>
			</ul>
					
		</header><!--/.header-top-->
		<!--header-top end -->

		<!-- top-area Start -->
		<section class="top-area">
			<div class="header-area">
				@if (session('success'))
    				<div class="alert alert-success">
       					{{ session('success') }}
    				</div>
				@elseif (session('error'))
    				<div class="alert alert-danger">
        				{{ session('error') }}
    				</div>
				@endif
				<!-- Start Navigation -->
			    <nav class="navbar navbar-default bootsnav  navbar-sticky navbar-scrollspy"  data-minus-value-desktop="70" data-minus-value-mobile="55" data-speed="1000">

			        <div class="container">

			            <!-- Start Header Navigation -->
			            <div class="navbar-header">
			                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
			                    <i class="fa fa-bars"></i>
			                </button>
			                <a class="navbar-brand" href="{{ route('main.homepage') }}">list<span>race</span></a>

			            </div><!--/.navbar-header-->
			            <!-- End Header Navigation -->

			            <!-- Collect the nav links, forms, and other content for toggling -->
			            <div class="collapse navbar-collapse menu-ui-design" id="navbar-menu">
			                <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
								@if (Request::routeIs('admin.*'))
			                    	<li><a href="{{ route('admin.panel') }}">commands</a></li>
									<li><a href="{{ route('admin.add-entry') }}">add entry</a></li>
									<li><a href="{{ route('admin.index') }}">make admin</a></li>
									<li><a href="{{ route('admin.delete-entry') }}">entry list</a></li>
								@endif
								@if (Request::routeIs('main.*'))
			                    	<li class="scroll"><a href="#works">how it works</a></li>
			                    	<li class="scroll"><a href="#explore">explore</a></li>
			                    	<li class="scroll"><a href="#reviews">review</a></li>
			                    	<li class="scroll"><a href="#blog">blog</a></li>
			                    	<li class="scroll"><a href="#contact">contact</a></li>
			                	@endif
								@if (Request::routeIs('auth.*'))
									<li><a href="{{ route('auth.profile') }}">likes</a></li>
									<li><a href="{{ route('auth.posts') }}">posts</a></li>
									<li><a href="{{ route('auth.commands') }}">commands</a></li>
									<li><a href="{{ route('auth.comments') }}">comments</a></li>
								@endif
							</ul><!--/.nav -->
			            </div><!-- /.navbar-collapse -->
			        </div><!--/.container-->
			    </nav><!--/nav-->
			    <!-- End Navigation -->
			</div><!--/.header-area-->
		    <div class="clearfix"></div>

		</section><!-- /.top-area-->
		<!-- top-area End -->

        @yield('content')

        <!--footer start-->
		<footer id="footer"  class="footer">
			<div class="container">
				<div class="footer-menu">
		           	<div class="row">
			           	<div class="col-sm-3">
			           		 <div class="navbar-header">
				                <a class="navbar-brand" href="index.html">list<span>race</span></a>
				            </div><!--/.navbar-header-->
			           	</div>
			           	<div class="col-sm-9">
			           		<ul class="footer-menu-item">
								@if (Request::routeIs('main.*'))
			                    	<li class="scroll"><a href="#works">how it works</a></li>
			                    	<li class="scroll"><a href="#explore">explore</a></li>
			                    	<li class="scroll"><a href="#reviews">review</a></li>
			                    	<li class="scroll"><a href="#blog">blog</a></li>
			                    	<li class="scroll"><a href="#contact">contact</a></li>
			                    	@auth
										<li><a href="{{ route('auth.profile') }}">my account</a></li>
									@endauth
			                	@endif
			                </ul><!--/.nav -->
			           	</div>
		           </div>
				</div>
				<div class="hm-footer-copyright">
					<div class="row">
						<div class="col-sm-5">
							<p>
								&copy;copyright. designed and developed by <a href="https://www.themesine.com/">themesine</a>
							</p><!--/p-->
						</div>
						<div class="col-sm-7">
							<div class="footer-social">
								<span><i class="fa fa-phone"> +1  (222) 777 8888</i></span>
								<a href="#"><i class="fa fa-facebook"></i></a>	
								<a href="#"><i class="fa fa-twitter"></i></a>
								<a href="#"><i class="fa fa-linkedin"></i></a>
								<a href="#"><i class="fa fa-google-plus"></i></a>
							</div>
						</div>
					</div>
					
				</div><!--/.hm-footer-copyright-->
			</div><!--/.container-->

			<div id="scroll-Top">
				<div class="return-to-top">
					<i class="fa fa-angle-up " id="scroll-top" data-toggle="tooltip" data-placement="top" title="" data-original-title="Back to Top" aria-hidden="true"></i>
				</div>
				
			</div><!--/.scroll-Top-->
			
        </footer><!--/.footer-->
		<!--footer end-->

        <!-- Include all js compiled plugins (below), or include individual files as needed -->

		<script src="{{ asset('assets/js/jquery.js') }}"></script>
        
        <!--modernizr.min.js-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
		
		<!--bootstrap.min.js-->
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
		
		<!-- bootsnav js -->
		<script src="{{ asset('assets/js/bootsnav.js') }}"></script>

        <!--feather.min.js-->
        <script  src="{{ asset('assets/js/feather.min.js') }}"></script>

        <!-- counter js -->
		<script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
		<script src="{{ asset('assets/js/waypoints.min.js') }}"></script>

        <!--slick.min.js-->
        <script src="{{ asset('assets/js/slick.min.js') }}"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
		     
        <!--Custom JS-->
        <script src="{{ asset('assets/js/custom.js') }}"></script>
        
		
    </body>
</html>