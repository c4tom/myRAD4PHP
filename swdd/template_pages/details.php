<?php
    /**
     * MyRad4PHP
     * Aplicacion desarrollada por Jorge Luis Prado Anci, en cuanto al licenciamiento 
     * pues esta aplicacion se entrega tal cual y tienen permiso de modifcarla y 
     * distribuirla de la manera que deseen, solo se les solicita que respeten el 
     * nombre del desarrolador indicando quien lo ha desarrollado y manteniendo 
     * los comentarios en los archivos del script, 
     * como esta aplicacion se entrega tal cual el creador no se hace responsable 
     * del uso o mal uso de la misma, en lo referido al soporte el creador intentara 
     * dar el soporte necesario pero dejando en claro que es meramente voluntario.
     * 
     * @package MyRad4PHP    
     * @author Jorge Luis Prado Ancí
     * @copyright http://myrad4php.wordpress.com
     * @version 0.59
     * @access public
     */
    require("../../config/setings.php");
    require('../../config/setup.php');
    $err=array();
    
    $smarty=new Smarty_myrad4php();
    setidioma($smarty);
    islogin($smarty);
    if(file_exists($GLOBALS["ruta"]."secure.php"))
    {
        if(!isset($_SESSION["useract"])) 
            header("Location: ".$GLOBALS["basepath"]."login.php");
        else
        {
            
            $c= $_SESSION["useract"];
            $smarty->assign("nomuser",$c["nombre"]);
        }
    }
    if(exist_f_or_d($_GET["tabla"],"details.php"))
    {
        header("Location: ".$GLOBALS["basepath"]."swdd/custom_pages/".$_GET["tabla"]."/details.php?tabla=".$_GET["tabla"]."&idreg=".$_GET["idreg"]);
    }
    
    $dc = new datacontex();
    $filst=array();
    $pkcampo="";
    if(isset($_POST["cancelar"]))
    {
            header("Location: list.php?tabla=".$_GET["tabla"]);
    }
    if(isset($_POST["aceptar"]))
    {
            header("Location: edit.php?tabla=".$_GET["tabla"]."&idreg=".$_GET["idreg"]);
    }    
    if(isset($_GET["idreg"]))
    {
        $objentity=$dc->tablas[$_GET["tabla"]];
        
        foreach($objentity->metatabla->aCampos as $metacampo)
        {
            if($metacampo->espk)
                $pkcampo=$metacampo->nombre;
        }
        
        $objentity->filter(array(array("campo"=>$pkcampo,"valor"=>"=".$_GET["idreg"])));
        
        $smarty->assign("error",$err);
        $smarty->assign("titulo",$objentity->metatabla->displayname);
        $smarty->assign('acampos',getdetails($objentity,$objentity->registros[0]->toarray()));
        $smarty->assign('tabla',$_GET["tabla"]);
        $smarty->assign('idregistro',$_GET["idreg"]);
        
    }
    
    
     if(file_exists($GLOBALS["ruta"]."templates/template/custom_pages/".$_GET["tabla"]."/details.tpl"))
        $smarty->display($GLOBALS["ruta"]."templates/template/custom_pages/".$_GET["tabla"]."/details.tpl");
     else
        $smarty->display('details.tpl');
   



        
?>
