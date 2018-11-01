/*price range*/

 $('#sl2').slider();

	var RGBChange = function() {
	  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
	};	
		
/*scroll to top*/

$(document).ready(function(){
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
});

$(document).ready(function(){
    //change price with size
	$("#Selsize").change(function(){
		var idSize = $(this).val();
		if (idSize == "") {
			return false;
		}
		$.ajax({
			type: 'get',
			url: '/get-product-price',
			data: {idSize:idSize},
			success: function(resp){
				//alert(resp); return false;
				var arr = resp.split("#");
				$("#getPrice").html("Tk "+arr[0]);
				$("#price").val(arr[0]);
				if (arr[1] == 0) {
					$("#cartButton").hide();
					$("#Availability").text("Out Of Stock");
				}else{
					$("#cartButton").show();
					$("#Availability").text("In Stock");
				}
			},
			error: function () {
				alert("Error");
			}
		});
	});

	//chnage mainImage with other image
	$(".changeImage").click(function(){
		var image = $(this).attr('src');
		$(".mainImage").attr("src",image);
	});

});



// Instantiate EasyZoom instances
var $easyzoom = $('.easyzoom').easyZoom();

// Setup thumbnails example
var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

$('.thumbnails').on('click', 'a', function(e) {
	var $this = $(this);

	e.preventDefault();

	// Use EasyZoom's `swap` method
	api1.swap($this.data('standard'), $this.attr('href'));
});

// Setup toggles example
var api2 = $easyzoom.filter('.easyzoom--with-toggle').data('easyZoom');

$('.toggle').on('click', function() {
	var $this = $(this);

	if ($this.data("active") === true) {
		$this.text("Switch on").data("active", false);
		api2.teardown();
	} else {
		$this.text("Switch off").data("active", true);
		api2._init();
	}
});

$().ready(function(){
	//validation reigister from
	$("#registerFrom").validate({
		rules:{
			name:{
				required:true,
				minlength:2,
				lettersonly: true
			},

			password:{
				required:true,
				minlength:6
			},

			email:{
				required:true,
				email:true,
				remote:"/check-email"
			}
		},
		messages:{
			name: {
				required: "Please Enter Your Name",
				minlength: "Your name Must be At Least 2 Characters long",
				lettersonly: "your Name must be contains only latters"
			},
			password:{
				required: "please Provide Your Password",
				minlength: "Your Password Must be At Least 6 Characters long"
			},
			email:{
				required: "Please Enter Your Email",
				email: "Please Enter Valid Email",
				remote: "Email is already exist"
			}		
		}
	});

	//validation account from
	$("#accountForm").validate({
		rules:{
			name:{
				required:true,
				minlength:2,
				lettersonly: true
			},

			address:{
				required:true,
				minlength:6
			},

			city:{
				required:true
			},

			state:{
				required:true
			},

			country:{
				required:true
			},

			pincode:{
				required:true
			},

			mobile:{
				required:true
			}
		},
		messages:{
			name: {
				required: "Please Enter Your Name",
				minlength: "Your name Must be At Least 2 Characters long",
				lettersonly: "your Name must be contains only latters"
			},
			address:{
				required: "please Provide Your address",
				minlength: "Your address Must be At Least 6 Characters long"
			},
			city:{
				required: "Please Enter Your city"
			},
			state:{
				required: "Please Enter Your state"
			},
			country:{
				required: "Please Enter Your country"
			},
			pincode:{
				required: "Please Enter Your pincode"
			},
			mobile:{
				required: "Please Enter Your mobile"
			}	
		}
	});

	//validation login from
	$("#loginForm").validate({
		rules:{
			email:{
				required:true,
				email:true
			},
			password:{
				required:true
			}
		},
		messages:{
			email:{
				required: "Please Enter Your Email",
				email: "Please Enter Valid Email"
			},
			password:{
				required: "please Provide Your Password",
			}	
		}
	});

	//check cureent password
	$("#current_pwd").keyup(function(){
		var current_pwd = $(this).val();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: 'post',
			url: '/user/user-check-pwd',
			data: {current_pwd:current_pwd},
			success: function(resp) {
				// alert(resp);
				if (resp == "false") {
					$("#chkpwd").html("<font color='red'>Current Password is incorrect</font>");
				}else if(resp == "true"){
					$("#chkpwd").html("<font color='green'>Current Password is correct</font>");
				}
			},
			error: function(){
				alert("Error");
			}
		});
	});

	// Password Validation
	$("#UpdatePassword").validate({

		rules: {
			current_pwd:{
				required: true,
				minlength:6,
				maxlength:20
			},
	
			new_pwd:{
				required: true,
				minlength:6,
				maxlength:20
			},
	
			confirm_pwd:{
				required: true,
				minlength:6,
				maxlength:20,
				equalTo:"#new_pwd"
			},
		},
	
	  });

	//visual password strength indicator
	$('#myPassword').passtrength({
		minChars: 4,
		passwordToggle: true,
		tooltip: true,
		eyeImg : "/user/images/eye.svg"
	});
});
