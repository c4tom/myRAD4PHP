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


function setidioma($smarty)
{
    include($GLOBALS["ruta"]."config/idiomas/".$GLOBALS['idiomafile']);
    $smarty->assign("userlabel",$GLOBALS["userlabel"]);
    $smarty->assign("passwordlabel",$GLOBALS["passwordlabel"]);
    $smarty->assign("datelabel",$GLOBALS["datelabel"]);
    $smarty->assign("logoutlabel",$GLOBALS["logoutlabel"]);
    $smarty->assign("loginlabel",$GLOBALS["loginlabel"]);
    $smarty->assign("logintitle",$GLOBALS["logintitle"]);
    $smarty->assign("homelabel",$GLOBALS["homelabel"]);
    $smarty->assign("titleindex",$GLOBALS["titleindex"]);
    $smarty->assign("titlelist",$GLOBALS["titlelist"]);
    $smarty->assign("operacioneslabel",$GLOBALS["operacioneslabel"]);
    $smarty->assign("insertlabel",$GLOBALS["insertlabel"]);
    $smarty->assign("filterlabel",$GLOBALS["filterlabel"]);
    $smarty->assign("unfilterlabel",$GLOBALS["unfilterlabel"]);
    $smarty->assign("sortbylabel",$GLOBALS["sortbylabel"]);
    $smarty->assign("sortlabel",$GLOBALS["sortlabel"]);
    $smarty->assign("hidesort",$GLOBALS["hidesort"]);
    $smarty->assign("editlabel",$GLOBALS["editlabel"]);
    $smarty->assign("deletelabel",$GLOBALS["deletelabel"]);
    $smarty->assign("detailslabel",$GLOBALS["detailslabel"]);
    $smarty->assign("delselectslabel",$GLOBALS["delselectslabel"]);
    $smarty->assign("noselectlabel",$GLOBALS["noselectlabel"]);
    $smarty->assign("acceptlabel",$GLOBALS["acceptlabel"]);
    $smarty->assign("cancellabel",$GLOBALS["cancellabel"]);
    $smarty->assign("inserttitlelabel",$GLOBALS["inserttitlelabel"]);
    $smarty->assign("edittitlelabel",$GLOBALS["edittitlelabel"]);
    $smarty->assign("detailstitlelabel",$GLOBALS["detailstitlelabel"]);
    $smarty->assign("returnlistlabel",$GLOBALS["returnlistlabel"]);
    $smarty->assign("msgdeletelabel",$GLOBALS["msgdeletelabel"]);
    $smarty->assign("yeslabel",$GLOBALS["yeslabel"]);
    $smarty->assign("notlabel",$GLOBALS["notlabel"]);
    $smarty->assign("printlabel",$GLOBALS["printlabel"]);
    $smarty->assign("pageorientationlabel",$GLOBALS["pageorientationlabel"]);
    $smarty->assign("alabeslorientation",$GLOBALS["alabeslorientation"]);
    $smarty->assign("datefromlabel",$GLOBALS["datefromlabel"]);
    $smarty->assign("datetolabel",$GLOBALS["datetolabel"]);
    
}
function filesinfolder($folder)
{
    $aFiles=array();
    $d = dir($folder);
    while (false !== ($entry = $d->read())) {
        if(substr($entry,0,1)!=".")
            $aFiles[]=$entry;
    }
    $d->close();
    return $aFiles;
}
function getdetails($entidad,$objentity)
{
    $dc=new datacontex();
    $acamposOrdenados=array();
    $pkcampo = "";
    $acampos=array();
    
    foreach($entidad->metatabla->aCampos as $metacampo)
    {
        $acamposOrdenados[$metacampo->posicion]=$metacampo;
        if($metacampo->espk)
            $pkcampo=$metacampo->nombre;
    }
 
   
    foreach($acamposOrdenados as $metacampo)
    {
        $campo=array();
        $campo[0]=$metacampo->displayname;
        if($metacampo->esfk)
        {
            $a=$objentity[$metacampo->nombre];
            eval("\$a=\$entidad->registros[0]->_".$metacampo->tablarelacion."->tostring();");            
            $campo[1]=$a;                        
        }
        else
        {

            $a=$objentity[$metacampo->nombre];
            switch($metacampo->tipo)
            {
                case "bool":
                    if($a==1)
                        $campo[1]=$GLOBALS["yeslabel"];
                    else
                        $campo[1]=$GLOBALS["notlabel"];
                    break;
                case "datetime":
                    if($metacampo->subtipo=="date")
                        $campo[1]=substr($a,0,10);
                    else
                        if($metacampo->subtipo=="time")
                            $campo[1]=substr($a,10); 
                        else
                            $campo[1]=$a;
                                             
                    break;
                default:
                    $campo[1]=$a;
                    break;    
            }
                
        }
    
        $acampos[]=array($metacampo->nombre=>$campo);
        
    } 
    return $acampos;
}  
function checkedtobool($obj,$objentity)
{
    
    foreach($objentity->metatabla->aCampos as $metacampo)
    {
        $a=$metacampo->tipo;        
        $n=strcmp($a,"bool");
        if($n==0)
        {
            if(strtolower($obj[$metacampo->nombre])=="on")
                $obj[$metacampo->nombre]=1;
            else
                $obj[$metacampo->nombre]=0;
        }
        if($metacampo->tipo=="decimal")
            $obj[$metacampo->nombre]=(float)$obj[$metacampo->nombre];
    }
    return $obj;
}
function valida($obj,$objentity)
{    
    $err=array();
    foreach($objentity->metatabla->aCampos as $metacampo)
    {
        if(substr($metacampo->nombre,0,1)!='_')
        {
            if($metacampo->requerido)
            {
                if(!$metacampo->readonly)
                {
                    $val=$obj[$metacampo->nombre];
                    if(strlen($val)==0)
                    {
                        if($metacampo->tipo!="bool")
                            $err[]="EL campo ".strtoupper($metacampo->displayname)." No puede estar vacio.";
                    }

                }    
            }
        }
    }
    return $err;
}
function getfields($entidad,$objentity,$espartido=0)
{
    $dc=new datacontex();
    $acamposOrdenados=array();
    $pkcampo = "";
    $acampos=array();
    $acampostop=array();
    $acamposbutton=array();
    $ncampos=0;
    
    foreach($entidad->metatabla->aCampos as $metacampo)
    {
        if($metacampo->mostrar)
        {
            $acamposOrdenados[$metacampo->posicion]=$metacampo;
            if($metacampo->espk)
                $pkcampo=$metacampo->nombre;
            $ncampos++;
        }
    }
    foreach($acamposOrdenados as $acamposOrdenado)
    {
        $metacampo=$acamposOrdenado;
        $campo=array();
        $campo["etiqueta"]=$metacampo->displayname;
        $campo["nombre"]=$metacampo->nombre;
        $campo["linkfields"]=$metacampo->linkfields;
        if($metacampo->esfk)
        {
            $campo["tipocontrol"]="controls_edit/fk_edit.tpl";
            $objconcat=$dc->tablas[$metacampo->tablarelacion];
            $objconcat->fill();
            $aindices=array();
            $aetiquetas=array();
            if($metacampo->requerido!=true)
            {
                $aindices[]="-1";
                $aetiquetas[]=$GLOBALS["noselectlabel"];
            }
            foreach($objconcat->registros as $rec)
            {
                eval("\$cad=\$rec->".$metacampo->camporelacion.";");
                $aindices[]=$cad;
                $aetiquetas[]=$rec->tostring();
            }
            $a="";
            $a=$objentity[$metacampo->nombre];
            $campo["indices"]=$aindices;
            $campo["etiquetas"]=$aetiquetas;
            $campo["valor"]=$a;
            
        }
        else
        {
            $campo["tipocontrol"]="label.tpl";
            
            switch($metacampo->tipocontrol)
            {
                
                case "string":
                {
                    $campo["tipocontrol"]="controls_edit/text_edit.tpl";  
                    break;
                }
                case "text":
                {
                    $campo["tipocontrol"]="controls_edit/text_edit.tpl";  
                    break;
                }
                case "integer":
                {
                    $campo["tipocontrol"]="controls_edit/integer_edit.tpl";        
                    break;
                }
                
                case "decimal":
                {
                    $campo["tipocontrol"]="controls_edit/decimal_edit.tpl";        
                    break;
                }
                case "float":
                {
                    $campo["tipocontrol"]="controls_edit/decimal_edit.tpl";        
                    break;
                }
                
                case "bool":
                {
                    $campo["tipocontrol"]="controls_edit/bool_edit.tpl";
                    break;
                }
                case "datetime":
                    $campo["tipocontrol"]="controls_edit/date_edit.tpl";
                    break;
                                
            }
            $campo["tamanio"]=$metacampo->ancho;
            $a=$objentity[$metacampo->nombre];
            if($metacampo->tipo=="bool")
                if($a==1)
                    $campo["valor"]="on";
                else
                    $campo["valor"]="Off";
            else
                $campo["valor"]=$a;
        }
        if($metacampo->readonly)
        {
            $campo["tipocontrol"]="label.tpl";
        }
        if($espartido==0)
            $acampos[$metacampo->nombre]=$campo;
        else
            if($metacampo->gotop)
                $acampostop[$metacampo->nombre]=$campo;
            else
                $acamposbutton[$metacampo->nombre]=$campo;                    
    }
    if($espartido==1)
        $acampos= array($acampostop,$acamposbutton);
    return $acampos;
}  

function islogin($smarty)
{
    if(file_exists($GLOBALS["ruta"]."config/secure.php"))
    {
        if(!isset($_SESSION["useract"])) 
            header("Location: ".$GLOBALS["basepath"]."login.php");
        else
        {
            $c= $_SESSION["useract"];
            $smarty->assign("nomuser",$c["nombre"]);
        }
    }
}
    function makefilters($objentidad,$smarty,$valsant=array())
    {
        $dc=new datacontex();
        $filtros=array();
        foreach($objentidad->metatabla->aCampos as $campo)
        {
            if(isset($valsant[$campo->nombre]))
                $valant=$valsant[$campo->nombre];
            else
                $valant="";
            if($campo->mostrar)
            if($campo->filtrar)
            {
                $c= $campo->filtroobject;
                $cvalorfiltro = "";
                if($c=="text")
                {
                    $objconcat=$dc->tablas[$campo->tablarelacion];
                    $objconcat->fill();
                    $aindices=array();
                    $aetiquetas=array();
                    $aindices[]="-1";
                    $aetiquetas[]=$GLOBALS["unfilterlabel"];
                    $includefile="filter_text.tpl";
                    
                    foreach($objconcat->registros as $rec)
                    {
                        eval("\$cad=\$rec->".$campo->camporelacion.";");
                        if($valant==$cad)
                            $cvalorfiltro=$rec->tostring();
                        $aindices[]=$cad;
                        $aetiquetas[]=$rec->tostring();
                    }

                    $filtros[]=array($campo->nombre=>array($aetiquetas,$aindices,$includefile,$valant,$campo->displayname,$cvalorfiltro));
                }
                if($c=="bool")
                {
                    if($valant==1)
                        $cvalorfiltro=$GLOBALS["yeslabel"];
                    $filtros[]=array($campo->nombre=> array(array($GLOBALS["unfilterlabel"],$GLOBALS["yeslabel"],$GLOBALS["notlabel"]),array(-1,1,0),"filter_text.tpl",$valant,$campo->displayname,$cvalorfiltro));
                }
                if($c=="datetime")
                {   
                    $valsdate = array("valdesde"=>"","valhasta"=>"");
                    $cprint="";
                    if($campo->subtipo=="date")
                    {
                        $includefile="filter_date.tpl";
                        if(is_array($valant))
                            if(sizeof($valant)>0)
                            {
                                $valsdate = array("valdesde"=>$valant[0],"valhasta"=>$valant[1]);
                                $cprint=$GLOBALS["datefromlabel"].": ".$valant[0]." ".$GLOBALS["datetolabel"].": ".$valant[1];
                            }
                            else
                                $valsdate = array("valdesde"=>date("Y-m-d"),"valhasta"=>date("Y-m-d"));
                        $filtros[]=array($campo->nombre=>array($campo->displayname,$valsdate,$includefile,$cprint,$campo->displayname,$cprint));
                    }
                    else
                    {
                        $includefile="filter_time.tpl";
                    }
                    
                }
            }
        }
        $smarty->assign('tabla',$objentidad->nomtabla);
        $smarty->assign('filtros',$filtros);        
    }
    function exist_f_or_d($nametable,$page)
    {
          if(file_exists($GLOBALS["ruta"]."swdd/custom_pages/".$nametable."/".$page))
            return true;
        else
            return false;
    }
    function gendatetime($row,$prefijo)
    {
        $cadformat = $GLOBALS["dateformat"];
        $separator =$GLOBALS["dateseparator"];
        $fechacad="";
        switch($cadformat)
        {
            case "yyyy".$separator ."mm".$separator."dd":
                $fechacad=$row[$prefijo."Year"].$separator.$row[$prefijo."Month"].$separator.$row[$prefijo."Day"];
                break;        
            case "dd".$separator."mm".$separator."yyyy":
                $fechacad=$row[$prefijo."Day"].$separator.$row[$prefijo."Month"].$separator.$row[$prefijo."Year"];
                break;        
            case "mm".$separator."dd".$separator."yyyy":
                $fechacad=$row[$prefijo."Month"].$separator.$row[$prefijo."Day"].$separator.$row[$prefijo."Year"];
                break;                        
        }
                
    	return $fechacad;
    }
    function makegridini($tablas)
    {
        $tbls=array();
        foreach($tablas as $tabla)
        {
            $tbls[]="<a href=\"swdd/template_pages/list.php?tabla=".$tabla->nombre."\">".$tabla->metatabla->displayname."</a>";
        }
        return $tbls;
    }
    function makemenu($dc)
    {
        $cad="";
        $cad.="<ul>\n";
        $agrupos=array();
        $agrupind=array();
        foreach($dc->tablas as $tabla)
        {
            $agrupos[]=array($tabla->metatabla->grupo=>$tabla->metatabla->displayname);
            $agrupind[$tabla->metatabla->grupo]=$tabla->metatabla->grupo;
            $cad.="<li><a href='".$GLOBALS["ruta"]."list.php?tabla=".$tabla->nomtabla."'>".$tabla->metatabla->displayname."</a></li>\n";
        }
        print_r("<ul>\n");
        foreach($agrupind as $indice)
        {
            print_r("<li><a href=''>".$indice."</a></li>\n");
            print_r("<ul>\n");
            foreach($agrupos as $enlace)
            {
                if(strlen($enlace[$indice])>0)
                    print_r("<li><a href=''>".$enlace[$indice]."</a></li>\n");
            }
            print_r("</ul>\n");
        }
        print_r("</ul>\n");
        
        ksort($agrupos);
        print_r($agrupos);
    }

        function compareobjects($obj1,$obj2)
         {
             $resultado = false;
             //creo los objetos basados en ReflectionClass
             $refObj1 = new ReflectionClass($obj1);
             $refObj2 = new ReflectionClass($obj2);
             //voy a comparar si ambos objetos tienen el mismo nombre de clase
             if($refObj1->getName()==$refObj2->getName() )
             {
                 //obtengo las propiedades de cada uno de los objetos
                 $aProp1=$refObj1->getProperties();
                 $aProp2=$refObj2->getProperties();
                 //voy a iterar entre todas las propiedades de los objetos
                 //como ya determine que ambos son de la misma clase
                 //ambos tienen la misma cantidad de propiedades
                 for($k=0;$k<sizeof($aProp2);$k++)
                 {
                     //si la propiedad es privada la coloco como accesible
                     if($aProp1[$k]->isPrivate())
                     {
                         $aProp1[$k]->setAccessible(true);
                         $aProp2[$k]->setAccessible(true);
                     }
                     //si la propiedad es protegida la coloco como accesible
                     if($aProp1[$k]->isProtected())
                     {
                        $aProp1[$k]->setAccessible(true);
                        $aProp2[$k]->setAccessible(true);
                     }
                     //comparo ambos valores
                     if($aProp1[$k]->getValue($obj1)==$aProp2[$k]->getValue($obj2))
                        $resultado = true;
                     else
                     {
                     //si una de las propiedades no es igual en ambos objetos
                     //termino el for
                        $resultado=false;
                        break 1;
                     }
                 }
             }
             else
             $resultado = false;
             return $resultado ;
         }
                
?>
