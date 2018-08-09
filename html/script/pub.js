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

    	$('.toggle').click(function(e) { 
    		sku = $(this).attr("id"); 
    		console.log(sku);

    		var checkboxes = $(this).find("input[type=checkbox]");
    		if(checkboxes.prop("checked")){
    			 $.ajax({
                type:'GET',
                url:'pro/disable/',
                data : {sku: sku},
                success:function(data){
            
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.status);
                }
            });

    		}
    		else{

    			 $.ajax({
                type:'GET',
                url:'pro/enable/',
                data : {sku: sku},
                success:function(data){
              
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.status);
                }
            });
    		} 
    });

    //$(".toggle").click(toggle);

    
    var toggle = function(e){
	console.log("test");

      alert("Test");
        sku = $(this).attr("data-value");

        if ($(this).is(":checked")){
                $.ajax({
                type:'GET',
                url:'/enable',
                data : {sku: sku},
                success:function(data){
                   //document.getElementById(productId).setAttribute("disabled","disabled");
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.status);
                }
            });
        }
        else{

                $.ajax({
               type:'GET',
               url:'/disable',
               data : {sku: sku},
                // data:'_token = <?php echo csrf_field() ?>',
               success:function(data){
                 // alert(data.msg);
                   //document.getElementById(productId).setAttribute("disabled","disabled");
               },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.status);
                }
            });
        }
}
});
    

