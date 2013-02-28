<?php

/*
 * ©2012 Croce Rossa Italiana
 */
$t=$_GET['id'];
$f=Persona::filtra([['id',$t]]);
$f[0]->admin = '1';
redirect('admin&new');
?>