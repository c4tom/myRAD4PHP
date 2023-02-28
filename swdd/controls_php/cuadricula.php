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
class cuadricula
{
    public $objentidad;
    public $smarty;
    public $modificar;
    public $eliminar;
    public $detalles;
    public $simple;
    public $check;
    public $empty;
    public $isdetail;
    function __construct($_objentidad,$_smarty,$_modificar=true,$_eliminar=true,$_detalles=true, $_simple=false, $_check=true, $_empty=false, $_isdetail=false)
    {
        $this->isdetail=$_isdetail;
        if($this->isdetail)
        {
            $cad=$_objentidad->metatabla->tabledetail;
            $dc = new datacontex();
            $this->objentidad=$dc->tablas[$cad];
        }
        else
            $this->objentidad=$_objentidad;
        $this->smarty=$_smarty;
        $this->modificar=$_modificar;
        $this->eliminar=$_eliminar;
        $this->detalles=$_detalles;    
        $this->simple=$_simple;
        $this->check=$_check;
        $this->empty=$_empty;
        
    }
    public function maketable()
    {
        $titorder=array();
        $acamposmetaordenados=array();
        $k=0;
        if(!$this->simple)
        {
            if($this->check)
            {
                $aTitulos[$k] ="";
                $tdatt[$k]="width=\"30px\" class=\"td\"";
                $k++;
            }
            if($this->modificar==true || $this->eliminar==true || $this->detalles==true)
            {
                $aTitulos[$k] =$GLOBALS["operacioneslabel"];
                $tdatt[$k]="width=\"auto\" class=\"td\"";
                $k++;
            }
        }
        else
            $k=0;
        
                
        
        foreach($this->objentidad->metatabla->aCampos as $campometa)
        {
            if($campometa->mostrar)
            {
                $acamposmetaordenados[$campometa->posicion]=$campometa;
                $aTitulos[$k] = $campometa->displayname;
                $titorder[$k] = $campometa->displayname;
                $k++;
            }
        }
        $aCamposmeta=array();
        $atdformat=array();
        foreach($acamposmetaordenados as $acampoordenado)
        {
            $campometa=$acampoordenado;
            $aCamposmeta[]=array($campometa->nombre,$campometa->displayname);
            
                switch($campometa->tipo)
                {
                    case "decimal":
                        if($campometa->esfk!=1)
                            if($campometa->espk!=1)
                                $tdatt[]="width=\"auto\" class=\"td\" align=\"right\"";
                            else
                                $tdatt[]="width=\"auto\" class=\"td\"";
                        else
                            $tdatt[]="width=\"auto\" class=\"td\"";
                        break;
                    case "integer":
                        if($campometa->esfk!=1)
                            if($campometa->espk!=1)
                                $tdatt[]="width=\"auto\" class=\"td\" align=\"right\"";
                            else
                                $tdatt[]="width=\"auto\" class=\"td\"";
                        else
                            $tdatt[]="width=\"auto\" class=\"td\"";                                
                        break;
                    case "float":
                        if($campometa->esfk!=1)
                            if($campometa->espk!=1)
                                $tdatt[]="width=\"auto\" class=\"td\" align=\"right\"";
                            else
                                $tdatt[]="width=\"auto\" class=\"td\"";
                        else
                            $tdatt[]="width=\"auto\" class=\"td\"";                                
                        break;
                    default:
                        $tdatt[]="width=\"auto\" class=\"td\"";
                        break;
                }
            
        }
        $n=0;
        $this->smarty->assign("aCamposmeta",$aCamposmeta);
        $this->smarty->assign("columnames",$aTitulos);
        $this->smarty->assign("titulos",$titorder);
        $aDatos=array();
        
        $atotales = array();
        if(!$this->simple)
        {
            if($this->check)
                $atotales["check"]="";
            if($this->modificar==true || $this->eliminar==true || $this->detalles==true)
                $atotales["opciones"]="";
        }
         if(!$this->empty)
         {
            foreach($this->objentidad->registros as $registro)
            {
                if($n==$this->objentidad->numcols)
                    $n=0;
                $cad="";
                $pk="";
                
                foreach($acamposmetaordenados as $campometa)
                {
                    eval("\$valor=\$registro->".$campometa->nombre.";");
                    if($campometa->espk==true)         
                        $pk=$valor;
                }
                if(!$this->simple)
                {
                    
                    if($this->check)
                        $aDatos[]="<input type=\"checkbox\" name=\"idreg_".$pk."\" id=\"idreg_".$pk."\"/>";
                    if($this->modificar==true)
                        $cad.="<a href='".$GLOBALS["basepath"]."swdd/template_pages/edit.php?tabla=".$this->objentidad->nomtabla."&idreg=".$pk."'>".$GLOBALS["editlabel"]." </a>";
                    if($this->eliminar==true)
                        $cad.="<a href='list.php?tabla=".$this->objentidad->nomtabla."&idreg=".$pk."&action=eliminar' onclick ='return confirm(\"Esta seguro de eliminar este registro?\");' >".$GLOBALS["deletelabel"]." </a>";
                    if($this->detalles==true)
                        $cad.="<a href='details.php?tabla=".$this->objentidad->nomtabla."&idreg=".$pk."'>".$GLOBALS["detailslabel"]." </a>";
                    if(strlen($cad)>0)
                        $aDatos[]=$cad;
                }
                
                foreach($acamposmetaordenados as $acampoordenado)
                {
                    $campometa=$acampoordenado;
                    if($campometa->mostrar)
                    {
                        if(!$this->empty)
                        {
                        if($campometa->totalizar==1)
                        {
                            eval("\$valor=\$registro->".$campometa->nombre.";");
                            if(!isset($atotales[$campometa->nombre]))
                                $atotales[$campometa->nombre]=$valor;
                            else
                                $atotales[$campometa->nombre]=$atotales[$campometa->nombre]+$valor;
                        }
                        else
                            $atotales[$campometa->nombre]="";
                            if($campometa->esfk==1)                           
                            {
                                //eval( "\$c=\$registro->".$campometa->nombre."; ");                            
                                eval("\$c=\$registro->_".$campometa->tablarelacion."->tostring();");                            
                                $aDatos[]="<a href='list.php?tabla=".$campometa->tablarelacion."'>".$c."</a>";
                            }
                            else
                            {
                                eval("\$aDa=\$registro->".$campometa->nombre.";");
                                switch($campometa->tipo)
                                {
                                case "bool":
                                {
                                    if($aDa=="1")
                                        $aDatos[]=$GLOBALS["yeslabel"];
                                    else
                                        $aDatos[]=$GLOBALS["notlabel"];
                                    break;
                                }
                                case "datetime":
                                    {
                                        if($campometa->subtipo=="date")
                                            eval("\$aDatos[]=substr(\$registro->".$campometa->nombre.",0,10);");
                                        else
                                            eval("\$aDatos[]=substr(\$registro->".$campometa->nombre.",10);");
                                        break;
                                        
                                    }                                
                                default:
                                    eval("\$valor=\$registro->".$campometa->nombre.";");
                                    if(strlen($valor)>60)
                                    $valor = trim(substr($valor,0,60))."...";
                                    $aDatos[]=$valor;
                                    break;    
                                }
                            }
                        }
                        
                    }
                }
                $n++;
            }
         }
        foreach($atotales as $tot)
            $aDatos[]=$tot;
        $this->smarty->assign('tdat',$atdformat);
        $this->smarty->assign('titulo',"");
        $this->smarty->assign('data',$aDatos);
        $this->smarty->assign('td',$tdatt);
        
    }
    private function getpk()
    {
        $retornar="";
        foreach($this->objentidad->metatabla->aCampos as $campometa)
        {
            if($campometa->espk==true)
            {
                $retornar=$campometa->nombre;
            }
        }
        return $retornar;
    }
}
?>