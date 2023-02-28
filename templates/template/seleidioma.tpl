<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    </head>
    <body>
    <h1 >Idiomas/Language</h1>
    <form name="frmbuilder" method="post" enctype="multipart/form-data">
        <table border="0">
            <tr>
                <td>Idioma/Language</td>
                <td>
                    <select name="cboidioma"  >
                        {html_options values=$files output=$names}
                    </select>
                </td>
            </tr>
            <tr>
                <td><input type="submit" name="set" value="Accept" /></td>
            </tr>
        </table>
        <br />
        
    </form>
    </body>
</html>