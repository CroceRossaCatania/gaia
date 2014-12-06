<?php

/*
 * (c)2014 Croce Rossa Italiana
 */

/**
 * Ottiene il contenuto HTML di un documento su Google Drive.
 * Il Documento deve essere visualizzabile pubblicamente.
 * @param $id 	ID del documento, es.: https://docs.google.com/document/d/{id}/edit
 * @return string|false 	Il contenuto HTML del documento o false in caso di fallimento
 */
function google_drive_documento_html($id) {
	return diskCache(
		"drive_{$id}",
		function() use ($id) {
			$url = "https://docs.google.com/feeds/download/documents/export/Export?id={$id}&exportFormat=html";
			$r = file_get_contents($url);
			if ( !$r ) { return false; }
			$r = str_replace(['<body', '<html'], '<div', $r);
			$r = str_replace(['</body', '</html'], '</div', $r);
			return $r;
		}
	);
}