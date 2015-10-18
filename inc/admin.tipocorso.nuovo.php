<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$ruoli = RuoloFormazione::elencoRuoli();

?>
<style>
    .control-group .controls span{
        display: inline-block;
        min-width: 80px;
    }
</style>


<div class="row-fluid">
    <?php if (isset($_GET['err'])) { ?>
    <div class="alert alert-block alert-error">
        <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
        <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
    </div> 
    <?php } ?>
    <h2><i class="icon-chevron-right muted"></i> Aggiungi nuovo certificato</h2>
    <div class="alert alert-block alert-info ">
        <div class="row-fluid">
            <span class="span7">
                <p>Con questo modulo si possono aggiungere i certificati nel DB di GAIA</p>
                <p>Es: Corso BSD per popolazione</p>
            </span>
        </div>
    </div>           
</div>
<form class="form-horizontal" action="?p=admin.tipocorso.nuovo.ok" method="POST">
    <div class="control-group">
        <label class="control-label" for="inputNome">Nome certificato</label>
        <div class="controls">
            <input class="input-xxlarge" type="text" name="inputNome" id="inputNome" value="<?php echo $f->nome; ?>">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="inputRuoloAttestato">Ruolo Attestato</label>
        <div class="controls">
            <select class="input-xxlarge" name="inputRuoloAttestato" id="inputRuoloAttestato">
                <option></option>
                <?php foreach($ruoli as $r) :?>
                    <?php $selected = ""; ?>
                    <?php if(intval($f->ruoloAttestato) === intval($r->id)):?>
                        <?php $selected = "selected='selected'"; ?>
                    <?php endif ?>
                    <option <?php print $selected; ?>><?php print $r->ruolo?></option>
                <?php endforeach; ?>
            </select> 
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="inputMinimoPartecipanti">Numero discenti</label>
        <div class="controls">
            <span>minimo:</span>
            <input class="input-small" type="text" name="inputMinimoPartecipanti" id="inputMinimoPartecipanti" value="<?php echo $f->minimoPartecipanti; ?>">
            <br/>
            <span>massimo:</span>
            <input class="input-small" type="text" name="inputMassimoPartecipanti" id="inputMassimoPartecipanti" value="<?php echo $f->massimoPartecipanti; ?>">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="inputDurata">Durata</label>
        <div class="controls">
            <span>ore:</span>
            <input class="input-small" type="text" name="inputDurata" id="inputDurata" value="<?php echo $f->durata; ?>">
            <br/>
            <span>giorni:</span>
            <input class="input-small" type="text" name="inputGiorni" id="inputGiorni" value="<?php echo $f->giorni; ?>">
        </div>

        <?php /*
        $abilitaLezioni = "";
        if ($f->abilitaLezioni){
            $abilitaLezioni = 'checked="checked"';
        }
        ?>
        <label class="control-label" for="abilitaLezioni">Abilita la gestione delle lezioni</label>
        <div class="controls">
            <input type="checkbox" name="abilitaLezioni" id="abilitaLezioni" value="1" <?php print $abilitaLezioni ?> />
        </div>
         * 
         */ ?>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="inputLimitePerIscrizione">Limite in giorni per l'iscrizione</label>
        <div class="controls">
            <input class="input-small" type="text" name="inputLimitePerIscrizione" id="inputLimitePerIscrizione" value="<?php echo $f->limitePerIscrizione; ?>">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="inputAttestato">Attestato</label>
        <div class="controls">
            <input class="input-xxlarge" type="text" name="inputAttestato" id="inputRapporto" value="<?php echo $f->attestato; ?>">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="inputTipoValutazione">Tipo Valutazione</label>
        <div class="controls">
            <input class="input-xxlarge" type="text" name="inputTipoValutazione" id="inputTipoValutazione" value="<?php echo $f->tipoValutazione; ?>">
        </div>
    </div>
    
    <hr/>
    
    <div class="control-group">
        <label class="control-label" for="inputRuoloDirettore">Ruolo Direttore</label>
        <div class="controls">
            <select class="input-xxlarge" name="inputRuoloDirettore" id="inputRuoloDirettore">
                <option></option>
                <?php foreach($ruoli as $r) :?>
                    <?php $selected = ""; ?>
                    <?php if(intval($f->ruoloDirettore) === intval($r->id)):?>
                        <?php $selected = "selected='selected'"; ?>
                    <?php endif ?>
                    <option <?php print $selected; ?>><?php print $r?></option>
                <?php endforeach; ?>
            </select> 
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="inputRuoloDocenti">Ruolo Docente</label>
        <div class="controls">
            <select class="input-xxlarge" name="inputRuoloDocenti" id="inputRuoloDocenti">
                <option></option>
                <?php foreach($ruoli as $r) :?>
                    <?php $selected = ""; ?>
                    <?php if(intval($f->ruoloDocenti) === intval($r->id)):?>
                        <?php $selected = "selected='selected'"; ?>
                    <?php endif ?>
                    <option <?php print $selected; ?>><?php print $r?></option>
                <?php endforeach; ?>
            </select> 
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="inputRuoloAffiancamento">Ruolo Docente di Affiancamento</label>
        <div class="controls">
            <select class="input-large" name="inputRuoloAffiancamento" id="inputRuoloAffiancamento">
                <option></option>
                <?php foreach($ruoli as $r) :?>
                    <?php $selected = ""; ?>
                    <?php if(intval($f->ruoloAffiancamento) === intval($r->id)):?>
                        <?php $selected = "selected='selected'"; ?>
                    <?php endif ?>
                    <option <?php print $selected; ?>><?php print $r?></option>
                <?php endforeach; ?>
            </select>
            
            <span>Proporzione:<span> 1 / <input class="input-small" type="text" name="inputProporzioneAffiancamento" id="inputProporzioneAffiancamento" value="<?php echo $f->proporzioneAffiancamento; ?>">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="inputRuoloDiscenti">Ruolo Discente</label>
        <div class="controls">
            <select class="input-large" name="inputRuoloDiscenti" id="inputRuoloDiscenti">
                <option></option>
                <?php foreach($ruoli as $r) :?>
                    <?php $selected = ""; ?>
                    <?php if(intval($f->ruoloDiscenti) === intval($r->id)):?>
                        <?php $selected = "selected='selected'"; ?>
                    <?php endif ?>
                    <option <?php print $selected; ?>><?php print $r?></option>
                <?php endforeach; ?>
            </select>
            
            <span>Proporzione:<span> 1 / <input class="input-small" type="text" name="inputProporzioneIstruttori" id="inputProporzioneIstruttori" value="<?php echo $f->proporzioneIstruttori; ?>">
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-large btn-success">
              <i class="icon-ok"></i>
              Aggiungi nuovo certificato
          </button>
      </div>
  </div>

