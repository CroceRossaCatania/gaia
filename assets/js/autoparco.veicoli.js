$(document).ready(function(){
        $("#select").change(function(){
            var n = $('#select').find(":selected").val();
            if(n == "Filtra per comitato"){
            	$(".comitato").show();
            	return;
            }
            $( "select option:selected").each(function(){
              		$(".comitato").hide();
                    $("." + n).show();
            });
        }).change();
    });