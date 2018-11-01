$(document).ready(function() {

    $(document).on('click','.deleteRecord', function(e){
        var id = $(this).attr('rel');
        var deleteFunction = $(this).attr('rel1');
        swal({
            title: "Are You Sure?",
            text: "You will not be able to recover this record again",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "cart_quantity_delete",
            confirmButtonText: "Yes, Delete It"

        },
        function(){
            window.location.href="/user/"+deleteFunction+"/"+id;
        });
    });

});