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
       
require_once("../libs/smarty/Smarty.class.php");
require_once("utils.php");
require_once("../config/idiomascfg.php");
$sma=new Smarty();
$sma->setTemplateDir('../templates/template');
$sma->setCompileDir('../templates/templates_c/');
$sma->setConfigDir('../templates/configs/');
$sma->setCacheDir('../templates/cache/');
$configidioma= new admin_idiomas();
$configidioma->setsmartylabels($sma,$_SESSION["idiomasel"]);
$erro=array();
//.DIRECTORY_SEPARATOR
if(isset($_POST["procesar"]))
{
    $cad="<?php\n";
    $cad.="session_start();\n";
    $cad.="\$GLOBALS['database']=\"".$_POST["txtbdname"]."\";\n";
    $cad.="\$GLOBALS['servidor']=\"".$_POST["txtserver"]."\";\n";
    $cad.="\$GLOBALS['clave']=\"".$_POST["txtclave"]."\";\n";
    $cad.="\$GLOBALS['tiposerver']=1;\n";
    $cad.="\$GLOBALS['usuario']=\"".$_POST["txtuser"]."\";  \n";   
    $cad.="\$GLOBALS['appname']=\"".$_POST["txtappname"]."\";  \n";
    $cad.="\$GLOBALS['destinodal']=\"".$_POST["txtdestino"]."\";  \n";
    $cad.="\$GLOBALS['idiomafile']=\"".$_POST["cboidioma"]."\";  \n";
    $cad.="\$GLOBALS['lasterror']=\"\";\n";
    $cad.="\$GLOBALS[\"ruta\"]=realpath(dirname(__FILE__).'/..').'/';\n";
    $cad.="\$GLOBALS[\"basepath\"]='".$_POST["txtruta"]."';\n";
   
    $cad.="require(\$GLOBALS[\"ruta\"].\"libs/datamanager.php\");\n";
    $cad.="require(\$GLOBALS[\"ruta\"].\"efm/core.php\");\n";
    $cad.="require(\$GLOBALS[\"ruta\"].\"efm/clases.php\");\n";
    $cad.="require(\$GLOBALS[\"ruta\"].\"efm/loaderclass.php\");\n";
    $cad.="require_once(\$GLOBALS[\"ruta\"].\"efm/utils.php\");\n";
    $cad.="if(file_exists(\$GLOBALS[\"ruta\"].\"".$_POST["txtdestino"]."/dalall.php\"))\n";    
    $cad.="\trequire(\$GLOBALS[\"ruta\"].\"".$_POST["txtdestino"]."/dalall.php\");\n";
    $cad.="else\n";
    $cad.="\theader(\"Location: \".\$GLOBALS[\"ruta\"].\"efm/guibuilder.php\");\n";
    $cad.="if(file_exists(\$GLOBALS[\"ruta\"].\"".$_POST["txtdestino"]."/metadata.php\"))\n";
    $cad.="\trequire(\$GLOBALS[\"ruta\"].\"".$_POST["txtdestino"]."/metadata.php\");\n";
    $cad.="else\n";
    $cad.="\theader(\"Location: \".\$GLOBALS[\"ruta\"].\"efm/guibuilder.php\");\n";
    $cad.="if(file_exists(\$GLOBALS[\"ruta\"].\"".$_POST["txtdestino"]."/datacontext.php\"))\n";
    $cad.="\trequire(\$GLOBALS[\"ruta\"].\"".$_POST["txtdestino"]."/datacontext.php\");\n";
    $cad.="else\n";
    $cad.="\theader(\"Location: \".\$GLOBALS[\"ruta\"].\"efm/guibuilder.php\");\n";
    $cad.="require(\$GLOBALS[\"ruta\"].\"swdd/controls_php/cuadricula.php\");\n";
    $cad.="\$GLOBALS['coneccion']= new datamanager(\$GLOBALS['usuario'],\$GLOBALS['clave'],\$GLOBALS['servidor'],\$GLOBALS['tiposerver'],\$GLOBALS['database'],'');\n";        
    
    $cad.="/*\n";
    $cad.="va a comprender asi dos digitos para el mes, dos para el dia y cuatro para el año\n";
    $cad.="aceptados \n";
    $cad.="dd/mm/yyyy\n";
    $cad.="mm/dd/yyyy\n";
    $cad.="yyyy/mm/dd\n";
    $cad.="recuerde que este formato debe coincidir con el que soporta su base de datos\n";
    $cad.="*/\n";
    $cad.="\$GLOBALS[\"dateseparator\"]='/';\n";
    $cad.="\$GLOBALS[\"dateformat\"]='yyyy'.\$GLOBALS[\"dateseparator\"].'mm'.\$GLOBALS[\"dateseparator\"].'dd';\n";
    $cad.="?>";
    
    $cadbuilder="<?php\n";
    $cadbuilder.="\$GLOBALS['database']=\"".$_POST["txtbdname"]."\";\n";
    $cadbuilder.="\$GLOBALS['servidor']=\"".$_POST["txtserver"]."\";\n";
    $cadbuilder.="\$GLOBALS['clave']=\"".$_POST["txtclave"]."\";\n";
    $cadbuilder.="\$GLOBALS['tiposerver']=1;\n";
    $cadbuilder.="\$GLOBALS['usuario']=\"".$_POST["txtuser"]."\";  \n";   
    $cadbuilder.="\$GLOBALS['appname']=\"".$_POST["txtappname"]."\";  \n";
    $cadbuilder.="\$GLOBALS['destinodal']=\"".$_POST["txtdestino"]."\";  \n";
    $cadbuilder.="\$GLOBALS['lasterror']=\"\";\n";
    $cadbuilder.="\$GLOBALS[\"ruta\"]=realpath(dirname(__FILE__).'/..').'/';\n";
    $cadbuilder.="\$GLOBALS[\"basepath\"]='".$_POST["txtruta"]."';\n";
    $cadbuilder.="require(\$GLOBALS[\"ruta\"].\"libs/datamanager.php\");\n";
    $cadbuilder.="require(\$GLOBALS[\"ruta\"].\"efm/core.php\");\n";
    $cadbuilder.="require(\$GLOBALS[\"ruta\"].\"efm/clases.php\");\n";
    $cadbuilder.="require(\$GLOBALS[\"ruta\"].\"efm/loaderclass.php\");\n";
    $cadbuilder.="require_once(\$GLOBALS[\"ruta\"].\"efm/utils.php\");\n";
    $cadbuilder.="\$GLOBALS['coneccion']= new datamanager(\$GLOBALS['usuario'],\$GLOBALS['clave'],\$GLOBALS['servidor'],\$GLOBALS['tiposerver'],\$GLOBALS['database'],'');\n";        
    
    $cadbuilder.="/*\n";
    $cadbuilder.="va a comprender asi dos digitos para el mes, dos para el dia y cuatro para el año\n";
    $cadbuilder.="aceptados \n";
    $cadbuilder.="dd/mm/yyyy\n";
    $cadbuilder.="mm/dd/yyyy\n";
    $cadbuilder.="yyyy/mm/dd\n";
    $cadbuilder.="recuerde que este formato debe coincidir con el que soporta su base de datos\n";
    $cadbuilder.="*/\n";
    $cadbuilder.="\$GLOBALS[\"dateseparator\"]='/';\n";
    $cadbuilder.="\$GLOBALS[\"dateformat\"]='yyyy'.\$GLOBALS[\"dateseparator\"].'mm'.\$GLOBALS[\"dateseparator\"].'dd';\n";
    $cadbuilder.="?>";
    if(file_exists("setings.php"))
    {
        unlink("setings.php");
    }
        $file = fopen("setings.php",'x+');   
        fwrite($file,$cadbuilder);
        fclose($file);
    
    $file = fopen("../scripts/rutabase.js",'w');   
    fwrite($file,"var rutabase = '".$_POST["txtruta"]."';");
    fclose($file);
    
    if(!file_exists("../config/setings.php"))
    {
        $file = fopen("../config/setings.php",'x+');   
        fwrite($file,$cad);
        fclose($file);
        header("Location: guibuilder.php");
    }
    else
         $erro[]="El archivo: SETINGS.PHP ya existe, eliminelo antes de continuar";
}
else
{     
    if(isset($_POST["saltar"]))
        header("Location: guibuilder.php");
}
$sma->assign("indices",filesinfolder("../config/idiomas"));
$sma->assign("error",$erro);
$sma->display("configapp.tpl");
?>