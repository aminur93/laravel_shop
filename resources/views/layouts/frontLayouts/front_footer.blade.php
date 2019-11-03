<footer id="footer"><!--Footer-->
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="companyinfo">
                        <h2><span>e</span>-shopper</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <a href="#">
                                <div class="iframe-img">
                                    <img src="{{asset('user/images/home/iframe1.png')}}" alt="" />
                                </div>
                                <div class="overlay-icon">
                                    <i class="fa fa-play-circle-o"></i>
                                </div>
                            </a>
                            <p>Circle of Hands</p>
                            <h2>24 DEC 2014</h2>
                        </div>
                    </div>
                    
                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <a href="#">
                                <div class="iframe-img">
                                    <img src="{{asset('user/images/home/iframe2.png')}}" alt="" />
                                </div>
                                <div class="overlay-icon">
                                    <i class="fa fa-play-circle-o"></i>
                                </div>
                            </a>
                            <p>Circle of Hands</p>
                            <h2>24 DEC 2014</h2>
                        </div>
                    </div>
                    
                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <a href="#">
                                <div class="iframe-img">
                                    <img src="{{asset('user/images/home/iframe3.png')}}" alt="" />
                                </div>
                                <div class="overlay-icon">
                                    <i class="fa fa-play-circle-o"></i>
                                </div>
                            </a>
                            <p>Circle of Hands</p>
                            <h2>24 DEC 2014</h2>
                        </div>
                    </div>
                    
                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <a href="#">
                                <div class="iframe-img">
                                    <img src="{{asset('user/images/home/iframe4.png')}}" alt="" />
                                </div>
                                <div class="overlay-icon">
                                    <i class="fa fa-play-circle-o"></i>
                                </div>
                            </a>
                            <p>Circle of Hands</p>
                            <h2>24 DEC 2014</h2>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="address">
                        <img src="{{asset('user/images/home/map.png')}}" alt="" />
                        <p>505 S Atlantic Ave Virginia Beach, VA(Virginia)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="footer-widget">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Service</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Online Help</a></li>
                            <li><a href="{{ url('/page/contact') }}">Contact Us</a></li>
                            <li><a href="#">Order Status</a></li>
                            <li><a href="#">Change Location</a></li>
                            <li><a href="#">FAQ’s</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Quock Shop</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">T-Shirt</a></li>
                            <li><a href="#">Mens</a></li>
                            <li><a href="#">Womens</a></li>
                            <li><a href="#">Gift Cards</a></li>
                            <li><a href="#">Shoes</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Policies</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="{{ url('/page/terms-of-use') }}">Terms of Use</a></li>
                            <li><a href="{{ url('/page/privacy-policy') }}">Privecy Policy</a></li>
                            <li><a href="{{ url('/page/refund-policy') }}">Refund Policy</a></li>
                            <li><a href="{{ url('/page/billing-system') }}">Billing System</a></li>
                            <li><a href="{{ url('/page/ticket-system') }}">Ticket System</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>About Shopper</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="{{ url('/page/about-us') }}">Company Information</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Store Location</a></li>
                            <li><a href="#">Affillate Program</a></li>
                            <li><a href="#">Copyright</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3 col-sm-offset-1">
                    <div class="single-widget">
                        <h2>About Shopper</h2>
                        <form action="javascript:void(0)" type="post" class="searchform" id="contact-form">
                            @csrf
                            <input onfocus="enableSubscriber()" onfocusout="checkSubscriber();" type="email" name="subscriber_email" id="subscriber_email" required placeholder="Your email address" />
                            <button onclick="checkSubscriber(); addSubscriber();" id="btnSubmit" type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
                            <span id="msg" style="color: green;"></span>
                            <p>Get the most recent updates from <br />our site and be updated your self...</p>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p class="pull-left">Copyright © 2018 E-shopper Inc. All rights reserved.</p>
                <p class="pull-right">Developed by <span><a target="_blank" href="">Aminur Rashid</a></span></p>
            </div>
        </div>
    </div>
    
</footer><!--/Footer-->

<script>
    function checkSubscriber() {
        var subscriber_email = $("#subscriber_email").val();
        $.ajax({
            type: 'post',
            url: '/check-subscriber-email',
            data: {subscriber_email:subscriber_email},
            success: function (resp) {
                if (resp == "exists")
                {
                    $("#msg").show();
                    $("#btnSubmit").hide();
                    $("#msg").html("Subscribe Email is Already Exist ! Try Another one");
                }
            },
            error: function (resp) {
                alert("Error");
            }
        });
    }

    function addSubscriber() {
        var subscriber_email = $("#subscriber_email").val();
        $.ajax({
            type: 'post',
            url: '/add-subscriber-email',
            data: {subscriber_email:subscriber_email},
            success: function (resp) {
                if (resp == "exists")
                {
                    $("#msg").show();
                    $("#btnSubmit").hide();
                    $("#msg").html("Subscribe Email is Already Exist ! Try Another one");
                }else if(resp == "saved"){
                    $('#contact-form')[0].reset();
                    $("#msg").show();
                    $("#msg").html("Thanks For Subscribing");
                }

            },
            error: function (resp) {
                alert("Error");
            }
        });
    }
    
    function enableSubscriber() {
        $("#btnSubmit").show();
        $("#msg").hide();
    }
</script>