<?php
    class menubuillder
    {
        public $menu;
        private $aElementos;
        private $mnuact;
        public $html;
        public $class;
        function __construct($_aelementos,$_class="menu")
        {
            $this->menu =array();
            $this->aElementos = $_aelementos;
            $this->mnuact=-1;
            $this->html="<ul id=\"".$_class."\">\n";
        }
                
        function makemenubuilder($mimenu=array())
        {
            $mimenu= array();
            $this->html='';
            foreach($this->aElementos as $reg)
            {
                
                if($reg[2]== 0) //es menu principal
                {
                    $ar = $this->filterarra($reg[0]);
                    if(sizeof($ar)>0)
                    {
                        $this->html.='<li class="dd-item" data-id="'.$reg[0].'" data-mnulabel="'.$reg[1].'" data-url="'.$reg[3].'"><div class="dd-handle"><label id="lbl">'.$reg[1].'</label> <a id="destino" href="'.$reg[3].'">'.$reg[1].'</a> </div>';
                        $mival = $this->makesubitemsbuillder($ar);                       
                        $mimenu[$reg[1]]=array($reg[0],$reg[1],$mival);
                        $this->html.="</li>";
                    }
                    else
                    {
                        $mimenu[$reg[1]]=array($reg[0],$reg[1],null);
                        //$this->html.="<li id='".$reg[0]."' name='".$reg[0]."'><a href=\"".$reg[3]."\">".$reg[1]."</a></li>\n";
                        $this->html.='<li class="dd-item" data-id="'.$reg[0].'" data-mnulabel="'.$reg[1].'" data-url="'.$reg[3].'"><div class="dd-handle"><label id="lbl">'.$reg[1].'</label> <a id="destino" href="'.$reg[3].'">'.$reg[1].'</a> </div></li>';
                    }
                }

            }
            $this->html.="";
            return $this->html; 
        }
        
        
        function makesubitemsbuillder($arr)
        {
            $mnu =array();
            $this->html.='<ol  class="dd-list">';
            foreach($arr as $reg)
            {               
                $ar = $this->filterarra($reg[0]);
                if(sizeof($ar)>0)
                {
                    $this->html.='<li class="dd-item" data-id="'.$reg[0].'" data-mnulabel="'.$reg[1].'" data-url="'.$reg[3].'"><div class="dd-handle"><label id="lbl">'.$reg[1].'</label> <a id="destino" href="'.$reg[3].'">'.$reg[1].'</a> </div></li>';
                    $mnu[$reg[1]]=array($reg[0],$reg[1],$this->makesubitems($ar));
                    $this->html.="</li>";
                }
                else
                {
                    $this->html.='<li class="dd-item" data-id="'.$reg[0].'" data-mnulabel="'.$reg[1].'" data-url="'.$reg[3].'"><div class="dd-handle"><label id="lbl">'.$reg[1].'</label> <a id="destino" href="'.$reg[3].'">'.$reg[1].'</a> </div></li>';
                    $mnu[$reg[1]]=array($reg[0],$reg[1],null);
                }
            }
            $this->html.="</ol>";
            return $mnu;
        }
        
                        
        
        
        
        function makemenu($mimenu=array())
        {
            $mimenu= array();
            foreach($this->aElementos as $reg)
            {
                
                if($reg[2]== 0) //es menu principal
                {
                    $ar = $this->filterarra($reg[0]);
                    if(sizeof($ar)>0)
                    {
                        $this->html.="<li id='".$reg[0]."' name='".$reg[0]."'>\n<a href=\"".$reg[3]."\">".$reg[1]."</a>\n";
                        $mival = $this->makesubitems($ar);                       
                        $mimenu[$reg[1]]=array($reg[0],$reg[1],$mival);
                        $this->html.="\n</li>\n";
                    }
                    else
                    {
                        $mimenu[$reg[1]]=array($reg[0],$reg[1],null);
                        $this->html.="<li id='".$reg[0]."' name='".$reg[0]."'><a href=\"".$reg[3]."\">".$reg[1]."</a></li>\n";
                    }
                }

            }
            $this->html.="</ul>\n";
            $this->menu= $mimenu;
        }
        function makesubitems($arr)
        {
            $mnu =array();
            $this->html.="<ul>\n";
            foreach($arr as $reg)
            {               
                $ar = $this->filterarra($reg[0]);
                if(sizeof($ar)>0)
                {
                    $this->html.="<li id='".$reg[0]."' name='".$reg[0]."'><a href=\"".$reg[3]."\">".$reg[1]."</a>\n";
                    $mnu[$reg[1]]=array($reg[0],$reg[1],$this->makesubitems($ar));
                    $this->html.="</li>\n";
                }
                else
                {
                    $this->html.="<li id='".$reg[0]."' name='".$reg[0]."'><a href=\"".$reg[3]."\">".$reg[1]."</a></li>\n";
                    $mnu[$reg[1]]=array($reg[0],$reg[1],null);
                }
            }
            $this->html.="</ul>\n";
            return $mnu;
        }
        function filterarra($valor)
        {
            $newarray = array();
            foreach($this->aElementos as $elem)
            {
                if($elem[2]==$valor)
                {
                    $newarray[]=$elem;                    
                }
            }
            return $newarray;
        }
    }
?>
