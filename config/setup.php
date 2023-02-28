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
    define('SMARTY_RESOURCE_CHAR_SET', 'iso-8859-1');//sin esto no muestra las Ñ's y similares
    require($GLOBALS["ruta"]."libs/smarty/Smarty.class.php");
    require($GLOBALS["ruta"]."libs/xmlfile.php");
    require($GLOBALS["ruta"]."libs/menubuillder.php");
    require_once($GLOBALS["ruta"].'libs/html2pdf/html2pdf.class.php');
    class Smarty_myrad4php extends Smarty 
    {
        function __construct()
        {
            parent::__construct();                     
            $this->setTemplateDir($GLOBALS["ruta"].'templates/template');
            $this->setCompileDir($GLOBALS["ruta"].'templates/templates_c/');
            $this->setConfigDir($GLOBALS["ruta"].'templates/configs/');
            $this->setCacheDir($GLOBALS["ruta"].'templates/cache/');
            $this->addTemplateDir($GLOBALS["ruta"].'templates/template/controls_edit');
            $this->addTemplateDir($GLOBALS["ruta"].'templates/template/custom_pages');
            //esto es por que estoy en modo developer y si le pongo en ON pues no recompila los templates
            //pero es recomendable ponerlo en ON  cuando se pase a produccion
            $this->caching = Smarty::CACHING_OFF;
            //array para los nombres de los meses
            $aMeses=array(1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',9=>'Setiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre');
            $this->assign('app_name', $GLOBALS["appname"]);
            $this->assign('meses', $aMeses);
            $this->assign('rutabase', $GLOBALS["basepath"]);
            $xml = new XMLFile();
            $fh = fopen( $GLOBALS["ruta"].'config/menuxml.xml', 'r' );
            $xml->read_file_handle( $fh );
            fclose( $fh );
            $root = &$xml->roottag;
            $aregistros=xml2array($root );
            $mnu = new menubuillder($aregistros,"menu");
            $mnu->makemenu();
            $this->assign('menu', $mnu->html);
        }
        
    }
    function xml2array($xml)
        {
            $aElementos = array();
            foreach($xml->tags as $xmlline )
            {
                $aelem = array();
                $aelem[] =$xmlline->attributes['ID'];
                $aelem[] =$xmlline->attributes['MNULABEL'];
                $aelem[] =$xmlline->attributes['MNUMAIN'];
                $aelem[] =$xmlline->attributes['URL'];
                $aElementos[]=$aelem;
            }
            return $aElementos;  
        }
?>