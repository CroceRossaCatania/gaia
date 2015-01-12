$(document).ready(function(){
    var f = function(){
        var n = $('#select').find(":selected").val();
        //console.log && console.log(n);
        if(n == "Filtra per comitato"){
            $(".comitato").show();
            $(".option").show();
            $(".option").removeAttr("disabled","disabled");
            return;
        }
        $(".comitato").hide();
        $("." + n).show();
        $(".option").hide();
        $(".option").attr("disabled","disabled");
        $(".option." + n).show();
        $(".option." + n).removeAttr("disabled","disabled");
        };
    var g = function(){
        var n = $('#select').find(":selected").val();
        var m = $('#select2').find(":selected").val(); 
        if(m == "Filtra per autoparco"){
            if(n == "Filtra per comitato"){
                $(".comitato").show();
            }else{
                $(".comitato." + n).show();
            }
            return;
        }
        if(n == "Filtra per comitato"){
            $(".comitato").hide();
        }else{
            $(".comitato." + n).hide();
        }
        $(".comitato." + m).show();
    }
    $("#select").change(f);
    $("#select2").change(g);
    f();
});