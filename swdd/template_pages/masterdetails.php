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
    if(exist_f_or_d($_GET["tabla"],"masterdetails.php"))
        header("Location: ".$GLOBALS["basepath"]."swdd/custom_pages/".$_GET["tabla"]."/masterdetails.php?tabla=".$_GET["tabla"]);
    
    if(isset($_POST["cancelar"]))
        header("Location: list.php?tabla=".$_GET["tabla"]);
    
    $dc = new datacontex();
    $filst=array();
    $pkcampo="";
    $avals=array();
    if(!isset($_POST["aceptar"]))
    {
        /*$tmp1 = new ventasdet();
        $aVals['idventasdet']=0;
        $aVals['idventacab']=0;
        $aVals['idstock']=1;
        $aVals['cantidad']=10;
        $aVals['precio']=null;
        $aVals['importe']=null;
        $objrec=new ventasdet();
        $dctmp = new datacontex();
        $objdet=$dctmp->tablas["ventasdet"];
        $objrec=$objdet->completefk($aVals,$objrec);

        print_r($objrec);
        /*
        private $idventasdet;
		private $idventacab;
		public $_ventascab;
		private $idstock;
		public $_stocks;
		private $cantidad;
		private $precio;
		private $importe;
        */
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
        //obtener los campos de la tabla maestra
        $acamposget = getfields($objentity,$avals,1);
        $smarty->assign("titulo",$objentity->metatabla->displayname);
        $smarty->assign('err',array());
        $smarty->assign('error',array());
        $smarty->assign('acampostop',$acamposget[0]);
        $smarty->assign('acamposbutton',$acamposget[1]);
        $smarty->assign('tabla',$_GET["tabla"]);
        $smarty->assign('tabledetails',$objentity->metatabla->tabledetail);
        
        //crear la cuadricula del detalle
        $g=new cuadricula($objentity,$smarty,true,true,true,false,true,true,true);
        $g->maketable();
        
        //traer los campos del detalle para el insert-details
        eval("\$obj=new ".$objentity->metatabla->tabledetail."();");
        $objentitydeta=$dc->tablas[$objentity->metatabla->tabledetail];
        $avals=$obj->toarray();
        $acamposgetdeta = getfields($objentitydeta,$avals);
        $smarty->assign('acamposdeta',$acamposgetdeta );
        
    }
    $smarty->display("masterdetails.tpl");
        
?>