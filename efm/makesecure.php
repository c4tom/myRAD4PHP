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
     session_start();
    include("setings.php");
    include("../config/setup.php");
     require_once("../config/idiomascfg.php");
   	
    
	require($GLOBALS["ruta"].$GLOBALS['destinodal']."/metadata.php");
	require($GLOBALS["ruta"].$GLOBALS['destinodal']."/datacontext.php");
    
    require($GLOBALS["ruta"].$GLOBALS['destinodal']."/dalall.php");
    $err=array();
    
    
    if(isset($_POST["procesar"]))
    {
        $campousuario = $_POST["cbousuario"];
        $campoclave = $_POST["cboclave"];
        $nomuser =  $_POST["cbonomuser"];
        $tabla = $_GET["tabla"];
        $cad="<?php\n";
        $cad.="\$GLOBALS[\"cmpusuario\"]=\"".$campousuario."\";\n";
        $cad.="\$GLOBALS[\"cmpclave\"]=\"".$campoclave."\";\n";
        $cad.="\$GLOBALS[\"cmpnomuser\"]=\"".$nomuser."\";\n";
        $cad.="\$GLOBALS[\"tablasecur\"]=\"".$tabla."\";\n";
        $cad.="?>";
        if(file_exists($GLOBALS["ruta"]."config/secure.php"))
        {
            unlink($GLOBALS["ruta"]."config/secure.php");
        }
        $file = fopen($GLOBALS["ruta"]."config/secure.php",'x+');   
        fwrite($file,$cad);
        fclose($file);
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'index.php';
        echo 'La aplicacion ha sido generada ingrese a: <a href="'.$GLOBALS["basepath"].$extra.'">Indice</a> <br>';
        echo 'Si desea generar un menu ingrese al generador de menus <a href="'.$GLOBALS["basepath"]."efm/mnubuillder.php".'">Generador de menus</a> <br>';
        echo 'Usted podra acceder al generador de menus en otro momento mediante la siguiente URL <br>';
        echo $GLOBALS["basepath"]."efm/mnubuillder.php";
        echo "Es recomendable generar el menu despues de cambiar las etiquetas de displayname de las tablas";
        //header("Location: http://$host$uri/$extra");
    }
    else
    {
        if(file_exists($GLOBALS["ruta"]."config/secure.php"))
        $err[]= "Se sobreescribira el archivo de configuraciones de seguridad actual";
        $dc = new datacontex();
        $oTabla = $dc->tablas[$_GET["tabla"]];
        $aCasmpos=array();
        foreach($oTabla->metatabla->aCampos as $metacampo)
            $aCampos[]=$metacampo->nombre;
        $smarty = new Smarty_myrad4php();
        $configidioma= new admin_idiomas();
        $configidioma->setsmartylabels($smarty,$_SESSION["idiomasel"]);
        $smarty->assign("nomuser","");
        $smarty->assign("titulo","");
        $smarty->assign("error",$err);
        $smarty->assign("aCampos", $aCampos);
        $smarty->assign("tabla", $_GET["tabla"]);
        $smarty->display("makesecure.tpl");
    }
        
    
?>