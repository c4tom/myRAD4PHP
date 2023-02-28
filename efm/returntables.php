<?php
    require("../config/setings.php");
    require('../config/setup.php');
    $dc = new datacontex();
    if(isset($_POST["accion"]))
    {
        switch($_POST["accion"])
        {
            case "gettables":
                $atablas = array();
                foreach($dc->tablas as $key =>$value)
                {
                    $valor = $value->metatabla->displayname;
                    $elem=array("nomtabla"=>$valor,"url"=>$GLOBALS["basepath"]."swdd/template_pages/list.php?tabla=".$key);
                    $atablas[]=$elem;
                }
                echo json_encode($atablas,JSON_FORCE_OBJECT);
                break;
            case "getxml":
                $xml = new XMLFile();
                $fh = fopen( $GLOBALS["ruta"].'config/menuxml.xml', 'r' );
                $xml->read_file_handle( $fh );
                fclose( $fh );
                $root = &$xml->roottag;
                $aregistros=xml2array($root );
                $mnu = new menubuillder($aregistros,"dropdownmenu");
                            
                //echo json_encode($aregistros,JSON_FORCE_OBJECT);
                echo json_encode($mnu->makemenubuilder(),JSON_FORCE_OBJECT);
                break;
            case "saveXML":
                $retornar = "";
                $fh = fopen($GLOBALS['ruta'].'config/menuxml.xml', 'w' );
                $n=fwrite($fh,$_POST["datos"]);
                fclose( $fh );                
                if($n==false)
                    echo json_encode("Error to write file in config/menuxml.xml",JSON_FORCE_OBJECT);
                else
                    echo json_encode("Menu write in config/menuxml.xml",JSON_FORCE_OBJECT);
                break;
        }
    }
    
?>