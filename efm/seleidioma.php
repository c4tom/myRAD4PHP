<?php
    session_start();
      if(!file_exists(realpath(dirname(__FILE__).'/..').'/'."libs/smarty/Smarty.class.php"))
        header("Location: ../config/erros.html");
      if(!file_exists(realpath(dirname(__FILE__).'/..').'/'."libs/html2pdf/html2pdf.class.php"))
        header("Location: ../config/erros.html");
    include("../config/idiomascfg.php");
    require("../libs/smarty/Smarty.class.php");
    if(isset($_POST["set"]))
    {
        $_SESSION["idiomasel"]=$_POST["cboidioma"];
        header("Location: configapp.php");
    }
    $idio = new admin_idiomas();
    $sma = new Smarty();
    $sma->setTemplateDir('../templates/template');
    $sma->setCompileDir('../templates/templates_c/');
    $sma->setConfigDir('../templates/configs/');
    $sma->setCacheDir('../templates/cache/');
    $sma->assign("names", $idio->getidiomasnames());
    $sma->assign("files", $idio->getidiomasfiles());
    $sma->display("seleidioma.tpl");
?>