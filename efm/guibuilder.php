<?
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
    
    if(!file_exists("setings.php"))
        header("Location: configapp.php");
    include("setings.php");
    include("../config/setup.php");
     require_once("../config/idiomascfg.php");
    $tablasprocesar=array();
    $generador = new haceclases();
    
    if(isset($_POST["procesar"]))
    {
        $afiles = $_POST["tablas"];
        $includesdal="<?php\n";
        $includesmeta="<?php\n";
        $configsecur=false;
        $tblsecur="";
        foreach($afiles as $tabla)
        {
            if(isset($_POST["opc_".$tabla]))
            {
                $opcact=$_POST["opc_".$tabla];
                foreach($opcact as $opciones)
                {
                    if($opciones==1)
                    {   
                        $contenido="<?php\n".$generador->makedalclass($tabla)."\n";
                        if(isset($_POST["conservar"]))
                            $a=filevalidator(true,"../".$GLOBALS['destinodal']."/".$tabla.".php");
                        else
                            $a=filevalidator(false,"../".$GLOBALS['destinodal']."/".$tabla.".php");
                        if(strlen($a)>0)
                            $contenido.=$a."*/\n?>";
                        else
                            $contenido.=$a."\n?>";
                        genfile("../".$GLOBALS['destinodal']."/".$tabla.".php",$contenido);
                    }
                    if($opciones==2)
                    {
                        $contenido="<?php\n".$generador->makemetadata($tabla)."\n";
                        if(isset($_POST["conservar"]))
                            $a=filevalidator(true,"../".$GLOBALS['destinodal']."/".$tabla."_meta.php");
                        else
                            $a=filevalidator(false,"../".$GLOBALS['destinodal']."/".$tabla."_meta.php");
                        if(strlen($a)>0)
                            $contenido.=$a."*/\n?>";
                        else
                            $contenido.=$a."\n?>";
                        genfile("../".$GLOBALS['destinodal']."/".$tabla."_meta.php",$contenido);
                    }
                    if($opciones==3)
                    {
                        $configsecur=true;
                        $tblsecur=$tabla;
                    } 
                    if($opciones==4)
                    {
                        //if(is_dir("../swdd/custom_pages/".$tabla))
                    }
                }
            }
            $includesdal.="include(\"".$tabla.".php\");\n";
            $includesmeta.="include(\"".$tabla."_meta.php\");\n";
        }
        $contenido= "<?php\n".$generador->makecontext($afiles);
        $a=filevalidator($_POST["conservar"],"../".$GLOBALS['destinodal']."/"."datacontext.php");
        if(strlen($a)>0)  
            $contenido.=$a."*/\n?>";
        else
            $contenido.=$a."\n?>";
        genfile("../".$GLOBALS['destinodal']."/"."datacontext.php",$contenido);
        $includesdal.="\n?>";
        $includesmeta.="\n?>";
        $contenido.=filevalidator($_POST["conservar"],"../".$GLOBALS['destinodal']."/"."dalall.php");
        genfile("../".$GLOBALS['destinodal']."/"."dalall.php",$includesdal);
        $contenido.=filevalidator($_POST["conservar"],"../".$GLOBALS['destinodal']."/"."metadata.php");
        genfile("../".$GLOBALS['destinodal']."/"."metadata.php",$includesmeta);
        if($configsecur==false)
            header("Location: ../index.php");
        else
            header("Location: makesecure.php?tabla=".$tblsecur);
    }
    
    $coneccion = $GLOBALS['coneccion'];
    $smarty1 = new Smarty_myrad4php();
    $configidioma= new admin_idiomas();
    $configidioma->setsmartylabels($smarty1,$_SESSION["idiomasel"]);
    $tablas = $coneccion->traetablas();
    $ids1=array(1,2,3);
    $nombres1=array($GLOBALS["ormlabel"],$GLOBALS["metadatalabel"], $GLOBALS["safetylabel"]);
    $atablas=array();
    while ($row = mysql_fetch_row($tablas)) 
    {
        $atablas[]=array($row[0],"opc_".$row[0],"secur_".$row[0],"perso_".$row[0]);
    }
    $smarty1->assign("destinodal",$GLOBALS['destinodal']."/");
    $smarty1->assign("tablas",$atablas);
    $smarty1->assign("opciones",array("ids"=>$ids1,"nombres"=>$nombres1));
    $smarty1->assign("valores",array(1,2));
    $smarty1->assign("nomuser","");
    $err=array();
    $smarty1->assign("error",$err);
    $smarty1->display('guibuilder.tpl');
  
    function genfile($archivo,$cadena)
    {
        $archivo=fopen($archivo,'x+');
        fwrite($archivo,$cadena);
        fclose($archivo);
            
    }   
    function filevalidator($conservar,$file)
    {
        $contenido="";
        if(file_exists($file))
        {
            if($conservar)
            {
                $contenido =substr(file_get_contents($file),5);
                 
            }
            unlink($file);
        }   
        if(strlen($contenido)>0)
            $contenido="\n/*".$contenido;     
        return $contenido;      
    }     

    
?>