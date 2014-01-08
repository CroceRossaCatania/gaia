/*
 * ©2012 Croce Rossa Italiana
 * Tutti i diritti sono riservati
 */

var
    uid = null,
    sid = null,
    uob = null;
    
var conf = {
    api:    'api.php',
    key:    'bb2c08ff4da11f0b590a7ae884412e2bfd8ac28a'
};

$(window).ready( function () { 
    
    /* Impostazioni di jQuery UI */
    $.datepicker.setDefaults( $.datepicker.regional[ "it" ] );
    
    /* Impostazioni iniziali AJAX */
    $.ajaxSetup({
       type:        "POST",
       dataType:    "json",
       error:       _rete_errore,
       contentType: "application/json; charset=UTF-8",
       success:     _rete_ok
    });
      
    /* Carica eventuali impostazioni */
    sid = $.cookie('sessione');
    _sincronizza();
    api('ciao', {}, _aggiorna_chiSono());
    
    /* Bind */
    $("#_logout").click( _logout );
    $("#_login").click( _login );
    
    $("[data-attendere]")       .each( _attendere );
    $("[data-suggerimento]")    .each( _suggerimento );
    $("[data-volontari]")       .each( _tabella );
    $("[data-conferma]")        .each( _conferma );

    $('.automodal').modal({ keyboard: false, backdrop: 'static' });
    $('.alCambioSalva').change( function () {
        $(this).parents('form').submit();
    })
    
    $("#navigatoreMobileSelect").change( _navigatore_mobile );
    
    tinymce.init({
        selector:   "textarea.conEditor",
        language:   'it',
        plugins: [
            "lists link image",
            "visualblocks fullscreen",
            "media paste"
        ],
        toolbar: "bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        menubar: false,
        statusbar: false
    });


} );

$(document).ready( function() { 
 
  /* Affare che fa scomparire la roba */
  
   $("[data-nascondi]").each( function(i, e) {
    var testo = $(e).html();
    $(e).html("<i class='" + $(e).data('icona') + "'></i> " + $(e).data('nascondi'))
      .addClass('btn')
      .addClass('btn-info');
    $(e).click( function() {
      $(e).html(testo)
        .removeClass('btn')
        .removeClass('btn-info');
    });
  });
 
});

/* Test di funzionamento in HTML5 e caricamento dei polyfill */
Modernizr.load([
  {
    /* Campi richiesti  */
    test: Modernizr.input.required,
    nope: ['js/polyfill/required.js']
        
  },
  {
    /* Placeholder! */
    test: Modernizr.input.placeholder,
    nope: ['js/polyfill/placeholder.css', 'js/polyfill/placeholder.js']
  },
]);

function _rete_errore(a, b, c) {
    // alert('C\'è stato un errore nel processare la richiesta.');
}

function _rete_ok(a, b, c) {
    sid = a.sessione.id;
    uob = a.sessione.utente;
    if ( uob ) {
        uid = uob.id;
    }
    _sincronizza();
}

function _sincronizza() {
    $.cookie('sessione', sid);
    _aggiorna_chiSono();
}

function _conferma(i, e) {
    $(e).click( function() {
        return confirm($(e).data('conferma'));
    });
}

function _aggiorna_chiSono() {
}
  
function api(metodo, dati, callback) {
    $.post(
        conf.api,
        JSON.stringify($.extend(
            dati,
            { 
                metodo: metodo,
                sid:    sid,
                key:    conf.key
            })),
        [_rete_ok, callback]
    );
}

function _dump( x ) {
}

function _logout () {
    api('logout');
}

function _login () {
   
}

function _abilita_filtraggio (idInput, idTabella) {
    $(idInput).keyup ( function () {
        var testo = $(idInput).val().toLowerCase(); 
        if ( testo.length < 2 ) { /* 2, minimo numero di caratteri */
            $(idTabella + " tr").show();
            return;
        }

        $(idTabella + " tr").each( function ( i, e ) {
            var x = false;
            $(e).children("td").each( function (a, b) {
                var attuale = $(b).text().toLowerCase();
                if ( attuale.indexOf(testo) !== -1 )  {
                    x = true;
                    return;
                }
            });
            if ( x ) {
                $(e).show(); 
            } else {
                $(e).hide(); 
            }
        });
        $(idTabella + " thead tr").show();
        
    });
}

function caricaMapsApi( callback ) {
  var script = document.createElement("script");
  script.type = "text/javascript";
  script.src = "https://maps.google.com/maps/api/js?sensor=false&callback=" + callback;
  document.body.appendChild(script);
}

function _attendere(i, e) {
    $(e).click ( function() {
        var vecchioTesto = $(e).html();
        var testo = $(e).data('attendere');
        $(e).addClass('disabled').attr('disabled', 'disabled');
        $(e).html('<i class="icon-spin icon-spinner"></i> ' + testo);
        setTimeout( function() {
            $(e).html(vecchioTesto);
            $(e).removeClass('disabled').removeAttr('disabled');
        }, 6500);
        if ( $(e).attr('type') == 'submit' ) {
            $(e).parents('form').submit();
            return true;
        }
    });
}

function _suggerimento(i, e) {
    $(e).attr('title', $(e).data('suggerimento'));
    $(e).tooltip({
        html:   true
    });
}

function _navigatore_mobile() {
    location.href = '?p=' + $("#navigatoreMobileSelect").val();
}

/* TO ISO STRING */
if ( !Date.prototype.toISOString ) {
     
    ( function() {
     
        function pad(number) {
            var r = String(number);
            if ( r.length === 1 ) {
                r = '0' + r;
            }
            return r;
        }
  
        Date.prototype.toISOString = function() {
            return this.getUTCFullYear()
                + '-' + pad( this.getUTCMonth() + 1 )
                + '-' + pad( this.getUTCDate() )
                + 'T' + pad( this.getUTCHours() )
                + ':' + pad( this.getUTCMinutes() )
                + ':' + pad( this.getUTCSeconds() )
                + '.' + String( (this.getUTCMilliseconds()/1000).toFixed(3) ).slice( 2, 5 )
                + 'Z';
        };
   
    }() );
}

/*
 * Genera, per un dato elemento, una tabella di volontari
 */
function _tabella (i, e) {
    var _tid = 'tabella_' + Math.floor( Math.random() * 100 );
    $(e)
        .addClass('table')
        .addClass('table-condensed')
        .addClass('table-striped')
        .addClass('table-bordered');
    // Crea l'input
    var x = $(
        '<div id="'+ _tid + '_ricerca" class="row-fluid ricerca-tabella">' +
        '<div class="span5 allinea-centro grassetto">' +
            '<p>Pagina <span id="' + _tid + '_a">X</span> di ' +
            '<span id="' + _tid + '_b">Y</span> &mdash; ' +
            '<span id="' + _tid + '_c">Z</span> risultati trovati' +
        '</div>' + 
        '<div class="span2 btn-group allinea-centro grassetto">' +
            '<a class="btn ' + _tid + '_indietro">' +
                '<i class="icon-chevron-left"></i>' +
            '</a>' +
            '<a class="btn ' + _tid + '_avanti">' +
                '<i class="icon-chevron-right"></i>' +
            '</a>' +
        '</div>' + 
        '<div class="span5 allinea-centro input-append">' +
            '<input type="text" class="input-xlarge" placeholder="Ricerca volontari..." />' +
            '<button class="btn btn-primary">' +
                '<i class="icon-search"></i>' +
            '</button>' +
        '</div>' +
        '</div>'
    );
    $(e).before(x);
    var y = $(
        '<div id="'+ _tid + '_ricerca" class="row-fluid ricerca-tabella">' +
        '<div class="span2 offset5 btn-group allinea-centro grassetto">' +
            '<a class="btn ' + _tid + '_indietro">' +
                '<i class="icon-chevron-left"></i>' +
            '</a>' +
            '<a class="btn ' + _tid + '_avanti">' +
                '<i class="icon-chevron-right"></i>' +
            '</a>' +
        '</div>' + 
        '</div>'
    );
    $(e).after(y);
    $(e).data('tid', _tid);
    $('#' + _tid + '_ricerca').find('input').change( function(x, y) {
        _tabella_ricerca ( e, $(this).val(), $(this) );
    });
    // Avvia senza ricerca...
    _tabella_ricerca(e, null, $('#' + _tid + '_ricerca').find('input').first());
}

function _tabella_ricerca ( e, query, input, pagina ) {
    _tabella_caricamento(e);
    _tabella_blocca_input(input);
    if ( !pagina || pagina < 0 ) {
        pagina = 1;
    }
    var perPagina = $(e).data('perpagina');
    var _tid      = $(e).data('tid');
    if (!perPagina) {
        perPagina = 30;
    }
    api('volontari:cerca', {
        'query':        query,
        'pagina':       pagina,
        'perPagina':    perPagina
    }, function (dati) {
        _tabella_ridisegna(e, dati.risposta, input);
         /* Pulsante indietro... */
        if ( pagina == 1 ) {
            $('.' + _tid + '_indietro')
                .unbind('click')
                .addClass('disabled');
        } else {
            $('.' + _tid + '_indietro')
                .unbind('click')
                .removeClass('disabled')
                .click ( function () {
                    _tabella_ricerca(e, query, input, pagina - 1);
                });
        }   
        /* Pulsante avanti... */
        if ( pagina == dati.risposta.pagine ) {
            $('.' + _tid + '_avanti')
                .unbind('click')
                .addClass('disabled');
        } else {
            $('.' + _tid + '_avanti')
                .unbind('click')
                .removeClass('disabled')
                .click ( function () {
                    _tabella_ricerca(e, query, input, pagina + 1);
                });
        }

    });

}


function _tabella_blocca_input( input ) {
    $(input).addClass('disabled').attr('disabled', 'disabled');
    $(input).parent().find('button').html (
        '<i class="icon-spinner icon-spin"></i>'
    );
}

function _tabella_sblocca_input ( input ) {
    $(input).removeClass('disabled').removeAttr('disabled');
    $(input).parent().find('button').html (
        '<i class="icon-search"></i>'
    );
    $(input).select().focus();
}



function _tabella_ridisegna( e, dati, input ) {
    var _tid = $(e).data('tid');

    /* Eventuale testo */
    var _rid = $(e).data('azioni');
    if ( _rid ) {
        var _testo = $(_rid).html();
    } else {
        var _testo = '(nessuna azione)';
    }
    /* Aggiorna i totali (pagina x di y, tot risultati) */
    $('#' + _tid + '_a').text( dati.pagina );
    $('#' + _tid + '_b').text( dati.pagine );
    $('#' + _tid + '_c').text( dati.totale );
    $(e).html(
        '<thead class="allinea-centro">' +
            '<th>Cognome</th>' +
            '<th>Nome</th>' +
            '<th>Cod. Fisc.</th>' +
            '<th>Comitato</th>' +
            '<th>Azioni</th>' +
        '</thead>' +
        '<tbody>' +
        '</tbody>'
    );
    var tbody = $(e).find('tbody');
    $.each( dati.risultati, function (i, volontario) {
        var nt = _tabella_sostituzioni(_testo, volontario);
        $(tbody).append(
            '<tr>' +
                '<td class="grassetto">' + volontario.cognome         + '</td>' +
                '<td class="grassetto">' + volontario.nome            + '</td>' +
                '<td>' + volontario.codiceFiscale   + '</td>' +
                '<td>' + volontario.comitato.nome   + '</td>' +
                '<td>' + nt + '</td>' +
            '</tr>'
        );
    });
    if ( dati.risultati.length == 0 ) {
        $(tbody).append(
            '<tr class="error">' +
                '<td colspan="5" class="allinea-centro">' +
                    '<h3><i class="icon-frown"></i> Nessun volontario trovato</h3>' +
                    '<p>Per favore prova con un altra ricerca.</p>' +
                    '<p>Sono accettate parti di nome, cognome, email e codice fiscale.</p>' +
                '</td>' +
            '</tr>'
        );
    }
    _tabella_sblocca_input(input);
}

function _tabella_sostituzioni (testo, volontario) {
    testo = testo.replace(/{id}/g,       volontario.id);
    testo = testo.replace(/{nome}/g,     volontario.nome);
    testo = testo.replace(/{cognome}/g,  volontario.cognome);
    return testo;
}

function _tabella_caricamento (e) {
    $(e).html(
        '<tr class="warning"><td class="allinea-centro"><h3>' +
            '<i class="icon-spinner icon-spin allinea-centro"></i> ' +
            '<strong>Caricamento in corso...</strong>' +
        '</h3></td></tr>'
    );
}