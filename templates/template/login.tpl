{include file='header.tpl'}
        <div class="main">
                <form id="login" method="post" action="login.php" name="login" enctype="multipart/form-data">
                <h1 align="center">{$logintitle}</h1>
                <div class="dd">
                    <div class="DDValidator">
                        {foreach $error as $err}
                        {$err}<br />
                        {/foreach}
                    </div>
                    <table>
                        <tr>
                            <td>{$userlabel}:</td>
                            <td>
                                <input type="text" name="user" />
                            </td>
                        </tr>
                        <tr>
                            <td>{$passwordlabel}:</td>
                            <td>
                                <input type="password" name="clave"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" value="{$loginlabel}" name="procesar" /></td>
                        </tr>
                    </table>                 
                </div>
                </form>
        </div>
    </body>
</html>