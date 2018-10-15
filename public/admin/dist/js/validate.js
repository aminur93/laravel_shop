$(document).ready(function() {

    $("#current_pwd").keyup(function(){
        var current_pwd = $("#current_pwd").val();
        $.ajax({
            type: 'get',
            url: '/admin/check-pwd',
            data: {current_pwd:current_pwd},
            success: function(resp){
                //alert(resp);
                if(resp == 'false'){
                    $("#chkPwd").html("<font color='red'>Current Password is Incorrect</font>");
                }else if(resp == 'true'){
                    $("#chkPwd").html("<font color='green'>Current Password is Correct</font>");
                }
            }, error:function() {
                alert("Error");
            }
        });
    });

    //brand validation
    $('#edit_brand_validate').validate({

        rules: {
            brand_name: {
                required: true
               
            },

            description: {
                required: true
            },

            url: {
                required: true
            }
        },
    });

     //brand validation
     $('#brand_validate').validate({

        rules: {
            brand_name: {
                required: true
               
            },

            description: {
                required: true
            },

            url: {
                required: true
            }
        },
    });
   

     //edit category validation
     $('#edit_category_validate').validate({

        rules: {
            category_name: {
                required: true
               
            },

            description: {
                required: true
            },

            url: {
                required: true
            }
        },
    });
   
    //add category validation
    $('#category_validate').validate({

        rules: {
            category_name: {
                required: true,
                minlength: 5,
                maxlength: 80
            },

            description: {
                required: true,
                minlength: 5,
                maxlength: 120,
            },

            url: {
                required: true,
                minlength: 5,
                maxlength: 50
            }
        },
    });

     //add product validation
     $('#product_validate').validate({

        rules: {
            category_id: {
                required: true
            },

            brand_id: {
                required: true
            },

            product_name: {
                required: true
            },

            product_code: {
                required: true
            },

            product_color: {
                required: true
            },

            price: {
                required: true,
                number: true
            },

           image: {
               required: true
           }
        },
    });

    //edit product validation
    $('#edit_product_validate').validate({

        rules: {
            category_id: {
                required: true
            },

            brand_id: {
                required: true
            },

            product_name: {
                required: true
            },

            product_code: {
                required: true
            },

            product_color: {
                required: true
            },

            price: {
                required: true,
                number: true
            },
        },
    });


  // Password Validation
  $("#password_validate").validate({

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

    //COnfirmation Deleteing category
    // $("#delCat").click(function(){
    //     if(confirm('Are You Sure Want To Delete category')){
    //         return true;
    //     }
    //     return false;
    // });

    //COnfirmation Deleteing Brand
    // $("#delBrand").click(function(){
    //     if(confirm('Are You Sure Want To Delete Brand')){
    //         return true;
    //     }
    //     return false;
    // });

    // //COnfirmation Deleteing product
    // $("#delPro").click(function(){
    //     if(confirm('Are You Sure Want To Delete Product')){
    //         return true;
    //     }
    //     return false;
    // });

    //COnfirmation Deleteing product
    $("#delImage").click(function(){
        if(confirm('Are You Sure Want To Delete Product Image')){
            return true;
        }
        return false;
    });

    $(document).on('click','.deleteRecord', function(e){
        var id = $(this).attr('rel');
        var deleteFunction = $(this).attr('rel1');
        swal({
            title: "Are You Sure?",
            text: "You will not be able to recover this record again",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, Delete It"

        },
        function(){
            window.location.href="/admin/"+deleteFunction+"/"+id;
        });
    });


    //product attributes jquery

    $(document).ready(function(){
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div><input type="text" name="sku[]" id="sku" placeholder="SKU"/> <input type="text" name="size[]" id="size" placeholder="Size"/> <input type="text" name="price[]" id="price" placeholder="Price"/> <input type="text" name="stock[]" id="stock" placeholder="Stock"/><a href="javascript:void(0);" class="remove_button"> Remove </a></div>'; //New input field html 
        var x = 1; //Initial field counter is 1
        
        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){ 
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });
        
        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });

});