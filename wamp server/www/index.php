<?php

// Page created by Shepard [Fabian Pijcke] <Shepard8@laposte.net>
// Arno Esterhuizen <arno.esterhuizen@gmail.com>
// and Romain Bourdon <rromain@romainbourdon.com>
// and Hervé Leclerc <herve.leclerc@alterway.fr>
// Icons by Mark James <http://www.famfamfam.com/lab/icons/silk/>
// Version 2.5 -> 3.0.0 by Dominique Ottello aka Otomatic
// 3.1.9 - Support VirtualHost IDNA ServerName
//
//
//

$server_dir = "../";

require $server_dir.'scripts/config.inc.php';
require $server_dir.'scripts/wampserver.lib.php';

//chemin jusqu'aux fichiers alias
$aliasDir = $server_dir.'alias/';

//Fonctionne à condition d'avoir ServerSignature On et ServerTokens Full dans httpd.conf
$server_software = $_SERVER['SERVER_SOFTWARE'];
$error_content = '';

// on récupère les versions des applis
$phpVersion = $wampConf['phpVersion'];
$apacheVersion = $wampConf['apacheVersion'];
$doca_version = 'doca'.substr($apacheVersion,0,3);
$mysqlVersion = $wampConf['mysqlVersion'];

//On récupère la valeur de VirtualHostMenu
$VirtualHostMenu = $wampConf['VirtualHostSubMenu'];

//on récupère la valeur de apachePortUsed
$port = $wampConf['apachePortUsed'];
$UrlPort = $port !== "80" ? ":".$port : '';
//On récupère le ou les valeurs des ports en écoute dans Apache
$ListenPorts = implode(' - ',listen_ports());
//on récupère la valeur de mysqlPortUsed
$Mysqlport = $wampConf['mysqlPortUsed'];


// répertoires à ignorer dans les projets
$projectsListIgnore = array ('.','..','wampthemes','wamplangues');

// Recherche des différents thèmes disponibles
$styleswitcher = '<select id="themes">'."\n";
$themes = glob('wampthemes/*', GLOB_ONLYDIR);
foreach ($themes as $theme) {
    if (file_exists($theme.'/style.css')) {
        $theme = str_replace('wampthemes/', '', $theme);
        $styleswitcher .= '<option id="'.$theme.'">'.$theme.'</option>'."\n";
    }
}
$styleswitcher .= '</select>'."\n";

//affichage du phpinfo
if (isset($_GET['phpinfo'])) {
	$type_info = intval(trim($_GET['phpinfo']));
	if($type_info < -1 || $type_info > 64)
		$type_info = -1;
	phpinfo($type_info);
	exit();
}

// Language
$langue = $wampConf['language'];
$i_langues = glob('wamplangues/index_*.php');
$languages = array();
foreach ($i_langues as $value) {
  $languages[] = str_replace(array('wamplangues/index_','.php'), '', $value);
}
$langueget = (!empty($_GET['lang']) ? strip_tags(trim($_GET['lang'])) : '');
if(in_array($langueget,$languages))
	$langue = $langueget;

// Recherche des différentes langues disponibles
$langueswitcher = '<form method="get" style="display:inline-block;"><select name="lang" id="langues" onchange="this.form.submit();">'."\n";
$selected = false;
foreach ($languages as $i_langue) {
  $langueswitcher .= '<option value="'.$i_langue.'"';
  if(!$selected && $langue == $i_langue) {
  	$langueswitcher .= ' selected ';
  	$selected = true;
  }
  $langueswitcher .= '>'.$i_langue.'</option>'."\n";
}
$langueswitcher .= '</select></form>';

include('wamplangues/index_english.php');
if(file_exists('wamplangues/index_'.$langue.'.php')) {
	$langue_temp = $langues;
	include('wamplangues/index_'.$langue.'.php');
	$langues = array_merge($langue_temp, $langues);
}

//initialisation
// Récupération MySQL si supporté
$MySQLdb = '';
if(isset($wampConf['SupportMySQL']) && $wampConf['SupportMySQL'] =='on') {
	$defaultDBMSMySQL = ($wampConf['mysqlPortUsed'] == '3306') ? '&nbsp;-&nbsp;Default DBMS' : '';
	$MySQLdb = <<< EOF
<dt>{$langues['versm']}</dt>
	<dd>${mysqlVersion}&nbsp;-&nbsp;{$langues['mysqlportUsed']}{$Mysqlport}{$defaultDBMSMySQL}&nbsp;-&nbsp; <a href='http://{$langues['docm']}'>{$langues['documentation']}</a></dd>
EOF;
}

// Récupération MariaDB si supporté
$MariaDB = '';
if(isset($wampConf['SupportMariaDB']) && $wampConf['SupportMariaDB'] =='on') {
	$defaultDBMSMaria = ($wampConf['mariaPortUsed'] == '3306') ? '&nbsp;-&nbsp;Default DBMS' : '';
	$MariaDB = <<< EOF
<dt>{$langues['versmaria']}</dt>
  <dd>${c_mariadbVersion}&nbsp;-&nbsp;{$langues['mariaportUsed']}{$wampConf['mariaPortUsed']}{$defaultDBMSMaria}&nbsp;-&nbsp; <a href='http://{$langues['docmaria']}'>{$langues['documentation']}</a></dd>
EOF;
}
if(empty($defaultDBMSMySQL))
	$DBMSTypes = $MariaDB.$MySQLdb;
else
	$DBMSTypes = $MySQLdb.$MariaDB;

// No Database Mysql System
$noDBMS = (empty($MySQLdb) && empty($MariaDB)) ? true : false;
$phpmyadminTool = $noDBMS ? '' : '<li><a href="phpmyadmin/">phpmyadmin</a></li>';

$aliasContents = '';

// récupération des alias
if (is_dir($aliasDir))
{
    $handle=opendir($aliasDir);
    while (($file = readdir($handle))!==false)
    {
	    if (is_file($aliasDir.$file) && strstr($file, '.conf'))
	    {
	    	if(!($noDBMS && ($file == 'phpmyadmin.conf' || $file == 'adminer.conf'))) {
		    	$msg = '';
		    	$aliasContents .= '<li><a href="'.str_replace('.conf','',$file).'/">'.str_replace('.conf','',$file).'</a></li>';
		  	}
	    }
    }
    closedir($handle);
}
if (empty($aliasContents))
	$aliasContents = "<li>".$langues['txtNoAlias']."</li>\n";


//Récupération des ServerName de httpd-vhosts.conf
$addVhost = "<li><a href='add_vhost.php?lang=".$langue."'>".$langues['txtAddVhost']."</a></li>";
if($VirtualHostMenu == "on") {
	$vhostError = false;
	$vhostErrorCorrected = true;
	$error_message = array();
    $allToolsClass = "four-columns";
	$virtualHost = check_virtualhost();
	$vhostsContents = '';
	if($virtualHost['include_vhosts'] === false) {
		$vhostsContents = "<li><i style='color:red;'>Error Include Apache</i></li>";
		$vhostError = true;
		$error_message[] = sprintf($langues['txtNoIncVhost'],$wampConf['apacheVersion']);
	}
	else {
		if($virtualHost['vhosts_exist'] === false) {
			$vhostsContents = "<li><i style='color:red;'>No vhosts file</i></li>";
			$vhostError = true;
			$error_message[] = sprintf($langues['txtNoVhostFile'],$virtualHost['vhosts_file']);
		}
		else {
				if($virtualHost['nb_Server'] > 0) {
				$port_number = true;
				$nb_Server = $virtualHost['nb_Server'];
				$nb_Virtual = $virtualHost['nb_Virtual'];
				$nb_Document = $virtualHost['nb_Document'];
				$nb_Directory = $virtualHost['nb_Directory'];
				$nb_End_Directory = $virtualHost['nb_End_Directory'];

				foreach($virtualHost['ServerName'] as $key => $value) {
					if($virtualHost['ServerNameValid'][$value] === false) {
						$vhostError = true;
						$vhostErrorCorrected = false;
						$vhostsContents .= '<li>'.$value.' - <i style="color:red;">syntax error</i></li>';
						$error_message[] = sprintf($langues['txtServerName'],"<span style='color:black;'>".$value."</span>",$virtualHost['vhosts_file']);
					}
					elseif($virtualHost['ServerNameValid'][$value] === true) {
						$UrlPortVH = ($virtualHost['ServerNamePort'][$value] != '80') ? ':'.$virtualHost['ServerNamePort'][$value] : '';
						if(!$virtualHost['port_listen'] && $virtualHost['ServerNamePortListen'][$value] !== true || $virtualHost['ServerNamePortApacheVar'][$value] !== true) {
							$value_url = ((strpos($value, ':') !== false) ? strstr($value,':',true) : $value);
							$vhostsContents .= '<li>'.$value_url.$UrlPortVH.' - <i style="color:red;">Not a Listen port</i></li>';
							if($virtualHost['ServerNamePortListen'][$value] !== true)
								$msg_error = ' not an Apache Listen port';
							elseif($virtualHost['ServerNamePortApacheVar'][$value] !== true)
								$msg_error = ' not an Apache define variable';
							if(!$vhostError) {
								$vhostError = true;
								$vhostErrorCorrected = false;
								$error_message[] = "Port ".$UrlPortVH." used for the VirtualHost is ".$msg_error;
							}
						}
						elseif($virtualHost['ServerNameIp'][$value] !== false) {
							$vh_ip = $virtualHost['ServerNameIp'][$value];
							if($virtualHost['ServerNameIpValid'][$value] !== false) {
								$vhostsContents .= '<li><a href="http://'.$vh_ip.$UrlPortVH.'">'.$vh_ip.'</a> <i>('.$value.')</i></li>';
							}
							else {
								$vhostError = true;
								$vhostErrorCorrected = false;
								$vhostsContents .= '<li>'.$vh_ip.' for '.$value.' - <i style="color:red;">IP not valid</i></li>';
								$error_message[] = sprintf($langues['txtServerNameIp'],"<span style='color:black;'>".$vh_ip."</span>","<span style='color:black;'>".$value."</span>",$virtualHost['vhosts_file']);
							}
						}
						elseif($virtualHost['DocRootNotwww'][$value] === false) {
							$vhostError = true;
							$vhostErrorCorrected = false;
							$vhostsContents .= '<li>'.$value.' - <i style="color:red;">DocumentRoot error</i></li>';
							$error_message[] = sprintf($langues['txtDocRoot'],"<span style='color:black;'>".$value."</span>","<span style='color:black;'>".$wwwDir."</span>");
						}
						elseif($virtualHost['ServerNameDev'][$value] === true) {
							$vhostError = true;
							$vhostErrorCorrected = false;
							$vhostsContents .= '<li>'.$value.' - <i style="color:red;">TLD error</i></li>';
							$error_message[] = sprintf($langues['txtTLDdev'],"<span style='color:black;'>".$value."</span>","<span style='color:black;'>.dev</span>");
						}
						else {
							$value_url = ((strpos($value, ':') !== false) ? strstr($value,':',true) : $value);
							$valueaff = ($virtualHost['ServerNameIDNA'][$value] === true) ? "<p style='margin:-8px 0 -8px 25px;'><small>IDNA-> ".$virtualHost['ServerNameUTF8'][$value]."</small></p>" : '';
							$vhostsContents .= '<li><a href="http://'.$value_url.$UrlPortVH.'">'.$value.'</a>'.$valueaff.'</li>';
						}
					}
					else {
						$vhostError = true;
						$error_message[] = sprintf($langues['txtVhostNotClean'],$virtualHost['vhosts_file']);
					}
				}
				//Check number of <Directory equals </Directory
				if($nb_End_Directory != $nb_Directory) {
					$vhostError = true;
					$vhostErrorCorrected = false;
					$error_message[] = sprintf($langues['txtNbNotEqual'],"&lt;Directory ....&gt;","&lt;/Directory&gt;",$virtualHost['vhosts_file']);
				}
				//Check number of DocumentRoot equals to number of ServerName
				if($nb_Document != $nb_Server) {
					$vhostError = true;
					$vhostErrorCorrected = false;
					$error_message[] = sprintf($langues['txtNbNotEqual'],"DocumentRoot","ServerName",$virtualHost['vhosts_file']);
				}
				//Check validity of DocumentRoot
				if($virtualHost['document'] === false) {
					foreach($virtualHost['documentPath'] as $value) {
						if($virtualHost['documentPathValid'][$value] === false) {
							$documentPathError = $value;
							$vhostError = true;
							$vhostErrorCorrected = false;
							$error_message[] = sprintf($langues['txtNoPath'],"<span style='color:black;'>".$value."</span>", "DocumentRoot", $virtualHost['vhosts_file']);
							break;
						}
					}
				}
				//Check validity of Directory Path
				if($virtualHost['directory'] === false) {
					foreach($virtualHost['directoryPath'] as $value) {
						if($virtualHost['directoryPathValid'][$value] === false) {
							$documentPathError = $value;
							$vhostError = true;
							$vhostErrorCorrected = false;
							$error_message[] = sprintf($langues['txtNoPath'],"<span style='color:black;'>".$value."</span>", "&lt;Directory ...", $virtualHost['vhosts_file']);
							break;
						}
					}
				}
				//Check number of <VirtualHost equals or > to number of ServerName
				if($nb_Server != $nb_Virtual && $wampConf['NotCheckDuplicate'] == 'off') {
					$port_number = false;
					$vhostError = true;
					$vhostErrorCorrected = false;
					$error_message[] = sprintf($langues['txtNbNotEqual'],"&lt;VirtualHost","ServerName",$virtualHost['vhosts_file']);
				}
				//Check number of port definition of <VirtualHost *:xx> equals to number of ServerName
				if($virtualHost['nb_Virtual_Port'] != $nb_Virtual && $wampConf['NotCheckDuplicate'] == 'off') {
					$port_number = false;
					$vhostError = true;
					$vhostErrorCorrected = false;
					$error_message[] = sprintf($langues['txtNbNotEqual'],"port definition of &lt;VirtualHost *:xx&gt;","ServerName",$virtualHost['vhosts_file']);
				}
				//Check validity of port number
				if($port_number && $virtualHost['port_number'] === false) {
					$port_number = false;
					$vhostError = true;
					$vhostErrorCorrected = false;
					$error_message[] = sprintf($langues['txtPortNumber'],"&lt;VirtualHost *:port&gt;",$virtualHost['vhosts_file']);
				}
				//Check if duplicate ServerName
				if($virtualHost['nb_duplicate'] > 0) {
					$DuplicateNames = '';
					foreach($virtualHost['duplicate'] as $NameValue)
						$DuplicateNames .= " ".$NameValue;
					$vhostError = true;
					$vhostErrorCorrected = false;
					$error_message[] = "Duplicate ServerName <span style='color:blue;'>".$DuplicateNames."</span> into ".$virtualHost['vhosts_file'];
				}
				//Check if duplicate Server IP
				if($virtualHost['nb_duplicateIp'] > 0) {
					$DuplicateNames = '';
					foreach($virtualHost['duplicateIp'] as $NameValue)
						$DuplicateNames .= " ".$NameValue;
					$vhostError = true;
					$vhostErrorCorrected = false;
					$error_message[] = "Duplicate IP <span style='color:blue;'>".$DuplicateNames."</span> into ".$virtualHost['vhosts_file'];
				}
			}
		}
	}
	if(empty($vhostsContents)) {
		$vhostsContents = "<li><i style='color:red:'>No VirtualHost</i></li>";
		$vhostError = true;
		$error_message[] = sprintf($langues['txtNoVhost'],$wampConf['apacheVersion']);
	}
	if(!$c_hostsFile_writable){
		$vhostError = true;
		$error_message[] = sprintf($langues['txtNotWritable'],$c_hostsFile)."<br>".nl2br($WarningMsg);
	}
	if($vhostError) {
		$vhostsContents .= "<li><i style='color:red;'>Error(s)</i> See below</li>";
		$error_content .= "<p style='color:red;'>";
		foreach($error_message as $value) {
			$error_content .= $value."<br />";
		}
		$error_content .= "</p>\n";
		if($vhostErrorCorrected)
			$addVhost = "<li><a href='add_vhost.php?lang=".$langue."'>".$langues['txtAddVhost']."</a> <span style='font-size:0.72em;color:red;'>".$langues['txtCorrected']."</span></li>";
	}
}
else {
    $allToolsClass = "three-columns";
}

//Fin Récupération ServerName

// récupération des projets
$handle=opendir(".");
$projectContents = '';
while (($file = readdir($handle))!==false)
{
	if (is_dir($file) && !in_array($file,$projectsListIgnore))
	{
		$projectContents .= '<li>'.$file.'</li>';
	}
}
closedir($handle);
if (empty($projectContents))
	$projectContents = "<li class='projectsdir'>".$langues['txtNoProjet']."</li>\n";
else {
	if(strpos($projectContents,"http://localhost/") !== false) {
		$projectContents .= "<li><i style='color:blue;'>Warning:</i> See below</li>";
		if(!isset($error_content))
			$error_content = '';
		$error_content .= "<p style='color:blue;'>".sprintf($langues['nolocalhost'],$wampConf['apacheVersion'])."</p>";
	}
	else {
		$projectContents .= "<li class='projectsdir'>".sprintf($langues['txtProjects'],$wwwDir)."</li>";
	}
}

//initialisation
$phpExtContents = '';

// récupération des extensions PHP
$loaded_extensions = get_loaded_extensions();
// classement alphabétique des extensions
setlocale(LC_ALL,"{$langues['locale']}");
sort($loaded_extensions,SORT_LOCALE_STRING);
foreach ($loaded_extensions as $extension)
	$phpExtContents .= "<li>${extension}</li>";

//vérifications diverses - Quel php.ini est chargé ?
$phpini = strtolower(trim(str_replace("\\","/",php_ini_loaded_file())));
$c_phpConfFileOri = strtolower($c_phpVersionDir.'/php'.$wampConf['phpVersion'].'/'.$phpConfFileForApache);
$c_phpCliConf = strtolower($c_phpVersionDir.'/php'.$wampConf['phpVersion'].'/'.$wampConf['phpConfFile']);

if($phpini != strtolower($c_phpConfFile) && $phpini != $c_phpConfFileOri) {
	$error_content .= "<p style='color:red;'>*** ERROR *** The PHP configuration loaded file is: ".$phpini." - should be: ".$c_phpConfFile." or ".$c_phpConfFileOri;
	$error_content .= "<br>You must perform: <span style='color:green;'>Right-click icon Wampmanager -> Refresh</span><br>";
	if($phpini == $c_phpCliConf || $phpini == $c_phpCliConfFile)
		$error_content .= " - This file is only for PHP in Command Line - Maybe you've added 'PHPIniDir' in the 'httpd.conf' file. Delete or comment this line.";
	$error_content .= "</p>";
}
if($filelist = php_ini_scanned_files()) {
	if (strlen($filelist) > 0) {
		$error_content .= "<p style='color:red;'>*** ERROR *** There are too much php.ini files</p>";
		$files = explode(',', $filelist);
		foreach ($files as $file) {
			$error_content .= "<p style='color:red;'>*** ERROR *** There are other php.ini files: ".trim(str_replace("\\","/",$file))."</p>";
		}
	}
}

$pageContents = <<< EOPAGE


<!DOCTYPE html>
<html lang="en">
<html>
<head>

	<meta charset="utf-8">

    <title>ISA Common App</title>
    <!-- main page icon -->
    <link rel="shortcut icon" href="https://miamioh.edu/fbs/_files/images/page-content/controller/staff/block-m.jpg" >

    <!-- Style sheet -->
    <link rel = "stylesheet" href = "./isa_406_style.css"> 

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"> </script>

    <!-- icons pack -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
            
</head>

<body>


    <!-- header --->
    <nav>
        <div class="nav-wrapper header row">
        	<div class="col hide-on-small-only" style="padding-top: 2vh;">
        		<a href="admin_login.html" class="waves-effect waves-light btn left" style="background-color: #d94141;">Admin Login</a>
        	</div>
        	<div class="col">
        		<a href="#" class="brand-logo center">ISA Common App</a>
        	</div>
        </div>
    </nav>


    <!-- sub header info -->
    <div id="descriptionHeader" class="row" style="padding-top: 5vh;">
        <div class="col s12 center">
            <p style="font-size: 1.5em;"> Quickly apply to all ISA department scholarships </p>
        </div>
    </div>


    <!-- user info area -->
    <div id="userInfoForm" class="row" style="padding-left: 5vh; padding-right: 5vh;">
        <div class="col show-on-large l3"> </div>
        <form class="col s12 l6">

            <p class="center step" > Step 1: Your Info</p>

            <!-- name-->
            <div class="row">
                <div class="input-field col s12 center">
                	<label> Name </label>
                    <input id="nameInput" placeholder = "Full Name" type="text">
                </div>
            </div>

             <!-- Email -->
             <div class="row">
                <div class="input-field col s12">
                	<label> Email </label>
                    <input id="emailInput" placeholder="Student@Miamioh.edu" type="email">
                </div>
            </div>   

            <div id="emailErrorMessage" class="row">
            	<div class="col s1 left">
            		 <i class="material-icons errorIcon">error_outline</i>
            	</div>

            	<div  class="col 11 left">
            		 <p style="margin: 0; margin-top: 0.5vh;"> Error:  Please use your Miami University email address </p>
            	</div>
            </div>


            <div id="nameErrorMessage" class="row">
            	<div class="col s1 left">
            		 <i class="material-icons errorIcon">error_outline</i>
            	</div>

            	<div  class="col 11 left">
            		 <p style="margin: 0; margin-top: 0.5vh;"> Error:  Please enter your full name </p>
            	</div>
            </div>


        </form>
    </div>


    <!-- location info area -->
    <div id="addressForm" class="row" style="padding-left: 5vh; padding-right: 5vh;">
        <div class="col show-on-large l3"> </div>
        <form id="userInfoForm" class="col s12 l6">

            <p class="center step" > Step 2: Home Address</p>
            <p class="center subtext"> Where to send your scholarship information </p>

            <!-- Street Address -->
            <div class="row">
                <div class="input-field col s12">
                	<label> Street  Address </label>
                    <input placeholder="Street Address" type="text">
                </div>
            </div> 

            <!-- State -->
            <div class="row">
                <div class="input-field col s12">
                	<label> State </label>
                    <input placeholder="State" type="text">
                </div>
            </div>   

            <!-- Zip -->
            <div class="row">
                <div class="input-field col s12">
                	<label> Zip </label>
                    <input placeholder="Zip Code" type="number">
                </div>
            </div> 

            <!-- Country -->
            <div class="row">
                <div class="input-field col s12">
                	<label> Country </label>
                    <input placeholder="Country" type="text">
                </div>
            </div>    

        </form>
    </div>
    



    <!-- Dars File Upload -->
    <div id="darsUploadArea" class="row">
        <input id="darFile" type="file" style="display: none" />
        <div class="col s2"></div>
        <div class="col s8 center">
            <p class="step"> Step 3: Upload Your DARS</p>
            <div class="card horizontal">
                <div class="card-stacked">
                    <div class="card-content">
                        <p>Save your dars report as an html file and upload it here</p>
                    </div>
                    <div id="darCard" class="card-action" onmouseover="dim('darCard')"; onmouseleave="revertDim('darCard')">
                    	<i id="darErrorIcon" class="material-icons left errorIcon">warning</i>
                        <a id ="darPrompt" style="color: gray;">Select Dars HTML File</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    


    <!-- Personal Statement File Upload -->
    <div id="statementUploadArea" class="row">
        <input id="statementFile" type="file" style="display: none" />
        <div class="col s2"></div>
        <div class="col s8 center">
            <p class="step"> Step 4: Personal Statement</p>
            <div class="card horizontal">
                <div class="card-stacked">
                    <div class="card-content">
                        <p>Upload your personal statement here as a PDF file</p>
                    </div>
                    <div id="statementCard" class="card-action" onmouseover="dim('statementCard')"; onmouseleave="revertDim('statementCard')">
                    	<i id="statementErrorIcon" class="material-icons left errorIcon">warning</i>
                        <a id="statementPrompt" style="color: gray;">Select Personal Statement File</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--Form navigation button (Next)-->
    <div id="navBtnRow" class="row">
        <div class="col s12 center">
            <a id=formNavBtn class="waves-effect waves-light btn" style="background-color: #d94141;"><i class="material-icons right">send</i>Next</a>
        </div>
    </div>


    <!-- Completion Message -->
    <div id="successMessageRow" class="row">
        <div class="col s12 center">
            <p class="successMessageHead"> Congradulations!</p>
            <p class="successMessage"> Keep a look out for updates by email and mail </p>
            <p class="successMessageSub"> - Best of luck, ISA Department Staff</p>
        </div>
    </div>




    <!-- padding area -->
    <div style="padding-bottom: 10vh;"></div>


    <!-- footer -->
    <footer id = admin_login_link>
        <p class="right" style="padding-right: 3vh;">
            <a href="admin_login.html" style="text-decoration: underline;">Admin Login</a>
        </p>
    </footer>







</body>

EOPAGE;
if($VirtualHostMenu == "on") {
$pageContents .= <<< EOPAGEA

EOPAGEA;
}
if(!empty($error_content)) {
$pageContents .= <<< EOPAGEB

EOPAGEB;
}
$pageContents .= <<< EOPAGEC
        

<script>
    //Fade out for user info form
    $(document).ready(function(){

    	let testing = false;

        //initialize forms and upload areas
        initForms();

        //naviage thru information and file upload fields...
        let stepNumber = 1;

        $("#formNavBtn").click(function(){

            if(stepNumber == 1){

            	let email = $("#emailInput").val();
            	let name = $("#nameInput").val();

            	//verify miami emial & name field
            	if(testing || (verifyEmail(email) && verifyName(name))){
            		$("#userInfoForm").fadeOut();
            		$("#admin_login_link").fadeOut();
	                $("#addressForm").fadeIn();
	                stepNumber++;
            	}        
            }

            else if(stepNumber == 2){
            	$("#addressForm").fadeOut();
            	$("#darErrorIcon").fadeOut();
            	$("#navBtnRow").fadeOut();
            	$("#darsUploadArea").fadeIn();
            	stepNumber++;
            }

            else if (stepNumber == 3){
                $("#darsUploadArea").fadeOut();
                $("#statementErrorIcon").fadeOut();   
                $("#navBtnRow").fadeOut(); 
                $("#statementUploadArea").fadeIn();
                stepNumber++;
            }

            else if (stepNumber == 4){
                $("#statementUploadArea").fadeOut();
                $("#navBtnRow").fadeOut();
                $("#descriptionHeader").fadeOut();
                $("#successMessageRow").fadeIn();
                stepNumber++;
            }


        });



        //open file selection
        //dars...
        $("#darCard").on("click", function() {
            $("#darFile").trigger("click");
        });


        $("#darFile").on('input', function(){
        	let fileName = $("#darFile").val().substring(12);

        	let fileExtension = fileName.split(".")[1];

        	//verify file type
			if(fileExtension == "html"){
				$("#darPrompt").text(fileName);
				$("#darErrorIcon").fadeOut();
				$("#navBtnRow").fadeIn();
			}
			else{
				$("#darPrompt").text("Please upload your DARS as an html file");
				$("#darErrorIcon").fadeIn();
			}

        });

        //statement...
        $("#statementCard").on("click", function() {
            $("#statementFile").trigger("click");

        });

        $("#statementFile").on('input', function(){
        	let fileName = $("#statementFile").val().substring(12);

        	let fileExtension = fileName.split(".")[1];

        	//verify file type
			if(fileExtension == "pdf"){
				$("#statementCard").text(fileName);
				$("#statementErrorIcon").fadeOut();
				$("#navBtnRow").fadeIn();
			}
			else{
				$("#statementErrorIcon").fadeIn();
				$("#statementPrompt").text("Please upload your personal statement as a pdf file");
			}

        });


    });


    //fade out all steps other than 1 to start
    function initForms(){
    	$("#emailErrorMessage").fadeOut();
    	$("#nameErrorMessage").fadeOut();
    	$("#addressForm").fadeOut();
        $("#darsUploadArea").fadeOut();
        $("#statementUploadArea").fadeOut();
        $("#successMessageRow").fadeOut();    
    }


    //modify brightness of given element
    function dim(id){
        let element = document.getElementById(id);
        element.style.background ="#aqua";
        element.style.filter = "brightness(70%)";
    }

    function revertDim(id){
        let element = document.getElementById(id);
        element.style.background ="white";
        element.style.filter = "brightness(100%)";
    }


    //verify email is a miami email address
    function verifyEmail(email){
    	if(email.toLowerCase().endsWith('@miamioh.edu')){
    		$("#emailErrorMessage").fadeOut(); 
    		return true;
    	}
    	$("#emailErrorMessage").fadeIn(); 
    	return false;
    }

    //verify name input has a value
    function verifyName(name){
    	if(name == ""){
    		$("#nameErrorMessage").fadeIn();
    		return false;
    	}
    	return true;
    }

</script>





</html>

EOPAGEC;

echo $pageContents;

?>
