<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
        <link href="{$rutabase}css/default.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="{$rutabase}scripts/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="{$rutabase}scripts/jquery-ui.js"></script>
        <script type="text/javascript" src="{$rutabase}swdd/scripts/genericos.js"></script>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" href="{$rutabase}css/ddlevelsfiles/ddlevelsmenu-base.css" />
        <link rel="stylesheet" type="text/css" href="{$rutabase}css/ddlevelsfiles/ddlevelsmenu-topbar.css" />
        <link rel="stylesheet" type="text/css" href="{$rutabase}css/ddlevelsfiles/ddlevelsmenu-sidebar.css" />
        <script type="text/javascript" src="{$rutabase}scripts/ddlevelsmenu.js">

        /***********************************************
        * All Levels Navigational Menu- (c) Dynamic Drive DHTML code library (http://www.dynamicdrive.com)
        * This notice MUST stay intact for legal use
        * Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
        ***********************************************/
        
        </script>
        
        
        <style>
            .divcambas{
                height:600px;
                width:800px;
                overflow:auto;
                background-color: white;
                border-style:solid;
                border-width:10px;
            }
            .divcontrol
            {
                background-color: gray;
                border-style:solid;
                border-width:3px;
                color: black;
                
                margin:3px;
                width:auto;
                height:auto;
            }
            .fieldobj
            {
                background-color: gray;
                border-style:solid;
                border-width:1px;
                color: black;
                padding:3px;
                margin:0px;
                height:23px;
                               
            }
            .fieldlbl
            {
                background-color: gray;
                border-style:solid;
                border-width:1px;
                color: black;
                padding:3px;
                margin:0px;
                height:23px;
            }
            td{
                display:table-cell; vertical-align:top;
            }
        </style>
        <script>
$(function() {
    $(".divcambas").droppable({
        greedy: true,

      drop: function( event, ui ) {
        $( this )
          .addClass( "ui-state-highlight" )
          .find( "p" )
            .html( "Dropped!" );
      }
    });
  });
  
        </script>
    </head>
    <body>
    <h1 >Form buillder</h1>
    <div id="resizable" class="ui-widget-content">
    asasasd
    asdasdasd
    sadasddas
    asddasdsa
    </div>
    <form name="frmbuilder" method="post" enctype="multipart/form-data">
        <table  >
            <tr  >
                <td>Tablas/campos</td>
                <td>Opc.</td>
                <td>Diseño</td>
            </tr>
            <tr>
                <td>
                    
                    <select id="cbotabla" class="target">
                        {html_options values=$tblnombres output=$tbldisplayname}
                    </select>
                    <div id="divfields">
                    </div>           
                </td>
                <td>
                    <input type="button" id="add" value="Add"/><br />
                    <input type="button" id="remove" value="Remove"/>
                </td>
                <td>
                    <div class="divcambas" id="controles" ></div>
                </td>
                
            </tr>
        </table>
    </form>
    <script>
    
    $("#cbotabla").change(function () {
        var valortabla = $(this).val();
        $.post("responsejs.php",
        {
            function: "getfieldsoftable", parametros: $(this).val()
        },function(data){
            var response = jQuery.parseJSON(data);
            $("#divfields").empty();
            
            $.each(response,function(indice,valor) {
                var g = '<div class="fieldlbl"><label >'+valor[1]+'</label></div><div class="fieldobj"><input type="text"  id="txt'+valor[0]+'" value="'+valor[0]+'" /></div>';               
                $("#divfields").append(g);               
            });
    
    $( ".divcontrol" ).draggable();
    
    $( ".fieldlbl" ).draggable();
    $( ".fieldobj" ).draggable();        
            }
        );       
    });
    
    
    </script>
    
    </body>
</html>