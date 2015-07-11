<?php
/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.certificati&err');
$t = $_GET['id'];
$f = Certificato::id($t);
?>
<div class="row-fluid">
    <h2><i class="icon-chevron-right muted"></i> Modifica Certificato</h2>
    <div class="alert alert-block alert-info ">
        <div class="row-fluid">
            <span class="span7">
                <p>Con questo modulo si possono modificare i Certificati nel DB di GAIA</p>
            </span>
        </div>
    </div>           
</div>
<form class="form-horizontal" action="?p=admin.certificato.modifica.ok&id=<?php echo $t; ?>" method="POST">

    <div class="control-group">
        <label class="control-label" for="inputNome">Nome certificato</label>
        <div class="controls">
            <input class="input-xxlarge" type="text" name="inputNome" id="inputNome" value="<?php echo $f->nome; ?>">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="inputNome">Numero discenti</label>
        <div class="controls">
            minimo:     <input class="input-small" type="text" name="inputDurata" id="inputDurata" value="<?php echo $f->durata; ?>">
            &nbsp;massimo:    <input class="input-small" type="text" name="inputDurata" id="inputDurata" value="<?php echo $f->durata; ?>">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="inputNome">Durata</label>
        <div class="controls">
            ore:     <input class="input-small" type="text" name="inputDurata" id="inputDurata" value="<?php echo $f->durata; ?>">
            &nbsp;giorni:    <input class="input-small" type="text" name="inputDurata" id="inputDurata" value="<?php echo $f->durata; ?>">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="inputNome">Limite in giorni per l'iscrizione</label>
        <div class="controls">
            <input class="input-small" type="text" name="inputDurata" id="inputDurata" value="<?php echo $f->durata; ?>">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="inputNome">Attestato</label>
        <div class="controls">
            <input class="input-xxlarge" type="text" name="inputRapporto" id="inputRapporto" value="<?php echo $f->rapporto; ?>">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="inputNome">Tipo Valutazione</label>
        <div class="controls">
            <input class="input-xxlarge" type="text" name="inputRapporto" id="inputRapporto" value="<?php echo $f->rapporto; ?>">
        </div>
    </div>
    
    <hr/>
    
    <div class="control-group">
        <label class="control-label" for="inputNome">Ruolo Proprietario</label>
        <div class="controls">
            <input class="input-xxlarge" type="text" name="inputRapporto" id="inputRapporto" value="<?php echo $f->rapporto; ?>">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="inputNome">Ruolo Direttore</label>
        <div class="controls">
            <input class="input-xxlarge" type="text" name="inputRapporto" id="inputRapporto" value="<?php echo $f->rapporto; ?>">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="inputNome">Ruolo Docente</label>
        <div class="controls">
            <input class="input-xxlarge" type="text" name="inputRapporto" id="inputRapporto" value="<?php echo $f->rapporto; ?>">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="inputNome">Ruolo Docente di Affiancamento</label>
        <div class="controls">
            <input class="input-large" type="text" name="inputRapporto" id="inputRapporto" value="<?php echo $f->rapporto; ?>">
            &nbsp;Proporzione: 1 / <input class="input-small" type="text" name="inputDurata" id="inputDurata" value="<?php echo $f->durata; ?>">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="inputNome">Ruolo Discente</label>
        <div class="controls">
            <input class="input-xxlarge" type="text" name="inputRapporto" id="inputRapporto" value="<?php echo $f->rapporto; ?>">
        </div>
    </div>

    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-large btn-success">
                <i class="icon-ok"></i>
                Modifica Certificato
            </button>
        </div>
    </div>

