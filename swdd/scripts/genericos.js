
$(function(){
    $('#orderby').hide();
    $('#mostrarorder').show; 
    $('#ocultarorder').hide; 
});
function ocultar()
{
    $('#orderby').hide(); 
    $('#mostrarorder').show();
};
function mostrar()
{
    $('#orderby').show(); 
    $('#mostrarorder').hide();
};
  $(function() {
    $( "input[type=submit],button,.jq-link" )
      .button()
  });
  
(function( $ ) {
    $.widget( "ui.combobox", {
      _create: function() {
        var input,
          that = this,
          wasOpen = false,
          ancho = 300,
          select = this.element.hide(),
          selected = select.children( ":selected" ),
          value = selected.val() ? selected.text() : "",
          wrapper = this.wrapper = $( "<span>" )
            .addClass( "ui-combobox" )
            .insertAfter( select );
 
        function removeIfInvalid( element ) {
          var value = $( element ).val(),
            matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( value ) + "$", "i" ),
            valid = false;
          select.children( "option" ).each(function() {
            if ( $( this ).text().match( matcher ) ) {
              this.selected = valid = true;
              return false;
            }
          });
 
          if ( !valid ) {
            // remove invalid value, as it didn't match anything
            $( element )
              .val( "" )
              .attr( "title", value + " didn't match any item" )
              .tooltip( "open" );
            select.val( "" );
            setTimeout(function() {
              input.tooltip( "close" ).attr( "title", "" );
            }, 2500 );
            input.data( "ui-autocomplete" ).term = "";
          }
        }
 
        input = $( "<input>" )
          .appendTo( wrapper )
          .val( value )
          .width(ancho)
          .attr( "title", "" )
          .addClass( "ui-state-default ui-combobox-input" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: function( request, response ) {
              var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
              response( select.children( "option" ).map(function() {
                var text = $( this ).text();
                if ( this.value && ( !request.term || matcher.test(text) ) )
                  return {
                    label: text.replace(
                      new RegExp(
                        "(?![^&;]+;)(?!<[^<>]*)(" +
                        $.ui.autocomplete.escapeRegex(request.term) +
                        ")(?![^<>]*>)(?![^&;]+;)", "gi"
                      ), "<strong>$1</strong>" ),
                    value: text,
                    option: this
                  };
              }) );
            },
            select: function( event, ui ) {
              ui.item.option.selected = true;
              //la tabla viene del get[tabla]
              //el nombre del campo viene de select.attr('name')
              //el valor del campo viene de ui.item.option.value
              //alert(select.attr('linkfields'));
              //alert("#"+select.attr('linkfields'));
              if(typeof select.attr('linkfields')!='undefined')
              if(select.attr('linkfields')!="")
                {            
                    var afields=select.attr('linkfields').split(',');
                    afields.push(select.attr('name'));
                    var avalores=[];
                    
                    jQuery.each(afields, function(i, val) {
                        avalores.push($("#"+afields[i]).val());
                    });
                    avalores.push(select.val());
                    
                    callphp(select.closest("div").attr("id"),afields,avalores,select.attr('name'),"linkedfiels");          
                }
              that._trigger( "selected", event, {
                item: ui.item.option
              });
            },
            change: function( event, ui ) {
                
              if ( !ui.item ) {
                removeIfInvalid( this );
              }
            }
          })
          .addClass( "ui-widget ui-widget-content ui-corner-left" );
 
        input.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
          return $( "<li>" )
            .append( "<a>" + item.label + "</a>" )
            .appendTo( ul );
        };
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .appendTo( wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "ui-corner-right ui-combobox-toggle" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .click(function() {
            input.focus();
            // close if already visible
            if ( wasOpen ) {
              return;
            }
            // pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
 
        input.tooltip({
          tooltipClass: "ui-state-highlight"
        });
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );
  $(function() {
    $( ".jq-combo" ).combobox();
    $( ".datepicker" ).datepicker({dateFormat: 'yy-mm-dd', separator:'-'});
    $( ".jq-decimal" ).spinner({
      step: 0.10,
      numberFormat: "n",
      stop:function(e,ui){
        
      }
     });
    $( ".jq-decimal" ).focusout(function() {
   if($(this).attr('linkfields')!="")
        {            
            var afields=$(this).attr('linkfields').split(',');
            afields.push($(this).attr('name')); 
            var avalores=[];
            
            jQuery.each(afields, function(i, val) {
                avalores.push($("#"+afields[i]).val());
            });
            
            avalores.push($(this).val());
            callphp($(this).closest("div").attr("id"),afields,avalores,$(this).attr('name'),'linkedfiels');          
        }
});
    $( ".jq-enteros" ).spinner({
      step: 1,
      numberFormat: "n",
      stop:function(e,ui){
        if($(this).attr('linkfields')!="")
        {            
            var afields=$(this).attr('linkfields').split(',');          
            var avalores=[];
            avalores.push($(this).val());
            jQuery.each(afields, function(i, val) {
                avalores.push($("#"+afields[i]).val());
            });
            avalores.push($(this).val());
            callphp($(this).closest("div").attr("id"),afields,avalores,$(this).attr('name'),'linkedfiels');
        }
      }
    });
  });
function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
      hash = hashes[i].split('=');
      vars.push(hash[0]);
      vars[hash[0]] = hash[1];
    }
    return vars;
};
  
  function getUrlVar(name){
    return getUrlVars()[name];
  };

function callphp(ctablaorigen,anomfields, avalfields,cFieldOrigen,caction)
{   
    var nomtabla = ctablaorigen;
    var retornar="";
    var caccion = caction;
    var retornar;
    var parametros = 
    {
        'accion':caction,
        'tablaorigen':nomtabla,
        'campoorigen': cFieldOrigen,
        'campos':anomfields,
        'valores':avalfields
    };
    $.ajax({
            data:parametros,
            url:rutabase+'dal/caller.php',
            type:'post',
            success: function(response){                
                retornar = response;
                if(retornar!="")
                {
                    if(caccion=='linkedfiels')
                    {
                        retornar = $.parseJSON(response);
                        
                        //jQuery.each(retornar, function(i, valor) {
                        jQuery.each(anomfields, function(i, valor) {
                            $("#"+valor).val(retornar[valor]);    
                        });
                        return retornar;
                    }
                    if(caccion=='insertdetails')
                    {
                        retornar = $.parseJSON(response);
                        var cfila="<td class='td'>&nbsp;</td><td class='td'><a href='' id=''>Quitar</a></td>"; 
                        $.each(retornar, function (key, value){
                            cfila = cfila + "<td class='td' width='auto'>"+value+"</td>";
                        });
                        $("#tbldetails > tbody >tr:first").before("<tr>"+cfila+"</tr>");
                    }
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                retornar = "error";
            }
            });
                
};

