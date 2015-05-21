<?php

/*
 * (c)2014 Il Progetto Gaia ed i suoi contributori
 *
 * == ISTRUZIONI D'USO ==
 * a. Creare una directory in assets/min/ con data odierna in formato YYYYMMDD.
 * b. Creare i file css.build e js.build contenenti, rispettivamente ed in
 *    ordine, tutti i CSS ed i JS da includere (relativamente alla path di Gaia).
 * c. $ cd gaia/
 * d. $ php scripts/minifica-assets.php
 * e. Aggiornare index.php con i nuovi riferimenti generati dallo script.
 */

if ( !is_readable('LICENSE.txt') ) {
	echo "Per favore, esegui lo script dalla root di Gaia.\n";
	exit(1);
}

if ( !function_exists('curl_init') ) {
	echo "Necessaria libreria CURL (prova con php5-curl).\n";
	exit(1);
}

$data	= date('Ymd'); 
$base   = realpath(dirname( __FILE__ ));
$dir 	= "{$base}/assets/min/{$data}";

$js_contatore 	= 0;
$css_contatore	= 0;
$js_filesize 	= 0;
$css_filesize 	= 0;
$js_build 		= "{$dir}/js.build";
$css_build		= "{$dir}/css.build";

if ( !is_dir($dir) ) {
    @mkdir("{$dir}");
    //echo "Errore: Non esiste la directory {$dir}.\n";
    //exit(1);
}
copyfile($base."/assets/js.build", $js_build);
copyfile($base."/assets/css.build", $css_build);


echo "[...] Caricamento JS...\n";
$js_build		= minifica(
	$js_build,
	$js_contatore,
	$js_filesize
);
echo "\n";

echo "[...] Caricamento CSS...\n";
$css_build 		= minifica(
	$css_build,
	$css_contatore,
	$css_filesize
);
echo "\n";

$t_filesize = $css_filesize + $js_filesize;

echo "[...] Compilazione JS (Google Closure)...";
$js_output 		= closure($js_build);
$js_output 		= json_decode($js_output);
$js_build 		= $js_output->compiledCode;
$js_output		= json_encode($js_output, JSON_PRETTY_PRINT);
echo "... [OK]\n";
file_put_contents("{$dir}/build/build.js.log", $js_output);
echo "[OK] Output di Closure salvato in {$dir}/build/build.js.log\n";

echo "[...] Minificazione CSS (YUI Compressor)...";
$css_build		= yuicss($css_build);
echo "... [OK]\n";

echo "[...] Salvo i risultati su disco...";
$signature = date('r') . "\nby " . 
	get_current_user() . "@" . gethostname() . "\n";
@mkdir("{$dir}/build");
file_put_contents("{$dir}/build/build.css", 	$css_build);
file_put_contents("{$dir}/build/build.js", 		$js_build);
file_put_contents("{$dir}/build/signature", 	$signature);
echo "... [OK]\n";

$css_new_filesize = strlen($css_build) + 1;
$js_new_filesize  = strlen($js_build)  + 1;
$t_new_filesize   = $css_new_filesize + $js_new_filesize;
$t_contatore  	  = $js_contatore + $css_contatore;

$css_ratio = round( $css_new_filesize / $css_filesize * 100, 2 );
$js_ratio  = round( $js_new_filesize  / $js_filesize  * 100, 2 );
$t_ratio   = round( $t_new_filesize	  / $t_filesize   * 100, 2 );

$css_filesize     = number_format($css_filesize);
$js_filesize      = number_format($js_filesize);
$css_new_filesize = number_format($css_new_filesize);
$js_new_filesize  = number_format($js_new_filesize);
$t_filesize       = number_format($t_filesize);
$t_new_filesize   = number_format($t_new_filesize);

echo <<<EOL

Operazioni concluse.

[INPUT]
 * CSS data..: {$css_filesize} bytes in {$css_contatore} files
 * JS data...: {$js_filesize} bytes in {$js_contatore} files
 * Total data: {$t_filesize} bytes in {$t_contatore} files

[OUTPUT]
 * CSS data..: {$css_new_filesize} bytes (ratio is {$css_ratio}%)
 * JS data...: {$js_new_filesize} bytes (ratio is {$js_ratio}%)
 * Total data: {$t_new_filesize} bytes (ratio is {$t_ratio}%)

[LINK]
\t<link href="/assets/min/{$data}/build/build.css" rel="stylesheet" media="screen">
\t<script type="text/javascript" src="/assets/min/{$data}/build/build.js"></script>


EOL;


function copyfile($src, $dst){
    echo "trying to copy $src >> $dst ...\n";
    if (!copy($src, $dst)) {
        echo "failed to copy $src >> $dst ...\n";
    }
}

function minifica($build_file, &$contatore, &$filesize) {
	global $dimensione_originale, $base;

	if (!is_readable($build_file)) {
		echo "Errore: Impossibile trovare {$build_file}.\n";
		exit(1);
	}

	$output = '';
	foreach ( file($build_file) as $url ) {

		if ( !$url ) 
			continue;

		$url = trim($url);

		if ( strpos($url, '://') == false )
			$url = "{$base}/{$url}";

		echo "[GET] {$url}\n";
		$content = file_get_contents($url);

		if ( !$content ) {
			echo "[ERRORE] ({$build_file}:404) {$url}\n";
			continue;
		}

		$contatore++;
		$filesize += strlen($content) + 1;
		$output .= $content . "\n\n";

	}

	return $output;

}

function closure($js) {
	$ch = curl_init('http://closure-compiler.appspot.com/compile');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'language=ECMASCRIPT5&output_info=compiled_code&output_info=errors&output_format=json&compilation_level=SIMPLE_OPTIMIZATIONS&js_code=' . urlencode($js));
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}

function yuicss($css) {
	$ch = curl_init('http://reducisaurus.appspot.com/css');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'file=' . urlencode($css));
	$output = curl_exec($ch);
	curl_close($ch);
	$output = str_replace("../", "../../../", $output);
	return $output;
}
