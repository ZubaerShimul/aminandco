<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="irstheme">

    <title> Amin and co </title>
    
    <link href="{{ asset('home/assets/css/themify-icons.css')}}" rel="stylesheet">
    <link href="{{ asset('home/assets/css/flaticon.css')}}" rel="stylesheet">
    <link href="{{ asset('home/assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('home/assets/css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('home/assets/css/owl.carousel.css')}}" rel="stylesheet">
    <link href="{{ asset('home/assets/css/owl.theme.css')}}" rel="stylesheet">
    <link href="{{ asset('home/assets/css/slick.css')}}" rel="stylesheet">
    <link href="{{ asset('home/assets/css/slick-theme.css')}}" rel="stylesheet">
    <link href="{{ asset('home/assets/css/swiper.min.css')}}" rel="stylesheet">
    <link href="{{ asset('home/assets/css/owl.transitions.css')}}" rel="stylesheet">
    <link href="{{ asset('home/assets/css/jquery.fancybox.css')}}" rel="stylesheet">
    <link href="{{ asset('home/assets/css/style.css')}}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- start page-wrapper -->
    <div class="page-wrapper">

        <!-- start preloader -->
        <div class="preloader">
            <div class="lds-ellipsis">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        <!-- end preloader -->

        
        <!-- Start header -->
        <header id="header" class="site-header header-style-2">
            <div class="topbar">
                <div class="container">
                    <div class="row">
                        <div class="col col-md-9">
                            <div class="contact-info">
                                <ul>
                                    <li><i class="ti-mobile"></i> +8801712996482</li>
                                    <li><i class="ti-mobile"></i> +8801711331360</li>
                                    <li><i class="ti-time"></i> Sun - Fri 10AM - 10PM</li>
                            
                                </ul>
                            </div>
                        </div>
                      
                    </div>
                </div>
            </div> <!-- end topbar -->
            <nav class="navigation navbar navbar-default">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="open-btn">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.html"><img src="{{ asset('home/assets/images/logo-2.png')}}" alt></a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse navbar-right navigation-holder">
                        <button class="close-navbar"><i class="ti-close"></i></button>
                        <ul class="nav navbar-nav">
                            <li class="menu-item-has-children">
                              
                               
                            </li>

                            <li class="menu-item-has-children">
                             
                          
                            </li>
                            <li class="menu-item-has-children">
                              
                                <ul class="sub-menu">
                                    <li><a href="blog.html">Blog default</a></li>
                                    <li><a href="blog-left-sidebar.html">Blog left sidebar</a></li>
                                    <li><a href="blog-full-width.html">Blog full width</a></li>
                                    <li class="menu-item-has-children">
                                        <a href="#Level3">Blog single</a>
                                        <ul class="sub-menu">
                                            <li><a href="blog-single.html">Blog single</a></li>
                                            <li><a href="blog-single-left-sidebar.html">Blog single left sidebar</a></li>
                                            <li><a href="blog-single-full-width.html">Blog single full width</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li><a href=""></a></li>
                        </ul>
                    </div><!-- end of nav-collapse -->

                    <div class="search-contact">
                        <div class="header-search-form-wrapper">
                            <button class="search-toggle-btn"><i class="ti-search"></i></button>
                            <div class="header-search-form">
                                <form>
                                    <div>
                                        <input type="text" class="form-control" placeholder="Search here...">
                                        <button type="submit"><i class="ti-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="contact-btn">
                            @if(Auth::id())
                            <a href="{{ route('admin.dashboard') }}" class="theme-btn">DashBoard</a>
                             @else
                            <a href="{{ route('admin.login') }}" class="theme-btn">Login</a>
                            @endif
                        </div>
                    </div>
                </div><!-- end of container -->
            </nav>
        </header>
        <!-- end of header -->


        <!-- start of hero -->
        <section class="hero-slider hero-style-2">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="slide-inner slide-bg-image" data-background="{{asset('home/assets/images/slider/aaa.png')}}">
                            <div class="container">
                                <div data-swiper-parallax="300" class="slide-title">
                                    <h2><span>We Provide</span> <br>Best Services</h2>
                                </div>
                                <div data-swiper-parallax="400" class="slide-text">
                                    <p>Raising a heavy fur muff that covered the whole of her lower arm towards the viewer. Gregor then turned to look</p>
                                </div>
                                <div class="clearfix"></div>
                                <div data-swiper-parallax="500" class="slide-btns">
                                    <a href="#" class="theme-btn">Our industry</a> 
                                    <a href="#" class="theme-btn-s2">Contact us</a> 
                                </div>
                            </div>
                        </div> <!-- end slide-inner --> 
                    </div> <!-- end swiper-slide -->


                </div>
                <!-- end swiper-wrapper -->

                <!-- swipper controls -->
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </section>
        <!-- end of hero slider -->

        <!-- start features-section-s2 -->
        <section class="features-section-s2">
            <div class="container">
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="feature-grids clearfix">
                            <div class="grid">
                                <div class="img-holder">
                                    <img src="{{asset('home/assets/images/features/01.png')}}" alt>
                                </div>
                                <h3>01. Quality Materials</h3>
                                <p>Raising a heavy fur muff that covered the whole of her lower arm towards the viewer. </p>
                            </div>
                            <div class="grid">
                                <div class="img-holder">
                                    <img src="assets/images/features/02.png')}}" alt>
                                </div>
                                <h3>02. Expert Team</h3>
                                <p>Raising a heavy fur muff that covered the whole of her lower arm towards the viewer. </p>
                            </div>
                            <div class="grid">
                                <div class="img-holder">
                                    <img src="{{asset('home/assets/images/features/03.png')}}" alt>
                                </div>
                                <h3>03. Timely Delivery</h3>
                                <p>Raising a heavy fur muff that covered the whole of her lower arm towards the viewer. </p>
                            </div>
                            <div class="grid">
                                <div class="img-holder">
                                    <img src="assets/images/features/04.png')}}" alt>
                                </div>
                                <h3>04. 24/7 Suport</h3>
                                <p>Raising a heavy fur muff that covered the whole of her lower arm towards the viewer. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end container -->
        </section>
        <!-- end features-section-s2 -->

        
        <!-- start about-us-section-s2 -->
        <section class="about-us-section-s2 section-padding p-t-0">
            <div class="container">
                <div class="row">
                    <div class="col col-md-5">
                        <div class="img-holder about-image">
                            <img src="{{asset('home/assets/images/dfsg.png')}}" alt>
                        </div>
                    </div>
                    <div class="col col-md-7">
                        <div class="about-details">
                            <div class="section-title">
                                <span>About us</span>
                                <h2>Most Modern & Powerfull <span>Industry in Khulna</span></h2>
                            </div>
                            <div class="details">
                                <p>A collection of textile <strong>samples lay spread out on the table</strong> Samsa was a travelling salesman  and above it there hung a picture that he had recently cut out of an illustrated magazine and housed in a nice, gilded frame. It showed a lady fitted out with a fur hat</p>
                                <ul>
                                    <li><i class="ti-arrow-circle-right"></i> Ftted out with a fur hat and fur boa </li>
                                    <li><i class="ti-arrow-circle-right"></i> It showed a lady fitted out with a fur hat and fur boa who sat </li>
                                    <li><i class="ti-arrow-circle-right"></i> Samsa was a travelling salesman  and above it there hung  </li>
                                    <li><i class="ti-arrow-circle-right"></i> Muff that covered the whole of her </li>
                                </ul>
                            </div>
                            <div class="ceo-quote">
                                <blockquote>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptas explicabo nemo ab iste laboriosam deserunt ipsa eius dolores veritatis.
                                    <span>- Adam ( CEO of the company )</span>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end container -->
        </section>
        <!-- end about-us-section-s2 -->


        <!-- start services-section-s2 -->
        <section class="services-section-s2 section-padding">
            <div class="container">
                <div class="row">
                    <div class="col col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3">
                        <div class="section-title-s4">
                            <span>Services</span>
                            <h2>The Best Services <span>we provide</span></h2>
                        </div>                        
                    </div>
                </div>
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="service-grids clearfix">
                            <div class="grid">
                                <div class="img-holder">
                                    <img src="{{asset('home/assets/images/services/a (1).jpg')}}" alt>
                                </div>
                                <div class="details">
                                    <i class="fi flaticon-solar-energy"></i>
                                    <h3><a href="#">Power & Energy</a></h3>
                                    <p>Recently cut out of an illustrated magine and housed indust</p>
                                </div>
                            </div>
                            <div class="grid">
                                <div class="img-holder">
                                    <img src="{{asset('home/assets/images/services/a (3).jpg')}}" alt>
                                </div>
                                <div class="details">
                                    <i class="fi flaticon-plug"></i>
                                    <h3><a href="#">Mechanical Works</a></h3>
                                    <p>Recently cut out of an illustrated magine and housed indust</p>
                                </div>
                            </div>
                            <div class="grid">
                                <div class="img-holder">
                                    <img src="{{asset('home/assets/images/services/a (4).jpg')}}" alt>
                                </div>
                                <div class="details">
                                    <i class="fi flaticon-oil-barrel"></i>
                                    <h3><a href="#">Petroleum Refinery</a></h3>
                                    <p>Recently cut out of an illustrated magine and housed indust</p>
                                </div>
                            </div>
                            <div class="grid">
                                <div class="img-holder">
                                    <img src="{{asset('home/assets/images/services/a (1).jpeg')}}" alt>
                                </div>
                                <div class="details">
                                    <i class="fi flaticon-oil-1"></i>
                                    <h3><a href="#">Oil and Gas</a></h3>
                                    <p>Recently cut out of an illustrated magine and housed indust</p>
                                </div>
                            </div>
                            <div class="grid">
                                <div class="img-holder">
                                    <img src="{{asset('home/assets/images/services/a (6).jpg')}}" alt>
                                </div>
                                <div class="details">
                                    <i class="fi flaticon-truck"></i>
                                    <h3><a href="#">Logistics Services</a></h3>
                                    <p>Recently cut out of an illustrated magine and housed indust</p>
                                </div>
                            </div>
                            <div class="grid">
                                <div class="img-holder">
                                    <img src="{{asset('home/assets/images/services/a (7).jpg')}}" alt>
                                </div>
                                <div class="details">
                                    <i class="fi flaticon-factory"></i>
                                    <h3><a href="#">General Industry</a></h3>
                                    <p>Recently cut out of an illustrated magine and housed indust</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end container -->
        </section>
        <!-- end services-section-s2 -->












        <!-- start team-section -->
        <section class="team-section section-padding p-t-0">
            <div class="container">
                <div class="row">
                    <div class="col col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3">
                        <div class="section-title-s4">
                            <span></span>
                            <h2>Our Dedicated Tem <span>For your service</span></h2>
                        </div>                        
                    </div>
                </div>
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="team-grids">
                            <div class="grid">
                                <div class="img-social">
                                    <div class="img-holder">
                                        <img src="{{asset('home/assets/images/team/b.png')}}" alt>
                                    </div>
                                    <div class="social">
                                        <ul>
                                            <li><a href="#"><i class="ti-facebook"></i></a></li>
                                            <li><a href="#"><i class="ti-twitter-alt"></i></a></li>
                                            <li><a href="#"><i class="ti-linkedin"></i></a></li>
                                            <li><a href="#"><i class="ti-pinterest"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="details">
                                    <h3>Polash </h3>
                                    <span>Mechanical Engineering</span>
                                </div>
                            </div>
                            <div class="grid">
                                <div class="img-social">
                                    <div class="img-holder">
                                        <img src="{{asset('home/assets/images/team/a.png')}}" alt>
                                    </div>
                                    <div class="social">
                                        <ul>
                                            <li><a href="#"><i class="ti-facebook"></i></a></li>
                                            <li><a href="#"><i class="ti-twitter-alt"></i></a></li>
                                            <li><a href="#"><i class="ti-linkedin"></i></a></li>
                                            <li><a href="#"><i class="ti-pinterest"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="details">
                                    <h3>Arif</h3>
                                    <span>Site Manager</span>
                                </div>
                            </div>
                            <div class="grid">
                                <div class="img-social">
                                    <div class="img-holder">
                                        <img src="{{asset('home/assets/images/team/img-3.jpg')}}" alt>
                                    </div>
                                    <div class="social">
                                        <ul>
                                            <li><a href="#"><i class="ti-facebook"></i></a></li>
                                            <li><a href="#"><i class="ti-twitter-alt"></i></a></li>
                                            <li><a href="#"><i class="ti-linkedin"></i></a></li>
                                            <li><a href="#"><i class="ti-pinterest"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="details">
                                    <h3>Gotalon Simrol</h3>
                                    <span>Testing Manager</span>
                                </div>
                            </div>
                            <div class="grid">
                                <div class="img-social">
                                    <div class="img-holder">
                                        <img src="{{asset('home/assets/images/team/img-5.jpg')}}" alt>
                                    </div>
                                    <div class="social">
                                        <ul>
                                            <li><a href="#"><i class="ti-facebook"></i></a></li>
                                            <li><a href="#"><i class="ti-twitter-alt"></i></a></li>
                                            <li><a href="#"><i class="ti-linkedin"></i></a></li>
                                            <li><a href="#"><i class="ti-pinterest"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="details">
                                    <h3>Mine Dow</h3>
                                    <span>Cheif Officer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end container -->
        </section>
        <!-- end team-section -->

        







        <!-- start site-footer -->
        <footer class="site-footer">
            <div class="upper-footer">
                <div class="container">
                    <div class="row">
                        <div class="col col-lg-3 col-md-3 col-sm-6">
                            <div class="widget about-widget">
                                <div class="logo widget-title">
                                    <h3>About us</h3>
                                </div>
                                <p>Who sat upright, raising a heavy fur muff that covered the whole of her lower arm towards the viewer. Gregor then turned to</p>
                                <div class="social">
                                    <ul>
                                        <li><a href="#"><i class="ti-facebook"></i></a></li>
                                        <li><a href="#"><i class="ti-twitter-alt"></i></a></li>
                                        <li><a href="#"><i class="ti-linkedin"></i></a></li>
                                        <li><a href="#"><i class="ti-pinterest"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-3 col-md-3 col-sm-6">
                            <div class="widget link-widget">
                                <div class="widget-title">
                                    <h3>Important Links</h3>
                                </div>
                                <ul>
                                    <li><a href="#">About us</a></li>
                                    <li><a href="#">The team</a></li>
                                    <li><a href="#">Our services</a></li>
                                    <li><a href="#">Contact</a></li>
                                </ul>
                                <ul>
                                    <li><a href="#">Provacu Policy</a></li>
                                    <li><a href="#">FAQ</a></li>
                                    <li><a href="#">News</a></li>
                                    <li><a href="#">Testimonials</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col col-lg-3 col-md-3 col-sm-6">
                            <div class="widget contact-widget service-link-widget">
                                <div class="widget-title">
                                    <h3>Address Location</h3>
                                </div>
                                <ul>
                                    <li>1No. Custom Ghat (Punak Market Khulna, 9100)</li>
                                    <li>Phone:  +8801711331360</li>
                                    <li>Office Time: 10AM- 10PM</li>
                                
                                </ul>
                            </div>
                        </div>
                        <div class="col col-lg-3 col-md-3 col-sm-6">
                            <div class="widget newsletter-widget">
                                <div class="widget-title">
                                    <h3>Newsletter</h3>
                                </div>
                                <p>You will be notified when somthing new will be appear.</p>
                                <form>
                                    <div class="input-1">
                                        <input type="email" class="form-control" placeholder="Email Address *" required>
                                    </div>
                                    <div class="submit clearfix">
                                        <button type="submit"><i class="ti-email"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> <!-- end container -->
            </div>
            <div class="lower-footer">
                <div class="container">
                    <div class="row">
                        <div class="separator"></div>
                        <div class="col col-xs-12">
                         
                            <div class="short-links">
                                <ul>
                                    <li><a href="#">Privacy</a></li>
                                    <li><a href="#">Terms of Use</a></li>
                                    <li><a href="#">Cookies</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end site-footer -->

    </div>
    <!-- end of page-wrapper -->



    <!-- All JavaScript files
    ================================================== -->
    <script src="{{asset('home/assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('home/assets/js/bootstrap.min.js')}}"></script>

    <!-- Plugins for this template -->
    <script src="{{asset('home/assets/js/jquery-plugin-collection.js')}}"></script>

    <!-- Custom script for this template -->
    <script src="{{asset('home/assets/js/script.js')}}"></script>
</body>
</html>
