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
    $smarty=new Smarty_myrad4php();
    setidioma($smarty);
    islogin($smarty);
    $posinis=array();
    $agrupos=array();
    
    if(exist_f_or_d($_GET["tabla"],"list.php"))
        header("Location: ".$GLOBALS["basepath"]."swdd/custom_pages/".$_GET["tabla"]."/list.php?tabla=".$_GET["tabla"]);
        
    $dc = new datacontex();
    $filst=array();
    $orderlst=array();
    $objentity=$dc->tablas[$_GET["tabla"]]; 
    
    $objentity->fill();
 
   if(isset($_GET["action"]))
       if($_GET["action"]=="eliminar")
           $objentity->delete($objentity->getbyid($_GET["idreg"]));
           
   if(isset($_GET["cantidad"]))
        $objentity->cantver=$_GET["cantidad"];
   else
        $objentity->cantver=10;
        
   if(isset($_GET["posini"]))
        $objentity->posact=$_GET["posini"];
   else
        $objentity->posact=0;
        
   $totreg=$objentity->numregs;
   $cantidad = $objentity->cantver;
   $maxpages=floor($totreg/$objentity->cantver);
   $err=array();
   
   if(strlen($GLOBALS["lasterror"])>0)
   {
        $err[]=$GLOBALS["lasterror"];
        $GLOBALS["lasterror"]="";
   }
   foreach($_POST as $key=>$valor)
   {
        if(substr($key,0,6)=="idreg_")
        {
            $idval=substr($key,6);
            $objentity->delete($objentity->getbyid($idval));
        } 
   }
   $smarty->assign("error",$err);
   
    if(isset($_POST["ordenar"]))
    {
       foreach($_POST as $key=>$valor)
       {
            if(substr($key,0,4)=="ord_")
            {
                $idval=substr($key,4);
                $orderlst[$idval]=$valor;
                if($valor==1)
                     $objentity->aOrders[]=$idval;
            } 
       }
    }    

    $smarty->assign("lstordenada",$orderlst);

    $afiltro=array();
    $smarty->assign("filtrar",1);
    foreach($objentity->metatabla->aCampos as $metacampo)
    {
        if(isset($_POST[$metacampo->nombre]))
        {
            if($_POST[$metacampo->nombre]!=-1)
            {
                $filst[$metacampo->nombre]=$_POST[$metacampo->nombre];
                
                switch($metacampo->filtroobject)
                {
                    case "text":
                        $afiltro[]=array("campo"=>$metacampo->nombre,"valor"=>"=".$_POST[$metacampo->nombre]);
                        break;
                    case "bool":
                        $afiltro[]=array("campo"=>$metacampo->nombre,"valor"=>"=".$_POST[$metacampo->nombre]);
                        break;
                }
                                          
            }
        }
        if(isset($_POST["date_from".$metacampo->nombre]))
        {
            if(strlen($_POST["date_from".$metacampo->nombre])>0)
            {
                if($metacampo->subtipo=="date")
                {
                    $filst[$metacampo->nombre]=array($_POST["date_from".$metacampo->nombre],$_POST["date_to".$metacampo->nombre]);
                    $afiltro[]=array("campo"=>$metacampo->nombre,"valor"=>">='".$_POST["date_from".$metacampo->nombre]."'");
                    $afiltro[]=array("campo"=>$metacampo->nombre,"valor"=>"<='".$_POST["date_to".$metacampo->nombre]."'");
                }
            }
        }
    }
    if(sizeof($afiltro)>0)
    {
        $objentity->filter($afiltro);
    }
    else
    {
        $smarty->assign("filtrar",0);
        $objentity->fill();
    }  
    
    if($objentity->metatabla->readonly)
        $g=new cuadricula($objentity,$smarty,false,false,true,false,false);
    else      
        $g=new cuadricula($objentity,$smarty);
        
    $g->maketable();
    makefilters($objentity,$smarty,$filst);
    $totreg=$objentity->numregs;
    $maxpages=floor($totreg/$objentity->cantver);
    for($k=0;$k<=$maxpages;$k++)
    {
        $agrupos[]=$k+1;
        $posinis[]=$k*$cantidad;                
    }
    $smarty->assign("error",$err);
    
    $smarty->assign("titulo",$objentity->metatabla->displayname);
    $smarty->assign("maxpages",$maxpages);
    $smarty->assign("posinis",$posinis);
    $smarty->assign("cantidad",$cantidad);
    $smarty->assign("grupos",$agrupos);
    if(isset($_POST["print"]))
    {
        $g=new cuadricula($objentity,$smarty,false,false,false,true,false);
        $g->maketable();
        $forptint=$smarty->fetch('printlist.tpl');
        $html2pdf = new HTML2PDF($_POST["pageorientation"],'A4');
        $html2pdf->WriteHTML($forptint);
        ob_end_clean();
        $html2pdf->Output('exemple.pdf');
    }
    if(file_exists($GLOBALS["ruta"]."templates/template/custom_pages/".$_GET["tabla"]."/list.tpl"))
        $smarty->display($GLOBALS["ruta"]."templates/template/custom_pages/".$_GET["tabla"]."/list.tpl");
    else
        $smarty->display('list.tpl');
        
  
?>
