{include file='header.tpl'}
            <div class="main">
                <h1 align="center">{$inserttitlelabel} {$titulo}</h1>
                <a href="{$rutabase}index.php">{$homelabel}</a>
                <div class="ui-widget">
                <button id="createitem">Adicionar elemento</button>
                    <form id="" method="post" action="insert.php?tabla={$tabla}&action=1" name="editar" enctype="multipart/form-data">
                        <div class="DDValidator">
                            {foreach $error as $err}
                            {$err}<br />
                            {/foreach}
                        </div>
                        <div id="{$tabla}">
                        <table class="mytable" >
                            {foreach $acampostop as $value}
                            <tr>
                                <td>
                                    {$value.etiqueta}
                                </td>
                                <td>
                                    {include file=$value.tipocontrol}
                                </td>
                            </tr>             
                            {/foreach}
                         </table>             
                            <div id="table" style="width:100%; overflow:scroll; overflow-x:scroll; overflow-y:auto; height:auto;">
                                <br />
                                
                                <br />
                                {html_table loop=$data cols=$columnames table_attr='class="DDGridView" id="tbldetails"' th_attr='class="th"' td_attr=$td}
                                                 
                            </div>
                           <table class="mytable">                                      
                            {foreach $acamposbutton as $value}
                            <tr>
                                <td>
                                    {$value.etiqueta}
                                </td>
                                <td>
                                    {include file=$value.tipocontrol}
                                </td>
                            </tr>             
                            {/foreach}
                            <tr>
                                <td><input type="submit" value="{$acceptlabel}" name ="aceptar" class="submitButton"/></td>
                                <td><input type="submit" value="{$cancellabel}" name="cancelar"/></td>
                            </tr>
                        </table>
                        </div>
                    </form>
                </div>
            </div>
            <div class="clear">
            </div>

        </div>
        <div id="{$tabledetails}" title="Agregar elemento">
            <form>
                <fieldset>
                <table class="mytable">
                    {foreach $acamposdeta as $value}
                    <tr>
                        <td>
                            {$value.etiqueta}
                        </td>
                        <td>
                            {include file=$value.tipocontrol}
                        </td>
                    </tr>             
                    {/foreach}                                                   
                </table>                     
                </fieldset>
            </form>
        </div>
<script>
    $( "#{$tabledetails}" ).dialog({
      autoOpen: false,
      height: 300,
      width: 500,
      modal: true,
      buttons: {
        "Agregar": function() {
            var $inputs = $('#{$tabledetails} :input');
            var avalores=[];
            var afields=[];
            $inputs.each(function() {
                if(this.name!="")
                {
                    avalores.push($(this).val());
                    afields.push(this.name);
                }
            });
          var s = callphp($(this).closest("div").attr("id"),afields,avalores,"","insertdetails");
          var j =0;  
        },
        Cancelar: function() {
          $( this ).dialog( "close" );
        }
      }
      
    });
 
    $( "#createitem" )
      .button()
      .click(function() {
        $( "#{$tabledetails}" ).dialog( "open" );
      });
</script>
        
    </body>
</html>
