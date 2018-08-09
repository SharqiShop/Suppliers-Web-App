
$(document).ready(function(){

    $('.action').click(function(e) {

        id = $(this).parent().attr("id");
        sku = $(this).parent().attr("sku");
        cost = document.getElementById('text_'+id).value;

        if (!(jQuery.isNumeric(cost)))
        {
            alert ("Enter valid cost")
            return;
        }

        var em = $(this).find("em");
        action = em.prop("class");

        if (action == "fa fa-thumbs-o-up"){
            action="1";
        }else{

            action = "0";
        }

        $.ajax({
            type:'GET',
            url:'../item/action/',
            data : {id: id, action:action, sku:sku, cost:cost},
            success:function(data){

                if (data == 101)
                {
                    alert ("Enter valid cost");
                    return;
                }


                if (action == "1"){
                    $( "#"+id + " .fa.fa-times" ).parent().remove();
                    $( "#"+id + " .fa.fa-thumbs-o-up" ).parent().prop("class","btn btn-success");
                    $( "#"+id + " .fa.fa-thumbs-o-up" ).parent().attr("disabled",true);
                }else{

                    $( "#"+id + " .fa.fa-thumbs-o-up" ).parent().remove();
                    $( "#"+id + " .fa.fa-times" ).parent().prop("class","btn btn-danger");
                    $( "#"+id + " .fa.fa-times" ).parent().attr("disabled",true);
                }
                var ship = document.getElementById('ship');
                var notify = document.getElementById('notify');
                var cancel = document.getElementById('cancel');

                var ship   = $('<input name="action" type="hidden" value="ship"> <button type="submit"   id="ship" type="button" class="btn btn-success btn-filter" data-target="pagado">Request Shipping</button>');
                var notify = $('<input name="action" type="hidden" value="notify"> <button type="submit" id="notify" type="button" class="btn btn-warning btn-filter" data-target="pagado">Notify Client</button>');
                var cancel = $('<input name="action" type="hidden" value="cancel"> <button type="submit" id="cancel" type="button" class="btn btn-danger btn-filter" data-target="pagado">Cancel Order</button>');


                if (data == "ship")
                //ship.style.display = 'block';
                    $("#shiporder").append(ship);
                else
                if(data == "notify")
                    $("#shiporder").append(notify);
                else
                if(data == "cancel")
                    $("#shiporder").append(cancel);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.status);
            }
        });
    });
});