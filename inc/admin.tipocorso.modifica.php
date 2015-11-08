<?php
/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.tipocorso&err');
$t = $_GET['id'];
$f = TipoCorso::id($t);

$ruoli = RuoloFormazione::elencoRuoli();
$qualifiche = Qualifiche::elenco("Nome ASC");
?>

<style>
    .control-group .controls span{
        display: inline-block;
        min-width: 80px;
    }
</style>

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
<form class="form-horizontal" action="?p=admin.tipocorso.modifica.ok&id=<?php echo $t; ?>" method="POST">

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
            
            <span>massimo:</span>
            <input class="input-small" type="text" name="inputMassimoPartecipanti" id="inputMassimoPartecipanti" value="<?php echo $f->massimoPartecipanti; ?>">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="inputDurata">Durata</label>
        <div class="controls">
            <span>ore:</span>
            <input class="input-small" type="text" name="inputDurata" id="inputDurata" value="<?php echo $f->durata; ?>">
            
            <span>giorni:</span>
            <input class="input-small" type="text" name="inputGiorni" id="inputGiorni" value="<?php echo $f->giorni; ?>">
        </div>
        
        <?php 
        $abilitaNazionale = "";
        if ($f->abilitaNazionale){
            $abilitaNazionale = 'checked="checked"';
        }
        ?>
        <label class="control-label" for="abilitaNazionale">Abilitato Com. Nazionale</label>
        &nbsp;<input type="checkbox" name="abilitaNazionale" id="abilitaNazionale" value="1" <?php print $abilitaNazionale ?> />
        <br/><br/>

        <?php 
        $abilitaRegionale = "";
        if ($f->abilitaRegionale){
            $abilitaRegionale = 'checked="checked"';
        }
        ?>
        <label class="control-label" for="abilitaRegionale">Abilita Com. Regionale</label>
        &nbsp;<input type="checkbox" name="abilitaRegionale" id="abilitaRegionale" value="1" <?php print $abilitaRegionale ?> />
        <br/><br/>

        <?php 
        $abilitaProvinciale = "";
        if ($f->abilitaProvinciale){
            $abilitaProvinciale = 'checked="checked"';
        }
        ?>
        <label class="control-label" for="abilitaProvinciale">Abilita Com. Provinciale</label>
        &nbsp;<input type="checkbox" name="abilitaProvinciale" id="abilitaProvinciale" value="1" <?php print $abilitaProvinciale ?> />
        <br/><br/>

        <?php 
        $abilitaLocale = "";
        if ($f->abilitaLocale){
            $abilitaLocale = 'checked="checked"';
        }
        ?>
        <label class="control-label" for="abilitaLocale">Abilita Com. Locali</label>
        &nbsp;<input type="checkbox" name="abilitaLocale" id="abilitaLocale" value="1" <?php print $abilitaLocale ?> />
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
            <select class="input-xxlarge" name="inputAttestato" id="inputAttestato">
                <option></option>
                <?php foreach($qualifiche as $q) :?>
                    <?php $selected = ""; ?>
                    <?php if(intval($f->qualifica) === intval($q->id)):?>
                        <?php $selected = "selected='selected'"; ?>
                    <?php endif ?>
                    <option <?php print $selected; ?>><?php print $q->nome?></option>
                <?php endforeach; ?>
            </select> 
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
                     <option <?php print $selected; ?> value="<?php print $r->id?> "><?php print $r->ruolo?></option>
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
                     <option <?php print $selected; ?> value="<?php print $r->id?> "><?php print $r->ruolo?></option>
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
                     <option <?php print $selected; ?> value="<?php print $r->id?> "><?php print $r->ruolo?></option>
                <?php endforeach; ?>
            </select>
            
            <span>Proporzione: 1 / <input class="input-small" type="text" name="inputProporzioneAffiancamento" id="inputProporzioneAffiancamento" value="<?php echo $f->proporzioneAffiancamento; ?>">
            </span>
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
                    <option <?php print $selected; ?> value="<?php print $r->id?> "><?php print $r->ruolo?></option>
                <?php endforeach; ?>
            </select>
            
            <span>Proporzione:<span> 1 / <input class="input-small" type="text" name="inputProporzioneIstruttori" id="inputProporzioneIstruttori" value="<?php echo $f->proporzioneIstruttori; ?>">
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

