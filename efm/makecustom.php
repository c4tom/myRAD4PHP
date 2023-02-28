<?php
    include("../config/setings.php");
    include("../config/setup.php");
    $smarty = new Smarty_myrad4php();
    $dc = new datacontex();
    $atablas = array();

    foreach($dc->tablas as $tabla)
    {
        $atablas[]=$tabla->nomtabla;
    }  
    $smarty->assign("atablas",$atablas);
    
    $err=array();
    $smarty->assign("error",$err);
    $smarty->display('makecustom.tpl');
?>