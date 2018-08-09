$(document).ready(function(){
     $('.btn-filter').on('click', function () {
      var $target = $(this).data('target');
      if ($target != 'all') {
        $('.table tr').css('display', 'none');
        $('.table tr[data-status="' + $target + '"]').fadeIn('slow');
      } else {
        $('.table tr').css('display', 'none').fadeIn('slow');
      }
    });

    $('.action').click(function(e) { 
            
    	  id = $(this).parent().attr("id"); 
        
    		var em = $(this).find("em");
    		action = em.prop("class");

        if (action == "fa fa-thumbs-o-up"){
            action="success";
            }else if (action == "fa fa-hourglass-start"){
                action = "processing";
            }else
                action = "canceled";
                
    			 $.ajax({
                type:'GET',
                url:'order/action/',
                data : {id: id, action:action},
                success:function(data){
                    if (action == "success"){

                        $( "#"+id + " .fa.fa-hourglass-start" ).parent().remove();
                        $( "#"+id + " .fa.fa-times" ).parent().remove();
                        $( "#"+id + " .fa.fa-thumbs-o-up" ).parent().prop("class","btn btn-success");
                        $( "#"+id + " .fa.fa-thumbs-o-up" ).parent().attr("disabled",true);

                    }else if (action == "processing"){
                            $( "#"+id + " .fa.fa-thumbs-o-up" ).parent().remove();
                            $( "#"+id + " .fa.fa-times" ).parent().remove();
                            $( "#"+id + " .fa.fa-hourglass-start" ).parent().prop("class","btn btn-warning");
                            $( "#"+id + " .fa.fa-hourglass-start" ).parent().attr("disabled",true);
                    }else{

                        $( "#"+id + " .fa.fa-hourglass-start" ).parent().remove();
                        $( "#"+id + " .fa.fa-thumbs-o-up" ).parent().remove();
                        $( "#"+id + " .fa.fa-times" ).parent().prop("class","btn btn-danger");
                        $( "#"+id + " .fa.fa-times" ).parent().attr("disabled",true);   
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.status);
                }
            });      
    });
});
    

