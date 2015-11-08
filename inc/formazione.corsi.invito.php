<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$id = intval(filter_input(INPUT_GET, "id"));
$md5 = filter_input(INPUT_GET, "md5");

$part = PartecipazioneCorso::id($id);
if ($part->md5 != $md5){
    header('HTTP/1.0 403 Forbidden');
    redirect("errore.403");
    exit(0);
} ?>
  
<?php var_dump($part); ?>


<form id="invitoRisposta" action="?" method="get">
    <ul>
        <li><input name="response" type="radio" value="1" data-url="formazione.corsi.invito.ok" />Accetta</li>
        <li><input name="response" type="radio" value="0" data-url="formazione.corsi.invito.ko" />Rifiuta</li>

        <textarea name="note" id="note" style="display:none"></textarea>

        <input type="hidden" id="id" value="<?php echo $id ?>" />
        <input type="hidden" id="md5" value="<?php echo $md5 ?>" />
        
        <input type="submit" value="invia">
    </ul>
<form>


<script>
$(document).ready(function(){
    $('input[name=response]').change(function(){
       if ($('input[name=response]:checked').val() === "0"){
           $('textarea[name=note]').show();
       }else{
           $('textarea[name=note]').hide();
       }
    });
    
    $('#invitoRisposta').submit(function(){
        if($('input[name=response]:checked').length === 0){
            alert('devi dire si o no');
            return false;
        }
        
        if ($('input[name=response]:checked').val() === "0" && $.trim($('textarea[name=note]').val()).length === 0){
            alert('perchè non puoi accettare?');
            return false;
        }
        
        location.href = '?p='+$('input[name=response]:checked').data('url')+'&id='+$('#id').val()+'&md5='+$('#md5').val();
        return false;
    });
});

</script>