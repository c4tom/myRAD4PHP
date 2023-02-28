{include file='header.tpl'}

        <div class="main">
                <form id="filtro" method="post" action="makesecure.php?tabla={$tabla}" name="filtro" enctype="multipart/form-data">
                <h1 align="center">{$titlemakesecure|capitalize}</h1>
                <div class="dd">
                    <div class="DDValidator">
                        {foreach $error as $err}
                        {$err}<br />
                        {/foreach}
                    </div>
                    <table>
                        <tr>
                            <td>{$safetyuserlabel}:</td>
                            <td>
                                <select name="cbousuario" class="DDDropDown" >
                                    {html_options values=$aCampos output=$aCampos }
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>{$safetypasswordlabel}:</td>
                            <td>
                                <select name="cboclave" class="DDDropDown" >
                                    {html_options values=$aCampos output=$aCampos }
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>{$saferynamelabel}:</td>
                            <td>
                                <select name="cbonomuser" class="DDDropDown" >
                                    {html_options values=$aCampos output=$aCampos }
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" value="Generar" name="procesar" /></td>
                        </tr>
                    </table>                 
                </div>
                </form>
        </div>
    </body>
</html>