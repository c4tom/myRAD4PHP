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
     * 
     */
    require("../../config/setings.php");
    require('../../config/setup.php');
    $smarty=new Smarty_myrad4php();
    $err=array();
    setidioma($smarty);
    islogin($smarty);
    if(exist_f_or_d($_GET["tabla"],"insert.php"))
        header("Location: ".$GLOBALS["basepath"]."swdd/custom_pages/".$_GET["tabla"]."/insert.php?tabla=".$_GET["tabla"]);
    
    if(isset($_POST["cancelar"]))
        header("Location: list.php?tabla=".$_GET["tabla"]);
    
    $dc = new datacontex();
    $filst=array();
    $pkcampo="";
    $avals=array();
    if(!isset($_POST["aceptar"]))
    {
        eval("\$obj=new ".$_GET["tabla"]."();");
        $objentity=$dc->tablas[$_GET["tabla"]];
        $avals=$obj->toarray();
        if($objentity->metatabla->readonly)
            header("Location: ".$GLOBALS["basepath"]."swdd/template_pages/list.php?tabla=".$_GET["tabla"]);
        foreach($objentity->metatabla->aCampos as $metacampo)
        {
            if($metacampo->espk)
                $pkcampo=$metacampo->nombre;
            
            if(isset($metacampo->defaultvalue))
                $avals[$metacampo->nombre]=$metacampo->defaultvalue;
        }
        $smarty->assign('acampos',getfields($objentity,$avals));
        $smarty->assign('tabla',$_GET["tabla"]);
    }
    else
    {
        if(isset($_POST["aceptar"]))
        {
            print_r($_POST);
            eval("\$obj=new ".$_GET["tabla"]."();");                  
            $objentity=$dc->tablas[$_GET["tabla"]];
            $obj=$objentity->completefk($_POST,$obj);
            $obj->manual($_POST);
            
            
            $err = valida($obj->toarray(),$objentity);
            if(sizeof($err)>0)
            {
                $smarty->assign("error",$err);
                $smarty->assign('acampos',getfields($objentity,$avals));
                $smarty->assign('tabla',$_GET["tabla"]);
            }
            else
            {
                $smarty->assign('acampos',getfields($objentity,$obj->toarray()));
                $smarty->assign('tabla',$_GET["tabla"]);
                $obj->manual(checkedtobool($obj->toarray(),$objentity));
                $obj->esnuevo=true;
                $objentity->registros[]=$obj;
                $cad =$objentity->savechanges();
                if(strlen($cad)>0)
                    $err[]=$cad;
                else
                    header("Location: list.php?tabla=".$_GET["tabla"]);
            }
        }
    }
    $smarty->assign("error",$err);
    $smarty->assign("titulo",$objentity->metatabla->displayname);
    if(file_exists($GLOBALS["ruta"]."templates/template/custom_pages/".$_GET["tabla"]."/insert.tpl"))
        $smarty->display($GLOBALS["ruta"]."templates/template/custom_pages/".$_GET["tabla"]."/insert.tpl");
    else
        $smarty->display('insert.tpl');
?>
