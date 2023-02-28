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
    include('config/setings.php');
    include('config/setup.php');
    include('config/secure.php');
    
    //echo $lst->compareobjects($lst->getItem(0),$lst->getItem(1));
    $smarty = new Smarty_myrad4php();
    $err=array();
    setidioma($smarty);
    unset($_SESSION["useract"]);   
    if(isset($_POST["procesar"]))
    {
        //todo el trabajo a los objetos para que si se quiere modificar 
        //el contenido de cualquiera de las propiedades se hagan en el objeto asi
        //evitamos programar en las plantillas
        eval("\$objlogin = new ".$GLOBALS["tablasecur"]."();");
        $cadena="\$objlogin->".$GLOBALS["cmpusuario"]."=\"".$_POST["user"]."\";";
        eval($cadena);
        $cadena="\$objlogin->".$GLOBALS["cmpclave"]."=\"".$_POST["clave"]."\";";
        eval($cadena);
        eval("\$usuario=\$objlogin->".$GLOBALS["cmpusuario"].";");
        eval("\$clave=\$objlogin->".$GLOBALS["cmpclave"].";");
        $dc=new datacontex();        
        $objsecur = $dc->tablas[$GLOBALS["tablasecur"]];
        
        $aparametros=array();
        $aparametros[]=array("campo"=>$GLOBALS["cmpusuario"], "valor"=>"='".$usuario."'");
        $aparametros[]=array("campo"=>$GLOBALS["cmpclave"], "valor"=>"='".$clave."'");
        $objsecur->filter($aparametros);
        
        if($objsecur->numregs==0)
            $err[]="EL usuario no existe";
        else
            if($objsecur->numregs==1)
            {
                $objact=$objsecur->registros[0];
                $_SESSION["useract"]=$objact->toarray();
                header("Location: index.php");
            }
    }
       
    $smarty->assign("nomuser","");
    $smarty->assign("error",$err);
    $smarty->assign("titulo","Acceso al sistema");
    $smarty->display("login.tpl");
?>
