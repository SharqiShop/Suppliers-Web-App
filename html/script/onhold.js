$(document).ready(function(){
    $('.state').on('change', function () {

        id     = ($(this).attr("id"));
        action = ($(this).val());

        $.ajax({
            type:'GET',
            url:'order/action/',
            data : {id: id, action:action},
            success:function(data){

                console.log(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.status);
            }
        });
    });

    $('.toggle').click(function(e) {
        id = $(this).attr("id");
        //alert(id);
        status = "return";
        //alert(status);
        
        $.ajax({
            type:'GET',
            url:'order/refund/',
            data : {id: id, action: status},
            success:function(data){
                alert("Successfully returned")

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Something went wrong while cancelation process in Magento");
                console.log(jqXHR);
            }
        });
    });

});


