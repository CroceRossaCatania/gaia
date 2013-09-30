<?php

/*
 * ©2012 Croce Rossa Italiana
 */
 
paginaApp([APP_PRESIDENTE ]);
 
if(!isset($_REQUEST['SUBMIT']) || !isset($_GET['code']) ){
?>
<form action="?p=rubrica.sinc" method="POST" id="step1">
	<div class="alert alert-block alert-success">
        <div class="row-fluid">
            <span class="span3">
                <label for="nomedominio">
                    <span style="font-size: larger;">
                        <i class="icon-search"></i>
                    	<strong>Dominio Google Apps da sincronizzare:</strong>
                	</span>
            	</label>
            </span>
            <span class="span9">
            	<input type="text" autofocus="" data-t="0" required="" id="nomedominio" placeholder="crigenova.org" class="span12">
        	</span>
    	</div>
        <div class="row-fluid">
            <span class="span3">
                <label for="applicationname">
                    <span style="font-size: larger;">
                        <i class="icon-search"></i>
                    	<strong>Nome applicazione:</strong>
                	</span>
            	</label>
            </span>
            <span class="span9">
            	<input type="text" autofocus="" data-t="0" required="" id="nomeapplicazione" placeholder="Sincronizzazione rubrica" class="span12">
        	</span>
    	</div>
            <div class="row-fluid">
            <span class="span3">
                <label for="oauth2clientid">
                    <span style="font-size: larger;">
                        <i class="icon-search"></i>
                    	<strong>oauth2 client id:</strong>
                	</span>
            	</label>
            </span>
            <span class="span9">
            	<input type="text" autofocus="" data-t="0" required="" id="oauth2clientid" placeholder="crigenova.org" class="span12">
        	</span>
    	</div>
    	        <div class="row-fluid">
            <span class="span3">
                <label for="oauth2clientsecret">
                    <span style="font-size: larger;">
                        <i class="icon-search"></i>
                    	<strong>oauth2 client secret:</strong>
                	</span>
            	</label>
            </span>
            <span class="span9">
            	<input type="text" autofocus="" data-t="0" required="" id="oauth2clientsecret" placeholder="crigenova.org" class="span12">
        	</span>
    	</div>
    	        <div class="row-fluid">
            <span class="span3">
                <label for="oauth2redirecturi">
                    <span style="font-size: larger;">
                        <i class="icon-search"></i>
                    	<strong>oauth2 redirect uri:</strong>
                	</span>
            	</label>
            </span>
            <span class="span9">
            	<input type="text" autofocus="" data-t="0" required="" id="oauth2redirecturi" placeholder="crigenova.org" class="span12">
        	</span>
    	</div>
    	        <div class="row-fluid">
            <span class="span3">
                <label for="developerkey">
                    <span style="font-size: larger;">
                        <i class="icon-search"></i>
                    	<strong>Developer Key:</strong>
                	</span>
            	</label>
            </span>
            <span class="span9">
            	<input type="text" autofocus="" data-t="0" required="" id="developerkey" placeholder="" class="span12">
        	</span>
    	</div>
    	        <div class="row-fluid">
            <span class="span3">
                <label for="nomesito">
                    <span style="font-size: larger;">
                        <i class="icon-search"></i>
                    	<strong>Nome sito:</strong>
                	</span>
            	</label>
            </span>
            <span class="span9">
            	<input type="text" autofocus="" data-t="0" required="" id="nomesito" placeholder="intranet.crigenova.org" class="span12">
        	</span>
    	</div>
	</div>
	<input name="submit" type="submit" class="btn btn-large" value="Conferma Dati e procedi"></input>
</form>
<div id="identificazione">

<?php
}else{
	global $apiConfig;
	$apiConfig = array(
	    // True if objects should be returned by the service classes.
	    // False if associative arrays should be returned (default behavior).
	    'use_objects' => false,
	  
	    // The application_name is included in the User-Agent HTTP header.
	    'application_name' => 'intranet.crigenova.org',
	
	    // OAuth2 Settings, you can get these keys at https://code.google.com/apis/console
	    'oauth2_client_id' => '562921316183-vb2kj1jtompkv4st9n4hkbttphombon6.apps.googleusercontent.com',
	    'oauth2_client_secret' => 'RGnuDVTxOJXmsBdnh856jnbw',
	    'oauth2_redirect_uri' => 'http://intranet.crigenova.org/new/libs/gapps-sig.php',
	
	    // The developer key, you get this at https://code.google.com/apis/console
	    'developer_key' => 'AIzaSyDDDh5sX_7yIcZP5pN7CbSOGlF0YhPql5o',
	  
	    // Site name to show in the Google's OAuth 1 authentication screen.
	    'site_name' => 'intranet.crigenova.org',
	
	    // Which Authentication, Storage and HTTP IO classes to use.
	    'authClass'    => 'Google_OAuth2',
	    'ioClass'      => 'Google_CurlIO',
	    'cacheClass'   => 'Google_FileCache',
	    'basePath' => 'https://www.googleapis.com',
	    'ioFileCache_directory'  =>
	        (function_exists('sys_get_temp_dir') ?
	            sys_get_temp_dir() . '/Google_Client' :
	        '/tmp/Google_Client'),
	    'services' => array(
	      'analytics' => array('scope' => 'https://www.googleapis.com/auth/analytics.readonly'),
	      'calendar' => array(
	          'scope' => array(
	              "https://www.googleapis.com/auth/calendar",
	              "https://www.googleapis.com/auth/calendar.readonly",
	          )
	      ),
	      'oauth2' => array(
	          'scope' => array(
	              'https://www.googleapis.com/auth/userinfo.profile',
	              'https://www.googleapis.com/auth/userinfo.email',
	          )
	      ),
	      'emailsettings' => array(
	          'scope' => array(
	              'https://apps-apis.google.com/a/feeds/emailsettings/2.0/'
	          )
	      ),
	      'plus' => array('scope' => 'https://www.googleapis.com/auth/plus.login'),
	      'siteVerification' => array('scope' => 'https://www.googleapis.com/auth/siteverification'),
	      'tasks' => array('scope' => 'https://www.googleapis.com/auth/tasks'),
	      'urlshortener' => array('scope' => 'https://www.googleapis.com/auth/urlshortener')
	    )
	);
	
	require_once 'core/class/gapps-oauth/Google_Client.php';
	require_once 'core/class/gapps-oauth/contrib/Google_Oauth2Service.php';
	
	$client = new Google_Client();
	$client->setScopes(array(
	    'https://apps-apis.google.com/a/feeds/groups/',
	    'https://apps-apis.google.com/a/feeds/alias/',
	    'https://apps-apis.google.com/a/feeds/user/',
	    'https://apps-apis.google.com/a/feeds/emailsettings/2.0/',
	    'https://www.googleapis.com/auth/admin.directory.user',
	));
	
	if (isset($_REQUEST['logout'])) {
	  unset($_SESSION['access_token']);
	}
	
	if (isset($_GET['code'])) {
	  $client->authenticate();
	  $_SESSION['access_token'] = $client->getAccessToken();
	  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
	}
	if (isset($_SESSION['access_token'])) {
	  $client->setAccessToken($_SESSION['access_token']);
	}
	if ($client->getAccessToken()) {
		//E' qui che avviene l'azione!!
		//recupero la lista di utenti dal server
		$req = new Google_HttpRequest("https://www.googleapis.com/admin/directory/v1/users?domain=crigenova.org&key=".$apiConfig['developer_key']);
		$resp = $client::getIo()->authenticatedRequest($req);
		$megarray=json_decode($resp->getResponseBody(), true);
		foreach ($megarray["users"] AS $k=>$v){
			$arutenti[]=$megarray["users"][$k]["primaryEmail"];
			//$megarray["users"][$k]["name"]["givenName"]
			//$megarray["users"][$k]["name"]["familyName"]
			//$megarray["users"][$k]["name"]["fullName"]
			//$megarray["users"][$k]["organizations"][0]["title"] //titolo della persona (uno piu comodo no?)
			//$megarray["users"][$k]["relations"][0]["value"] //nome della persona (uno piu comodo no?)
			//$megarray["users"][$k]["phones"][0]["value"] //telefono della persona (uno piu comodo no?)
			
		}
	//i contatti li imposto a livello di dominio quindi non per utente
	$listacontatti="array di contatti formati come sotto";
	$esempiocontatto=<<<EOF
	<atom:entry xmlns:atom='http://www.w3.org/2005/Atom'
	    xmlns:gd='http://schemas.google.com/g/2005'>
	  <atom:category scheme='http://schemas.google.com/g/2005#kind'
	    term='http://schemas.google.com/contact/2008#contact' />
	  <gd:name>
	     <gd:givenName>Elizabeth</gd:givenName>
	     <gd:familyName>Bennet</gd:familyName>
	     <gd:fullName>Elizabeth Bennet</gd:fullName>
	  </gd:name>
	  <atom:content type='text'>Notes</atom:content>
	  <gd:email rel='http://schemas.google.com/g/2005#work'
	    primary='true'
	    address='liz@gmail.com' displayName='E. Bennet' />
	  <gd:email rel='http://schemas.google.com/g/2005#home'
	    address='liz@example.org' />
	  <gd:phoneNumber rel='http://schemas.google.com/g/2005#work'
	    primary='true'>
	    (206)555-1212
	  </gd:phoneNumber>
	  <gd:phoneNumber rel='http://schemas.google.com/g/2005#home'>
	    (206)555-1213
	  </gd:phoneNumber>
	  <gd:im address='liz@gmail.com'
	    protocol='http://schemas.google.com/g/2005#GOOGLE_TALK'
	    primary='true'
	    rel='http://schemas.google.com/g/2005#home' />
	  <gd:structuredPostalAddress
	      rel='http://schemas.google.com/g/2005#work'
	      primary='true'>
	    <gd:city>Mountain View</gd:city>
	    <gd:street>1600 Amphitheatre Pkwy</gd:street>
	    <gd:region>CA</gd:region>
	    <gd:postcode>94043</gd:postcode>
	    <gd:country>United States</gd:country>
	    <gd:formattedAddress>
	      1600 Amphitheatre Pkwy Mountain View
	    </gd:formattedAddress>
	  </gd:structuredPostalAddress>
	</atom:entry>
EOF;
	//$arlistacontatti=array_chunk($listacontatti, 100);
	//foreach($arlistacontatti AS $blocco_di_contatti){
		//fai la richiesta ma prima il blocco va imploso in qualcosa di consistente
		//$req = new Google_HttpRequest("https://www.google.com/m8/feeds/contacts/crigenova.org/full","PUT",$headers,$xml);
		//$resp = $client::getIo()->authenticatedRequest($req);
	//}
	
	
	
		//questo lascialo cosi
	  // The access token may have been updated lazily.
	  $_SESSION['access_token'] = $client->getAccessToken();
	} else {
	  $authUrl = $client->createAuthUrl();
	}
	if(isset($authUrl)) {
		print '<a href="'.$authUrl.'" class="btn btn-large">Autenticati per sincronizzare <i class="icon-chevron-right"></i></a>';
	} else {
		echo '<a href="?logout" class="btn btn-large">Logout <i class="icon-remove"></i></a>';
	}
}

?>

</div>