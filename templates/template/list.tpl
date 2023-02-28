{include file='header.tpl'}

            <div class="main">
                <form id="filtro" method="post" action="list.php?tabla={$tabla}&filtrar=1&cantidad={$cantidad}&posini=0" name="filtro" enctype="multipart/form-data">
                <h1 align="center">{$titlelist} {$titulo}</h1>
                <a href="{$rutabase}index.php" class="jq-link">{$homelabel}</a>
                <div class="dd">
                        <div class="DDValidator">
                            {foreach $error as $err}
                            {$err}<br />
                            {/foreach}
                        
                        {$n=0}
                        <table class="ui-widget">                       
                            {foreach $filtros as $filtro}
                                {$n=$n+1}
                                {foreach $filtro as $value}
                                    {include file=$value[2]}
                                {/foreach}
                            {/foreach}
                        </table>
                        {if $n neq 0}
                        <input type="submit" value="{$filterlabel}" name="bntfiltro"/>
                        {/if}
                        </div>
                        <div class="orderby">
                            <div id=""><a onclick="mostrar()" class="jq-link">{$sortbylabel}</a></div>
                            <div id="orderby"   >                                                                
                                <table >
                                {foreach $aCamposmeta as $campo}
                                <tr ><td>{$campo[1]}: </td><td><select id="ord_{$campo[0]}" name="ord_{$campo[0]}">
                                            <option value="0">{$notlabel}</option>
                                            <option value="1">{$yeslabel}</option>
                                         </select></td></tr>
                                {/foreach}
                                <tr   >
                                    <td><input type="submit" name="ordenar" value="{$sortlabel}"/></td>
                                    <td><div id="ocultarorder" ><a  onclick="ocultar()" class="jq-link">{$hidesort}</a></div></td></tr>
                                </table>                           
                            </div>
                        </div>
                </div>
                
                <br />
            <div class="clear" >
            <br />
                <a href="insert.php?tabla={$tabla}" class="jq-link"><img id="Img1" src="{$rutabase}img/Add.gif" alt="{$insertlabel}" />{$insertlabel}</a>
                <br />            
            </div>    
                
                
                <div id="table" style="width:100%; overflow:scroll; overflow-x:scroll; overflow-y:auto; height:auto;">
                    {html_table loop=$data cols=$columnames table_attr='class="DDGridView"' th_attr='class="th"' td_attr=$td}                 
                </div>
                 <table border="0px" class="ui-widget">
                        <tr >
                            <td  >
                                {for $n =0 to $maxpages}                                     
                                    <a href="list.php?tabla={$tabla}&posini={$posinis[$n]}&cantidad={$cantidad}" class="jq-link">{$grupos[$n]}</a>
                                {/for} 
                                 <a href="list.php?tabla={$tabla}&posini=-1&cantidad=-1" class="jq-link">{$unfilterlabel}</a>
                            </td>
                        </tr>
                        <tr >
                            <td  >
                                <input class="boton" type="submit" value="{$delselectslabel}" name="procesar" id="procesar" onclick ='return confirm("{$msgdeletelabel}");'/>
                            </td>
                            <td  >
                                {$pageorientationlabel}: 
                                <select name="pageorientation">
                                    {foreach $alabeslorientation as $labelorientation}
                                    <option value="{$labelorientation.value}">{$labelorientation.label}</option>
                                    {/foreach}
                                </select>
                                <input class="boton" type="submit" value="{$printlabel}" name="print" id="print"/>
                            </td>
                        </tr> 
                    </table>
                </form>
            </div>
            

        </div>
    </body>
</html>
