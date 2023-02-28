<?php
    session_start();
    include("setings.php");
    include("../config/setup.php");
    require_once("../config/idiomascfg.php");
	require($GLOBALS["ruta"].$GLOBALS['destinodal']."/metadata.php");
	require($GLOBALS["ruta"].$GLOBALS['destinodal']."/datacontext.php");
    require($GLOBALS["ruta"].$GLOBALS['destinodal']."/dalall.php");    
    $smarty = new Smarty_myrad4php();
    $smarty->assign("nomuser","");
    $smarty->assign("titulo","");
    $smarty->assign("tittlebuilderlabel","");
    $smarty->display("mnubuillder.tpl");
?>