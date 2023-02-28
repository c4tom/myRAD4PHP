
/**
 * ReplaceAll by Fagner Brack (MIT Licensed)
 * Replaces all occurrences of a substring in a string
 */
String.prototype.replaceAll = function( token, newToken, ignoreCase ) {
    var _token;
    var str = this + "";
    var i = -1;

    if ( typeof token === "string" ) {

        if ( ignoreCase ) {

            _token = token.toLowerCase();

            while( (
                i = str.toLowerCase().indexOf(
                    token, i >= 0 ? i + newToken.length : 0
                ) ) !== -1
            ) {
                str = str.substring( 0, i ) +
                    newToken +
                    str.substring( i + token.length );
            }
        } else {
            return this.split( token ).join( newToken );
        }

    }
return str;
};

function hacelista(avals,ismain)
{
    if(ismain)
        cadena ="<ul id='dropdownmenu'>\n";
    else
        cadena ="<ul>\n";
    for(var k =0;k<avals.length;k++)
    {
        cadena = cadena+"<li><a href='"+avals[k].url+"'>"+avals[k].mnulabel+"</a>\n";
        
        if(typeof avals[k].children !="undefined")
        {
            cadena = cadena+hacelista(avals[k].children,false)+"\n";
        }
    }
    cadena = cadena+"</li></ul>";
    return cadena;    
}

function haceXML(avals,mainmenu)
{
    cadena ="";
    for(var k =0;k<avals.length;k++)
    {
        cadena = cadena+'\t<MNUINI ID="'+avals[k].id+'" MNULABEL="'+avals[k].mnulabel+'" MNUMAIN="'+mainmenu+'" URL="'+avals[k].url+'"/>\n';     
        if(typeof avals[k].children !="undefined")
        {
            cadena = cadena+haceXML(avals[k].children,avals[k].id);
        }
    }
    return cadena;    
}

$(document).ready(function()
{
	var numid = 1;
    getXML();
     var oArea = document.getElementById('nestable-xml');
            var aNewlines = oArea.value.split("\n");
            numid= aNewlines.length-2;
    var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            y=list.nestable('serialize');
            n = hacelista(y,true);
            output.val(n);
            $("#resultado").empty();
            $("#resultado").append(n);
            var oArea = document.getElementById('nestable-xml');
            var aNewlines = oArea.value.split("\n");
            numid= aNewlines.length-2;
            n="<\?xml version='1.0' encoding='UTF-8'?>\n<ROOT>\n";
            n = n+haceXML(y,0);
            n=n+"</ROOT>\n";
            $("#nestable-xml").val(n);
                        
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };
    $('#nestable').nestable({
        group: 1
    })
    .on('change', updateOutput);
    $('#nestable2').nestable({
        group: 1
    });
    updateOutput($('#nestable').data('output', $('#nestable-output')));
    $('#nestable-menu').on('click', function(e)
    {
        var target = $(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });
    $('#nestable3').nestable();
	$('#bntAdd').on('click', function(e)
    {
		var oArea = document.getElementById('nestable-xml');
        var aNewlines = oArea.value.split("\n");
        numid= aNewlines.length-2;
        numid++;
		$('#lista').append('<li class="dd-item" data-id="'+numid+'" data-mnulabel="'+$('#txtnombre').val()+'" data-url="'+$('#txtDestino').val()+'"><div class="dd-handle"><label id="lbl">'+$('#txtnombre').val()+'</label> <a id="destino" href="'+$('#txtDestino').val()+'">'+$('#txtDestino').val()+'</a> </div></li>');
        updateOutput($('#nestable').data('output', $('#nestable-output')));
    });
    $("#help-en").hide();
    $("#help-es").hide();
    $('#helpen').on('click', function(e)
    {
        closeall();
		$("#help-en").show();
    });
    $('#helpes').on('click', function(e)
    {
        closeall();
		$("#help-es").show();
    });
    function closeall()
    {
        $("#help-en").hide();
        $("#help-es").hide();    
    }
    $('#helpes').on('click', function(e)
    {
        closeall();
		$("#help-es").show();
    });
    $('#close').on('click', function(e)
    {
        closeall();
    });
    $('#cerrar').on('click', function(e)
    {
        closeall();
    });
    
    $('#bntgettables').on('click', function(e)
    {
        gettables(numid);
    });
    $('#bntgetmenu').on('click', function(e)
    {
        getXML();
    });    
    
    
    $('#bntsavemenu').on('click', function(e)
    {
        var datosxml=$("#nestable-xml").val();
        saveXML(datosxml);
    });    
    
    $('#bntexit').on('click', function(e)
    {
        $(location).attr('href',rutabase); 
    });    
    function gettables(numact)
    {
        numid=numact;
        var parametros = 
        {
            'accion':"gettables",
        };
        $.ajax({
                data:parametros,
                url:rutabase+'efm/returntables.php',
                type:'post',
                success: function(response){          
                    retornar = response;
                    if(retornar!="")
                    {
                           retornar = $.parseJSON(response);
                           for(var item in retornar)
                           {
                                numid++;
                                var elemento = retornar[item];
                                $('#lista').append('<li class="dd-item" data-id="'+numid+'" data-mnulabel="'+elemento.nomtabla+'" data-url="'+elemento.url+'"><div class="dd-handle"><label id="lbl">'+elemento.nomtabla+'</label> <a id="destino" href="'+elemento.url+'">'+elemento.url+'</a> </div></li>');
                           }
                           updateOutput($('#nestable').data('output', $('#nestable-output')));
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown)
                {
                    retornar = "error";
                }
                });
                    
    };    
    
    function getXML()
    {   
        var parametros = 
        {
            'accion':"getxml"
        };
        $.ajax({
                data:parametros,
                url:rutabase+'efm/returntables.php',
                type:'post',
                success: function(response){          
                    retornar = response;
                    if(retornar!="")
                    {
                        retornar = $.parseJSON(response);
                        $('#lista').empty();
                        $('#lista').append(retornar);
                        updateOutput($('#nestable').data('output', $('#nestable-output')));
                                                   
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown)
                {
                    retornar = "error";
                }
                });
                    
    };
    
    function saveXML(datosxml)
    {   
        var parametros = 
        {
            'accion':"saveXML",
            'datos': datosxml
        };
        $.ajax({
                data:parametros,
                url:rutabase+'efm/returntables.php',
                type:'post',
                success: function(response){          
                    retornar = response;
                    if(retornar!="")
                    {
                        retornar = $.parseJSON(response);
                        alert(retornar);            
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown)
                {
                    retornar = "error";
                }
                });
                    
    };
    
});
