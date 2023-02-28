<?php
    include("idiomas.php");
    class admin_idiomas
    {
        private $aIdiomas;
        function __construct()
        {
            $this->aIdiomas = array();
            $this->aIdiomas[] = new __idiomas("Spanish","spanish.php");
            $this->aIdiomas[] = new __idiomas("English","ingles.php");
        }
        function getidiomasnames()
        {
            $areturn = array();
            $areturn[] ="";
            foreach($this->aIdiomas as $idioma)
                $areturn[]=$idioma->nombre; 
            return $areturn;
        }
        function getidiomasfiles()
        {
            $areturn = array();
            $areturn[] ="";
            foreach($this->aIdiomas as $idioma)
                $areturn[]=$idioma->archivo; 
            return $areturn;
        }
        function setsmartylabels($smarty,$idioma)
        {
            include("../config/idiomas/".$idioma);
            $smarty->assign("configtittlelabel",$GLOBALS["configtittlelabel"]);
            $smarty->assign("serverlabel",$GLOBALS["serverlabel"]);
            $smarty->assign("databaselabel",$GLOBALS["databaselabel"]);
            $smarty->assign("userdblabel",$GLOBALS["userdblabel"]);
            $smarty->assign("clavelabel",$GLOBALS["clavelabel"]);
            $smarty->assign("nomapplabel",$GLOBALS["nomapplabel"]);
            $smarty->assign("rutaserverlabel",$GLOBALS["rutaserverlabel"]);
            $smarty->assign("rutaormlabel",$GLOBALS["rutaormlabel"]);
            $smarty->assign("idiomauserlabel",$GLOBALS["idiomauserlabel"]);
            $smarty->assign("tittlebuilderlabel",$GLOBALS["tittlebuilderlabel"]);
            $smarty->assign("titletablalabel",$GLOBALS["titletablalabel"]);
            $smarty->assign("titletablalabel",$GLOBALS["titletablalabel"]);
            $smarty->assign("tittleopcioneslabel",$GLOBALS["tittleopcioneslabel"]);
            $smarty->assign("ormlabel",$GLOBALS["ormlabel"]);
            $smarty->assign("metadatalabel",$GLOBALS["metadatalabel"]);
            $smarty->assign("safetylabel",$GLOBALS["safetylabel"]);
            $smarty->assign("makecustomlabel",$GLOBALS["makecustomlabel"]);
            $smarty->assign("titlemakesecure",$GLOBALS["titlemakesecure"]);
            $smarty->assign("safetyuserlabel",$GLOBALS["safetyuserlabel"]);
            $smarty->assign("safetypasswordlabel",$GLOBALS["safetypasswordlabel"]);
            $smarty->assign("saferynamelabel",$GLOBALS["saferynamelabel"]);
        }
    }
    
?>