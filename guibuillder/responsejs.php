<?php
    require("../config/setings.php");
    require('../config/setup.php');
    $dc = new datacontex();
    
    if(isset($_POST))
    {
        switch($_POST["function"])
        {
            case "getfieldsoftable":
                $acamposmetaordenados=array();
                $aCampos=array();
                $tabla = $dc->tablas[$_POST["parametros"]];
                foreach($tabla->metatabla->aCampos as $campometa)
                {
                    $acamposmetaordenados[$campometa->posicion]=$campometa;
                }
                foreach($acamposmetaordenados as $metacampo)
                {
                    $aCampos[]=array($metacampo->nombre,$metacampo->displayname);
                }            
                echo json_encode($aCampos);
                break;
        }
    }
    exit;
    
?>