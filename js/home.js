var comitati;

$(document).ready( function() {
   
   setInterval(function() {
       var m = comitati[Math.floor((Math.random()*comitati.length))];
       $("#rollerComitati").hide('fade', 300, function () {
           $("#rollerComitati").text(m).show('fade', 300);
       });
   }, 2000);
});