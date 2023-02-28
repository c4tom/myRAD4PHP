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
    class haceclases
    {
        public $coneccion;
        function __construct() 
        {        
         $this->coneccion = $GLOBALS['coneccion'];
        }
        function makecontext($tablas)
        {
            $texto ="class datacontex\n";
            $texto .="{\n";
            //$tablas = $this->coneccion->traetablas();
            $texto .="\tpublic \$coneccion;\n";
            $texto .="\tpublic \$tablas;\n";
            foreach($tablas as $tabla)
            {
                $texto .="\tpublic \$".$tabla.";\n";
            }
            
            $texto .="\tfunction __construct()\n";
            $texto .="\t{\n";
            
            $texto .="\t\t\$this->coneccion = \$GLOBALS[\"coneccion\"];\n";
            foreach($tablas as $tabla)
            {
                $texto .="\t\t\$this->".$tabla."= new entidad(\"".$tabla."\");\n";
                $texto .="\t\t\$this->tablas[\"".$tabla."\"]= new entidad(\"".$tabla."\");\n";
            }
            $texto .="\t}\n";
            $texto .="}\n";
            return $texto;
            
        }
        function makedalclass($tabla)
        {
            $texto = "";
            //$tablas = $this->coneccion->traetablas();
            
                $texto ="\tclass ".$tabla."\n";
                $texto =$texto."\t{\n";
                $texto =$texto."\t\tpublic \$editado;\n";
                $texto =$texto."\t\tpublic \$esnuevo;\n";
                $campos = $this->coneccion->traeestructura($tabla);
                $texto1="";
                $textofill="\t\tpublic function fill(\$_id)\n";
                $textofill=$textofill."\t\t{\n";
                $textomanual="\t\t\tpublic function manual(\$row)"; 
                $listacampos = "\t\t\t\$arr=array();\n";
                $listacamposFill = "";
                $listacamposManual = "";
                $camposset="";
                $posi =0;
                $cpmost ="";
                while ($rowCol = mysql_fetch_row($campos))
                {
                    $textofk="";
                    $texto1 =$texto1."\t\tprivate $".$rowCol[0].";\n";
                    if($posi ==1)
                        $cpmost = $rowCol["0"];
                    $posi++;
                    if($rowCol[3]=="MUL")
                    {
                        $fksmeta =$this->getfksmetadata($tabla,$rowCol["0"]);
                        $texto1 =$texto1."\t\tpublic \$_".$fksmeta->tablaRelacion.";\n";
                        $textofk="\t\t\t\$this->_".$fksmeta->tablaRelacion."= new ".$fksmeta->tablaRelacion."();\n";
                        $listacamposManual=$listacamposManual."\t\t\tif(isset(\$row[\"_".$fksmeta->tablaRelacion."\"]))\n";
                        $listacamposManual=$listacamposManual."\t\t\t\t\$this->_".$fksmeta->tablaRelacion."=\$row[\"_".$fksmeta->tablaRelacion."\"];\n";
                    }                                       
                    $listacampos=$listacampos."\t\t\t\$arr[\"".$rowCol[0]."\"]=\$this->".$rowCol[0].";\n";
                    
                    $listacamposFill.="\t\t\t\$this->".$rowCol[0]."=\"\";\n";
                    $listacamposManual=$listacamposManual."\t\t\t\$this->__set(\"".$rowCol[0]."\",\$row[\"".$rowCol[0]."\"]);\n";
                    $camposset=$camposset."\t\t\t\tcase \"".$rowCol[0]."\":\n";
                    $camposset=$camposset."\t\t\t\t\t\$this->".$rowCol[0]."=\$valor;\n";
                    $camposset=$camposset."\t\t\t\t\tbreak;\n";
                }
                $textomanual="\t\tpublic function manual(\$row)\n\t\t{\n".$listacamposManual."\n\t\t}\n";
                $texto =$texto.$texto1;
                $texto =$texto."\t\tfunction __construct()\n"; 
                $texto =$texto."\t\t{\n";        
                $texto =$texto."\t\t\t\$this->editado = false;\n";
                $texto =$texto."\t\t\t\$this->esnuevo = false;\n";
                $texto =$texto.$listacamposFill;
                $texto =$texto."\t\t}\n";
                $texto =$texto."\t\tfunction __get(\$propiedad)\n";
                $texto =$texto."\t\t{\n";
                $texto =$texto."\t\t\treturn \$this->\$propiedad;\n";
                $texto =$texto."\t\t}\n";
                $texto =$texto."\t\tfunction __set(\$propiedad,\$valor)\n";
                $texto =$texto."\t\t{\n";
                $texto =$texto."\t\t\tswitch(\$propiedad)\n";
                
                $texto =$texto."\t\t\t{\n";
                $texto =$texto.$camposset;
                $texto =$texto."\t\t\t\tdefault:\n";
                $texto =$texto."\t\t\t\t\t\$this->\$propiedad=\$valor;\n";
                $texto =$texto."\t\t\t}\n";
                $texto =$texto."\t\t}\n";
                
                
                $texto =$texto.$textomanual;
                $texto =$texto."\t\tpublic function tostring()\n"; 
                $texto =$texto."\t\t{\n";        
                $texto =$texto."\t\t\treturn \$this->".$cpmost.";\n";
                $texto =$texto."\t\t}\n";
                $texto =$texto."\t\tpublic function toarray()\n";
                $texto =$texto."\t\t{\n";
                $texto =$texto.$listacampos;
                $texto =$texto."\t\t\treturn \$arr;\n";;
                $texto =$texto."\t\t}\n";
                $texto =$texto."\t}\n";
                return $texto;
            
        }

        function makemetadata($tabla)
        {
            $texto = "";

                $texto ="\tclass ".$tabla."_meta extends baseentity \n";
                $texto =$texto."\t{";
                $texto =$texto."\n";
                $texto =$texto."\t\tfunction __construct()\n";
                $texto =$texto."\t\t{\n";
                $texto =$texto."\t\t\t\$this->nombre=\"".$tabla."\";\n";
                $texto =$texto."\t\t\t\$this->displayname=\"".$tabla."\";\n";
                $texto =$texto."\t\t\t\$this->mostrar=true;\n";
                $texto =$texto."\t\t\t\$this->readonly=false;\n";
                $texto =$texto."\t\t\t\$this->grupo=\"Menu\";\n";
                $campos = $this->coneccion->traeestructura($tabla);
                $texto1="";
                $posi =0;
                
                while ($rowCol = mysql_fetch_row($campos))
                {
                    $filtrar ="false";
                    $filterobject="text";
                    if($posi==1)
                        $texto =$texto."\t\t\t\$this->campomostrar='".$rowCol[0]."';\n";
                    $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']=new basecolumn();\n";
                    $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->nombre=\"".$rowCol["0"]."\";\n";
                    $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->displayname=\"".$rowCol["0"]."\";\n";
                    $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->mostrar=true;\n";
                    $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->posicion=".$posi.";\n";
                    
                    if(substr($rowCol[1],0,3)=="int")
                    {
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->tipo=\"integer\";\n";
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->tipocontrol=\"integer\";\n";
                        $ancho = substr($rowCol[1],4,strpos($rowCol[1],")")-4);
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->ancho=".$ancho.";\n";
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->totalizar=false;\n";
                    }
                    
                    if(substr($rowCol[1],0,7)=="varchar")
                    {
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->tipo=\"string\";\n";
                        $ancho = substr($rowCol[1],8,strpos($rowCol[1],")")-8);
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->ancho=".$ancho.";\n";
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->tipocontrol=\"string\";\n";
                    }
                    
                    if(substr($rowCol[1],0,7)=="decimal")
                    {
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->tipo=\"decimal\";\n";
                        $ancho = substr($rowCol[1],8,strpos($rowCol[1],")")-8);
                        list($entero, $decimales) = split('[,.-]', $ancho);
                        $ancho = $entero+$decimales+1;
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->ancho=".$ancho.";\n";
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->tipocontrol=\"decimal\";\n";
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->totalizar=false;\n";
                    }
                    if(substr($rowCol[1],0,8)=="datetime")
                    {
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->tipo=\"datetime\";\n";
                        $ancho = 10;
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->ancho=".$ancho.";\n";
                        $filterobject="datetime";
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->tipocontrol=\"datetime\";\n";
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->subtipo=\"date\";\n";
                    }
                    if(substr($rowCol[1],0,5)=="float")
                    {
                        $texto1=$texto1."\t\t\t\$this->aCampos[".$rowCol["0"]."']->tipo=\"float\";\n";
                        $ancho = 20;
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->ancho=".$ancho.";\n";
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->tipocontrol=\"decimal\";\n";
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->totalizar=false;\n";
                    }
                    
                    if($rowCol[1]=="tinyint(1)")
                    {
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->tipo=\"bool\";\n";
                        $ancho = 3;
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->ancho=".$ancho.";\n";
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->tipocontrol=\"bool\";\n";
                        $filtrar="true";
                        $filterobject="bool";
                        
                    }
                    if(substr($rowCol[1],0,4)=="text")
                    {
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->tipo=\"text\";\n";
                        $ancho = 300;
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->ancho=".$ancho.";\n";
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->tipocontrol=\"text\";\n";
                    }
                    if($rowCol[2]=="NO")
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->requerido=true;\n";
                    else
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->requerido=false;\n";
                    if($rowCol[3]=="PRI")
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->espk=true;\n";
                    else
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->espk=false;\n";
                                
                    if($rowCol[5]=="auto_increment")
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->readonly=true;\n";
                    else
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->readonly=false;\n";
                    if($rowCol[3]=="MUL")
                    {
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->esfk=true;\n";
                        $fksmeta =$this->getfksmetadata($tabla,$rowCol["0"]);
                        
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->camporelacion=\"".$fksmeta->campoRelacion."\";\n";
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->tablarelacion=\"".$fksmeta->tablaRelacion."\";\n";
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->camporeldes=\"_".$fksmeta->tablaRelacion."\";\n";
                        $filtrar="true";
                    }
                    else
                        $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->esfk=false;\n";
                    $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->filtrar=".$filtrar.";\n";
                    $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->filtroobject=\"".$filterobject."\";\n";
                    $texto1=$texto1."\t\t\t\$this->aCampos['".$rowCol["0"]."']->esunico=false;\n";
                    $posi++;
                }
                $texto =$texto.$texto1."\t\t}\n";
                $texto =$texto."\t}\n";
                return $texto;    
            
        }
        private function getfksmetadata($cTabla,$cfk)
        {
            $cadena ="select column_name,referenced_table_name,referenced_column_name from INFORMATION_SCHEMA.KEY_COLUMN_USAGE ";
            $cadena =$cadena."where table_schema=\"".$GLOBALS['database']."\" ";
            $cadena =$cadena."and table_name=\"".$cTabla."\" ";
            $cadena =$cadena."and column_name = \"".$cfk."\"";
            $registro=mysql_fetch_row($this->coneccion->consulta($cadena));
            
            return new fk($registro[1],$registro[2]);
        } 
    }
   class fk
   {
        public $tablaRelacion;
        public $campoRelacion;
        function __construct($tabla,$campo) 
        {   
            $this->tablaRelacion=$tabla;
            $this->campoRelacion=$campo;
         
        }
   }
    
    class fkvalues
    {
        public $clave;
        public $valor;
        function __construct($_clave,$_valor) 
        {
            $this->clave=$_clave;
            $this->valor=$_valor;
        }
    }
?>