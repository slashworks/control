<?php

    function rrmdir($dir){if (is_dir($dir)) {$objects = scandir($dir);foreach ($objects as $object) {if ($object != "." && $object != "..") {if (is_dir($dir . "/" . $object)) {rrmdir($dir . "/" . $object);} else {unlink($dir . "/" . $object);}}}rmdir($dir);}}
    function folder_exist($folder){$path = realpath($folder);return ($path !== false AND is_dir($path)) ? $path : false;}

    function generateLabel($sPath){
        return "<span style='color:".((file_exists($sPath)?"#00aa00'>[ gefunden ]</span>":"#aa0000'>[ nicht gefunden ]</span>"))."</span>";
    }
    /**
     * Do Backup config files and keys from old system
     */
    if (isset($_GET['backup'])) {
        try {
            $sBackupPath = __DIR__ . '/../_backup';
            mkdir($sBackupPath);
            $sResponse = "OK";
            if (file_exists(__DIR__ . '/../app/config/parameters.yml') && file_exists(__DIR__ . '/../src/Slashworks/AppBundle/Resources/private/api/keys/server/private.key') && file_exists(__DIR__ . '/../src/Slashworks/AppBundle/Resources/private/api/keys/server/public.key')) {
                if (!copy(__DIR__ . '/../app/config/parameters.yml', $sBackupPath . "/parameters.yml")) {
                    $sResponse = "Fehler beim sichern der Datei \"parameters.yml\"";
                } else {
                    if (!copy(__DIR__ . '/../src/Slashworks/AppBundle/Resources/private/api/keys/server/private.key', $sBackupPath . "/private.key")) {
                        $sResponse = "Fehler beim sichern der Datei \"private.key\"";
                    } else {
                        if (!copy(__DIR__ . '/../src/Slashworks/AppBundle/Resources/private/api/keys/server/public.key', $sBackupPath . "/public.key")) {
                            $sResponse = "Fehler beim sichern der Datei \"public.key\"";
                        }
                    }
                }
            } else {
                @rmdir($sBackupPath);
                $sResponse = "Die zu sichernden Dateien wurden nicht gefunden. Folgende Dateien wurden gesucht:<br><br>app/config/parameters.yml <strong>".generateLabel(__DIR__ . '/../app/config/parameters.yml')."</strong><br>src/Slashworks/AppBundle/Resources/private/api/keys/server/private.key <strong>".generateLabel(__DIR__ . '/../src/Slashworks/AppBundle/Resources/private/api/keys/server/private.key')."</strong><br>src/Slashworks/AppBundle/Resources/private/api/keys/server/private.key <strong>".generateLabel(__DIR__ . '/../src/Slashworks/AppBundle/Resources/private/api/keys/server/public.key')."</strong><br><br>Wenn Sie dennoch fortfahren möchten, klicken Sie auf <strong>Weiter</strong>.";
            }

        } catch (\Exception $e) {
            $sResponse = $e->getMessage();
        }

        echo $sResponse;
        die();
    }

    /**
     * Do Restore config files and keys to new structure
     */
    if (isset($_GET['restore'])) {

        try {
            $sBackupPath = __DIR__ . '/../_backup';
            if (!folder_exist(__DIR__ . '/../vendor/slashworks/control-bundle/src/Slashworks/AppBundle/Resources/private/api/keys/server')) {
                mkdir(__DIR__ . '/../src/Slashworks/AppBundle/Resources/private/api/keys/server/', 0777, true);
            }
            $sResponse = "OK";

            if (!copy($sBackupPath . "/parameters.yml", __DIR__ . '/../app/config/parameters.yml')) {
                $sResponse = "Fehler beim zurückspielen der Datei <strong>_backup/public.key</strong>. Möglicherweise existiert sie im Backup-Verzeichnis nicht.";
            } else {
                if (!copy($sBackupPath . "/private.key", __DIR__ . '/../src/Slashworks/AppBundle/Resources/private/api/keys/server/private.key')) {
                    $sResponse = "Fehler beim zurückspielen der Datei <strong>_backup/private.key</strong>. Möglicherweise existiert sie im Backup-Verzeichnis nicht.";
                } else {
                    if (!copy($sBackupPath . "/public.key", __DIR__ . '/../src/Slashworks/AppBundle/Resources/private/api/keys/server/public.key')) {
                        $sResponse = "Fehler beim zurückspielen der Datei <strong>_backup/public.key</strong>. Möglicherweise existiert sie im Backup-Verzeichnis nicht.";
                    }
                }
            }

            /**
             * delete old src-folder
             */
            if ($sResponse === "OK") {
                if (folder_exist(__DIR__ . '/../src')) {
                    rrmdir(__DIR__ . '/../src');
                }
            }
        } catch (\Exception $e) {
            $sResponse = $e->getMessage();
        }

        echo $sResponse;
        die();
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Control - Migration Script</title>
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Titillium+Web:400,700">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-MfvZlkHCEqatNoGiOXveE8FIwMzZg4W85qfrfIFBfYc= sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <style>
        body{background-color:#f8f8f8;font-family:'Titillium Web',"Helvetica Neue",Helvetica,Arial,sans-serif}#wrapper{width:100%}#page-wrapper{padding:0 15px;min-height:568px;background-color:#fff}@media(min-width:768px){#page-wrapper{position:inherit;margin:0;padding:0 30px;border-left:1px solid #e7e7e7}}.control .navbar-static-top{background-color:#333;padding-left:30px;padding-right:30px;border-bottom:5px solid #515151}.control .btn-circle{background:#333;border-color:#515151;color:#fff}.control .btn-circle:hover{background:#f2963f;border-color:#cc7e35;color:#fff}.control .navbar-default .navbar-nav{float:right}.control .navbar-default .navbar-nav>li>a{color:#fff}.control .logo{height:auto;padding:10px 0;margin-left:10px}.control .status_active{color:#4bd171}.control .logo>img{float:left}.control .logo .floatblock{float:left;padding-top:5px;padding-left:5px}.control .logo .name{color:#f2963f;font-weight:600;font-size:42px;display:block;line-height:40px}.control .logo .version{display:block;font-size:16px;padding-left:2px;color:#fff}.nav.context{display:inline-block}.nav.context>li>a{padding:0}.dropdown-toggle.header{color:#fff;background:#333;width:50px;height:50px;border-radius:50px;font-size:23px;padding:10px;min-height:inherit;margin-top:18px}.dropdown-toggle.header:hover,.nav .open>.dropdown-toggle.header,.nav .open>.dropdown-toggle.header:hover,.nav .open>.dropdown-toggle.header:focus{background:#515151}.control .btn-primary{background:#333;border-color:#515151;color:#fff}.control .btn-primary:hover{background:#f2963f;border-color:#cc7e35;color:#fff}.form-inline input.form-control{width:400px}a{color:#333}a:hover{color:#f2963f}.text-center{width:10%}a.action-button{background:#333;border-color:#515151;color:#fff;overflow:hidden;display:inline-block;border-radius:30px;width:30px;line-height:30px;text-align:center;margin-right:8px}.modalsize .modal-dialog{width:70%}.nav>li>a.action-button:hover,.nav>li>a.action-button:focus .nav>li>a.action-button:active,a.action-button:hover,a.action-button:focus,a.action-button:active,.nav>li>a.action-button:hover,.nav>li>a.action-button:focus{background:#f2963f;border-color:#cc7e35;color:#fff}.form-inline .form-control{margin-left:5px}table .status,table .maintancemode{text-align:center;vertical-align:middle}.tooltip-inner{background:#333}.tooltip.top .tooltip-arrow{border-top-color:#333}.tooltip.top-left .tooltip-arrow{border-top-color:#333}.tooltip.top-right .tooltip-arrow{border-top-color:#333}.tooltip.right .tooltip-arrow{border-right-color:#333}.tooltip.left .tooltip-arrow{border-left-color:#333}.tooltip.bottom .tooltip-arrow{border-bottom-color:#333}.tooltip.bottom-left .tooltip-arrow{border-bottom-color:#333}.tooltip.bottom-right .tooltip-arrow{border-bottom-color:#333}.control td.details-control,.control tr.shown td.details-control{background:0;color:#333;font-size:10px}.control td.details-control:before,.control tr.shown td.details-control:before{font-family:FontAwesome;content:"\f01a";font-size:20px;text-align:center;width:100%;display:block;vertical-align:middle}.control tr.shown td.details-control:before{content:"\f01b"}.control .dataTable td{vertical-align:middle}.control .dataTable .customer{text-align:center}.control .dataTable .offline td{background-color:#f2963f}.control .dataTable .deactivated td{background-color:#eee!important;color:#aaa!important}.control .dataTable .deactivated td .status_active,.control .dataTable .deactivated td .status_inactive{display:none}.pagination>li>a{background:#333;border-color:#515151}.pagination>.active>a,.pagination>.active>span,.pagination>.active>a:hover,.pagination>.active>span:hover,.pagination>.active>a:focus,.pagination>.active>span:focus{background:#f2963f;border-color:#cc7e35}.control .dataTable td.extensions,.control .dataTable th.extensions{display:none}.navbar-top-links{margin-right:0}.navbar-top-links li{display:inline-block}.navbar-top-links li:last-child{margin-right:15px}.navbar-top-links li a{padding:15px;min-height:50px}.navbar-top-links .dropdown-menu li{display:block}.navbar-top-links .dropdown-menu li:last-child{margin-right:0}.navbar-top-links .dropdown-menu li a{padding:3px 20px;min-height:0}.navbar-top-links .dropdown-menu li a div{white-space:normal}.navbar-top-links .dropdown-messages,.navbar-top-links .dropdown-tasks,.navbar-top-links .dropdown-alerts{width:310px;min-width:0}.navbar-top-links .dropdown-messages{margin-left:5px}.navbar-top-links .dropdown-tasks{margin-left:-59px}.navbar-top-links .dropdown-alerts{margin-left:-123px}.navbar-top-links .dropdown-user{right:0;left:auto}.sidebar .sidebar-nav.navbar-collapse{padding-right:0;padding-left:0}.sidebar .sidebar-search{padding:15px}.sidebar ul li{border-bottom:1px solid #e7e7e7}.sidebar ul li a.active{background-color:#eee}.sidebar .arrow{float:right}.sidebar .fa.arrow:before{content:"\f104"}.sidebar .active>a>.fa.arrow:before{content:"\f107"}.sidebar .nav-second-level li,.sidebar .nav-third-level li{border-bottom:0!important}.sidebar .nav-second-level li a{padding-left:37px}.sidebar .nav-third-level li a{padding-left:52px}.logs{overflow:hidden}.logs dt,.logs dd{float:left}.logs dt{clear:both;width:20%}.logs dd{width:80%}@media(min-width:768px){.sidebar{z-index:1;position:absolute;width:250px;margin-top:51px}.navbar-top-links .dropdown-messages,.navbar-top-links .dropdown-tasks,.navbar-top-links .dropdown-alerts{margin-left:auto}}.btn-outline{color:inherit;background-color:transparent;transition:all .5s}.btn-primary.btn-outline{color:#428bca}.btn-success.btn-outline{color:#5cb85c}.btn-info.btn-outline{color:#5bc0de}.btn-warning.btn-outline{color:#f0ad4e}.btn-danger.btn-outline{color:#d9534f}.btn-primary.btn-outline:hover,.btn-success.btn-outline:hover,.btn-info.btn-outline:hover,.btn-warning.btn-outline:hover,.btn-danger.btn-outline:hover{color:#fff}.chat{margin:0;padding:0;list-style:none}.chat li{margin-bottom:10px;padding-bottom:5px;border-bottom:1px dotted #999}.chat li.left .chat-body{margin-left:60px}.chat li.right .chat-body{margin-right:60px}.chat li .chat-body p{margin:0}.panel .slidedown .glyphicon,.chat .glyphicon{margin-right:5px}.chat-panel .panel-body{height:350px;overflow-y:scroll}.panel-default>.panel-heading.login{overflow:hidden;text-align:center;background-color:#333;padding-left:30px;padding-right:30px;border-bottom:5px solid #515151}.control .panel-default>.panel-heading.login .logo{float:none;display:inline-block}.btn-success{background:#333;border-color:#515151;float:right}.btn-success:hover,.btn-success:focus,.btn-success:active{background:#f2963f;border-color:#cc7e35}.login-panel{margin-top:25%}.flot-chart{display:block;height:400px}.flot-chart-content{width:100%;height:100%}table.dataTable thead .sorting,table.dataTable thead .sorting_asc,table.dataTable thead .sorting_desc,table.dataTable thead .sorting_asc_disabled,table.dataTable thead .sorting_desc_disabled{background:0}table.dataTable thead .sorting_asc:after{content:"\f0de";float:right;font-family:fontawesome}table.dataTable thead .sorting_desc:after{content:"\f0dd";float:right;font-family:fontawesome}table.dataTable thead .sorting:after{content:"\f0dc";float:right;font-family:fontawesome;color:rgba(50,50,50,.5)}.btn-circle{width:30px;height:30px;padding:6px 0;border-radius:15px;text-align:center;font-size:12px;line-height:1.428571429}.btn-circle.btn-lg{width:50px;height:50px;padding:10px 16px;border-radius:25px;font-size:18px;line-height:1.33}.btn-circle.btn-xl{width:70px;height:70px;padding:10px 16px;border-radius:35px;font-size:24px;line-height:1.33}.show-grid [class^=col-]{padding-top:10px;padding-bottom:10px;border:1px solid #ddd;background-color:#eee!important}.show-grid{margin:15px 0}.huge{font-size:40px}.panel-green{border-color:#5cb85c}.panel-green .panel-heading{border-color:#5cb85c;color:#fff;background-color:#5cb85c}.panel-green a{color:#5cb85c}.panel-green a:hover{color:#3d8b3d}.panel-red{border-color:#d9534f}.panel-red .panel-heading{border-color:#d9534f;color:#fff;background-color:#d9534f}.panel-red a{color:#d9534f}.panel-red a:hover{color:#b52b27}.panel-yellow{border-color:#f0ad4e}.panel-yellow .panel-heading{border-color:#f0ad4e;color:#fff;background-color:#f0ad4e}.panel-yellow a{color:#f0ad4e}.panel-yellow a:hover{color:#df8a13}.button-divider{display:inline-block;padding:0 5px;color:#ccc}.head-controls{position:absolute;top:10px;right:10px}.fa-ban{color:#666}.fa-spin{color:#fff!important}.type-website:before{content:"\f13b"}.type-onlineshop:before{content:"\f07a"}.type-custom:before{content:"\f085"}.type-contao{font-family:"SVG Font"!important}.type-contao:before{content:"\e056"}td.details-control{background:url('/images/details_open.png') no-repeat center center;cursor:pointer}tr.shown td.details-control{background:url('/images/details_close.png') no-repeat center center}@font-face{font-family:"SVG Font";src:url('/fonts/rocksolid-icons.eot');src:url('/fonts/rocksolid-icons.eot?#iefix') format('embedded-opentype'),url('/fonts/rocksolid-icons.woff') format('woff'),url('/fonts/rocksolid-icons.ttf') format('truetype'),url('/fonts/rocksolid-icons.svg#svg_fontregular') format('svg');font-weight:normal;font-style:normal}.glyph{display:inline-block;width:120px;margin:10px;text-align:center;vertical-align:top;background:#eee;border-radius:10px;box-shadow:1px 1px 5px rgba(0,0,0,.2)}.glyph-icon{padding:10px;display:block;font-family:"SVG Font";font-size:64px;line-height:1}.glyph-icon:before{content:attr(data-icon)}.class-name{font-size:12px}.glyph>input{display:block;width:100px;margin:5px auto;text-align:center;font-size:12px;cursor:text}.glyph>input.icon-input{font-family:"SVG Font";font-size:16px;margin-bottom:10px}.fa-red{color:#600!important}.fa-working{color:#fff!important}tr.inactive,tr.inactive i{color:#ccc!important}tr.inactive img{-webkit-filter:grayscale(1) opacity(.5);filter:grayscale(1) opacity(.5)}.growl-animated{z-index:9999!important}#ajax-loader{padding:5px 10px;background-color:#fff;position:fixed;bottom:5px;right:5px;z-index:99999}.sf-minitoolbar{right:50px!important;z-index:222!important}.dropdown-menu>li>a>i{width:16px;display:inline-block}#slashworks_appbundle_license_domain,#slashworks_appbundle_license_max_clients,#slashworks_appbundle_license_valid_until{background-color:#fff;border:0;box-shadow:none;padding-left:0}.dropdown-menu{min-width:200px}
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .tab-pane {
            padding: 30px;
            min-height: 300px;
        }

        .nav-pills > li.active > a, .nav-pills > li.active > a:focus, .nav-pills > li.active > a:hover {
            background-color: #f2963f;
        }

        .progress-bar {
            background-color: #f2963f;
        }

        .done a {
            color: #ccc;
        }

        .tab-title a {
            text-align: center;
        }

        .message .panel{
            display: none;
        }

        .filelist{
            list-style-type: none;
            padding:10px;
            border: 1px solid #999;
            background-color: #fafafa;
            border-radius:10px;
            width:95%;
        }

        .button-next{
            margin-top:25px;
        }
    </style>
</head>
<body class="control">
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="navbar-header">

            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand logo" href="/">

                <img src="http://contao-monitoring.de/files/lp_control/theme/img/control-logo.png" alt="Logo"/>

                <div class="floatblock">
                    <span class="name">control</span>
                    <span class="version">Contao Monitoring</span>
                </div>

            </a>
        </div>
    </nav>
    <div id="page-wrapper" style="margin:0 !important;">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-8 col-md-offset-2">

                    <h1 style="text-align: center;margin-bottom:60px;">Willkommen zum Mirgrationsassistenten</h1>

                    <div id="rootwizard">
                        <div class="navbar">
                            <div class="navbar-inner">
                                <div class="container">
                                    <ul class="container-fluid">
                                        <li class="tab-title col-xs-2 col-xs-offset-1"><a href="#tab1" data-toggle="tab">1. Start <i></i></a></li>
                                        <li class="tab-title col-xs-2"><a href="#tab2" data-toggle="tab">2. Sichern <i></i></a></li>
                                        <li class="tab-title col-xs-2"><a href="#tab3" data-toggle="tab">3. Kopieren <i></i></a></li>
                                        <li class="tab-title col-xs-2"><a href="#tab4" data-toggle="tab">4. Erstellen <i></i></a></li>
                                        <li class="tab-title col-xs-2"><a href="#tab5" data-toggle="tab">5. Fertig</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content">


                            <!--

                            SCHRITT 1

                            -->
                            <div class="tab-pane" id="tab1">

                                <h3>Bevor wir starten...</h3>

                                <p>
                                    Dieser migrationsassistent soll dabei behilflich sein, von der alten Version des Monitoringstools auf die neue Version umzustellen. Dabei müssen einige Dingebeachtet werden, welche im Laufe dieses
                                    Vorgangs erläutert werden. Bitte lesen Sie sich alle Schritte genau durch und gefolgen Sie die Anweisungen. Bitte erstellen Sie sicherheitshalber ein Backup der Datenbank sowie der eigentlichen Dateien um
                                    im Fehlerfall wieder auf den alten Stand zurückstellen zu können.<br><br>Bei Problemen und Fragen wenden Sie sich gern an <a href="mailto:support@contao-monitoring.de?subject=Problem beim Migrationsassistenten">support@contao-monitoring.de</a>
                                </p>

                                <p>
                                    <button type="button" class="button-next btn btn-primary">Migration starten</button>
                                </p>
                            </div>


                            <!--

                            SCHRITT 2

                            -->
                            <div class="tab-pane" id="tab2">


                                <h3>Alte Dateien sichern</h3>

                                <p>
                                    Zunächst werden für die neue Installation benötigte Dateien gesichert. Dabei handelt es sich zum einen um die Datei <strong>parameters.yml</strong>, in der alle systemrelevanten Informationen wie
                                    Zugangsdaten etc. gespeichert sind, und zum anderen den beiden Dateien <strong>public.key</strong> und <strong>private.key</strong>, welche für die individuelle Verschlüsselung zuständig sind.<br><br>Diese
                                    Dateien werden nun in einen Ordner namens <strong>_backup</strong> gesichert. Sollte dieser Ordner nach Abschluß des Assistenten und nach erfolgreicher Prüfung der Installation noch vorhanden sein, muss
                                    dieser unbedingt gelöscht werden.
                                </p>

                                <p>
                                    <button type="button" class="btn btn-primary" onclick="doBackup();" id="do_backup">Daten Sichern</button>
                                </p>
                                <div class="message backup_message">
                                    <div class="panel panel-red">
                                        <div class="panel-heading">
                                            Fehler
                                        </div>
                                        <div class="panel-body">
                                            <p>...</p>
                                        </div>
                                    </div>
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            Erfolgreich
                                        </div>
                                        <div class="panel-body">
                                            <p>...</p>
                                        </div>
                                    </div>
                                    <button type="button" class="button-next btn btn-primary" id="backup_next" style="display:none;">Weiter</button>
                                </div>
                            </div>


                            <!--

                            SCHRITT 3

                            -->
                            <div class="tab-pane" id="tab3">


                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h3>Kopieren der neuen Dateien</h3>

                                            <p>
                                                Es ist soweit. Nun müssen die Dateien des neuen Releases kopiert. Dazu entpacke die Zip-Datei und lade alle Dateien auf den Server. Bestätige alle möglichen Hinweise für das Überschreiben von
                                                Dateien. Nach Abschluß des Kopiervorgangs sollte die Datei- und Ordnerstruktur wie rechts abgebildet aussehen.<br><br>
                                                Nachdem dies nun erledigt ist, wird der Assistent nun die zuvor gesicherten Dateien wieder an die richtige Stelle kopieren. Somit sollte die neue Installation sofort wieder einsatzbereit sein.
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <ul class="filelist">
                                                <li class="folder"><i class="fa fa-folder"></i> app</li>
                                                <li class="folder"><i class="fa fa-folder"></i> bin</li>
                                                <li class="folder"><i class="fa fa-folder"></i> src</li>
                                                <li class="folder"><i class="fa fa-folder"></i> vendor</li>
                                                <li class="folder"><i class="fa fa-folder"></i> web</li>
                                                <li class="file"><i class="fa fa-file-o"></i> .gitignore</li>
                                                <li class="file"><i class="fa fa-file-o"></i> .htaccess</li>
                                                <li class="file"><i class="fa fa-file-o"></i> CHANGELOG.md</li>
                                                <li class="file"><i class="fa fa-file-o"></i> composer.lock</li>
                                                <li class="file"><i class="fa fa-file-o"></i> composer.json</li>
                                                <li class="file"><i class="fa fa-file-o"></i> LICENCE</li>
                                                <li class="file"><i class="fa fa-file-o"></i> README.md</li>
                                                <li class="file"><i class="fa fa-file-o"></i> version.txt</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <p>
                                    <button type="button" class="button-next btn btn-primary btn-block">Ich bestätige ich den vorherigen Schritt ausgeführt bzw zur Kenntnis genommen zu haben</button>
                                </p>
                            </div>


                            <!--

                            SCHRITT 4

                            -->
                            <div class="tab-pane" id="tab4">

                                <h3>Wiederherstellnug</h3>

                                <p>
                                    Abschließend werden nun die zuvor gesicherten Dateien an die richtigen Stellen in der neuen Ordnerstruktur abgelegt. Wenn dieser Vorgang erfolgreich war, sollte das System sofort wieder einsatzbereit
                                    sein. Ist dies nicht der Fall, wenden Sie sich gern an <a href="mailto:support@contao-monitoring.de?subject=Problem beim Migrationsassistenten">support@contao-monitoring.de</a>.
                                </p>

                                <p>
                                    <button type="button" class="btn btn-primary" onclick="doRestore();" id="do_restore">Daten wiederherstellen</button>
                                </p>
                                <div class="message restore_message">
                                    <div class="panel panel-red">
                                        <div class="panel-heading">
                                            Fehler
                                        </div>
                                        <div class="panel-body">
                                            <p>...</p>
                                        </div>
                                    </div>
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            Erfolgreich
                                        </div>
                                        <div class="panel-body">
                                            <p>...</p>
                                        </div>
                                    </div>
                                    <button type="button" class="button-next btn btn-primary" id="restore_next" style="display:block;">Weiter</button>
                                </div>

                            </div>


                            <!--

                            SCHRITT 5

                            -->
                            <div class="tab-pane" id="tab5">

                                <h3>Fortune, passion, and power.</h3>

                                <p>
                                    Die Anwendung sollte nun wie gewohnt funktionieren. Zukünftig sind nun auch Updates via <strong>composer</strong> möglich.<br><br>Bei Problemen wenden Sie sich gern an <a
                                        href="mailto:support@contao-monitoring.de?subject=Problem beim Migrationsassistenten">support@contao-monitoring.de</a>
                                </p>
                            </div>
                            <div style="height:20px;">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
                                </div>
                            </div>
                            <ul class="pager wizard">
                                <li class="previous"><a href="#">Zurück</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
    <script>
        /*!
         * jQuery twitter bootstrap wizard plugin
         * Examples and documentation at: http://github.com/VinceG/twitter-bootstrap-wizard
         * version 1.0
         * Requires jQuery v1.3.2 or later
         * Supports Bootstrap 2.2.x, 2.3.x, 3.0
         * Dual licensed under the MIT and GPL licenses:
         * http://www.opensource.org/licenses/mit-license.php
         * http://www.gnu.org/licenses/gpl.html
         * Authors: Vadim Vincent Gabriel (http://vadimg.com), Jason Gill (www.gilluminate.com)
         */
        (function(e){var n=function(d,k){d=e(d);var a=this,g=[],c=e.extend({},e.fn.bootstrapWizard.defaults,k),f=null,b=null;this.rebindClick=function(h,a){h.unbind("click",a).bind("click",a)};this.fixNavigationButtons=function(){f.length||(b.find("a:first").tab("show"),f=b.find('li:has([data-toggle="tab"]):first'));e(c.previousSelector,d).toggleClass("disabled",a.firstIndex()>=a.currentIndex());e(c.nextSelector,d).toggleClass("disabled",a.currentIndex()>=a.navigationLength());e(c.backSelector,d).toggleClass("disabled",
            0==g.length);a.rebindClick(e(c.nextSelector,d),a.next);a.rebindClick(e(c.previousSelector,d),a.previous);a.rebindClick(e(c.lastSelector,d),a.last);a.rebindClick(e(c.firstSelector,d),a.first);a.rebindClick(e(c.backSelector,d),a.back);if(c.onTabShow&&"function"===typeof c.onTabShow&&!1===c.onTabShow(f,b,a.currentIndex()))return!1};this.next=function(h){if(d.hasClass("last")||c.onNext&&"function"===typeof c.onNext&&!1===c.onNext(f,b,a.nextIndex()))return!1;h=a.currentIndex();$index=a.nextIndex();$index>
        a.navigationLength()||(g.push(h),b.find('li:has([data-toggle="tab"]):eq('+$index+") a").tab("show"))};this.previous=function(h){if(d.hasClass("first")||c.onPrevious&&"function"===typeof c.onPrevious&&!1===c.onPrevious(f,b,a.previousIndex()))return!1;h=a.currentIndex();$index=a.previousIndex();0>$index||(g.push(h),b.find('li:has([data-toggle="tab"]):eq('+$index+") a").tab("show"))};this.first=function(h){if(c.onFirst&&"function"===typeof c.onFirst&&!1===c.onFirst(f,b,a.firstIndex())||d.hasClass("disabled"))return!1;
            g.push(a.currentIndex());b.find('li:has([data-toggle="tab"]):eq(0) a').tab("show")};this.last=function(h){if(c.onLast&&"function"===typeof c.onLast&&!1===c.onLast(f,b,a.lastIndex())||d.hasClass("disabled"))return!1;g.push(a.currentIndex());b.find('li:has([data-toggle="tab"]):eq('+a.navigationLength()+") a").tab("show")};this.back=function(){if(0==g.length)return null;var a=g.pop();if(c.onBack&&"function"===typeof c.onBack&&!1===c.onBack(f,b,a))return g.push(a),!1;d.find('li:has([data-toggle="tab"]):eq('+
            a+") a").tab("show")};this.currentIndex=function(){return b.find('li:has([data-toggle="tab"])').index(f)};this.firstIndex=function(){return 0};this.lastIndex=function(){return a.navigationLength()};this.getIndex=function(a){return b.find('li:has([data-toggle="tab"])').index(a)};this.nextIndex=function(){return b.find('li:has([data-toggle="tab"])').index(f)+1};this.previousIndex=function(){return b.find('li:has([data-toggle="tab"])').index(f)-1};this.navigationLength=function(){return b.find('li:has([data-toggle="tab"])').length-
            1};this.activeTab=function(){return f};this.nextTab=function(){return b.find('li:has([data-toggle="tab"]):eq('+(a.currentIndex()+1)+")").length?b.find('li:has([data-toggle="tab"]):eq('+(a.currentIndex()+1)+")"):null};this.previousTab=function(){return 0>=a.currentIndex()?null:b.find('li:has([data-toggle="tab"]):eq('+parseInt(a.currentIndex()-1)+")")};this.show=function(b){b=isNaN(b)?d.find('li:has([data-toggle="tab"]) a[href=#'+b+"]"):d.find('li:has([data-toggle="tab"]):eq('+b+") a");0<b.length&&
        (g.push(a.currentIndex()),b.tab("show"))};this.disable=function(a){b.find('li:has([data-toggle="tab"]):eq('+a+")").addClass("disabled")};this.enable=function(a){b.find('li:has([data-toggle="tab"]):eq('+a+")").removeClass("disabled")};this.hide=function(a){b.find('li:has([data-toggle="tab"]):eq('+a+")").hide()};this.display=function(a){b.find('li:has([data-toggle="tab"]):eq('+a+")").show()};this.remove=function(a){var c="undefined"!=typeof a[1]?a[1]:!1;a=b.find('li:has([data-toggle="tab"]):eq('+a[0]+
            ")");c&&(c=a.find("a").attr("href"),e(c).remove());a.remove()};var l=function(d){var g=b.find('li:has([data-toggle="tab"])');d=g.index(e(d.currentTarget).parent('li:has([data-toggle="tab"])'));g=e(g[d]);if(c.onTabClick&&"function"===typeof c.onTabClick&&!1===c.onTabClick(f,b,a.currentIndex(),d,g))return!1},m=function(d){$element=e(d.target).parent();d=b.find('li:has([data-toggle="tab"])').index($element);if($element.hasClass("disabled")||c.onTabChange&&"function"===typeof c.onTabChange&&!1===c.onTabChange(f,
                b,a.currentIndex(),d))return!1;f=$element;a.fixNavigationButtons()};this.resetWizard=function(){e('a[data-toggle="tab"]',b).off("click",l);e('a[data-toggle="tab"]',b).off("shown shown.bs.tab",m);b=d.find("ul:first",d);f=b.find('li:has([data-toggle="tab"]).active',d);e('a[data-toggle="tab"]',b).on("click",l);e('a[data-toggle="tab"]',b).on("shown shown.bs.tab",m);a.fixNavigationButtons()};b=d.find("ul:first",d);f=b.find('li:has([data-toggle="tab"]).active',d);b.hasClass(c.tabClass)||b.addClass(c.tabClass);
            if(c.onInit&&"function"===typeof c.onInit)c.onInit(f,b,0);if(c.onShow&&"function"===typeof c.onShow)c.onShow(f,b,a.nextIndex());e('a[data-toggle="tab"]',b).on("click",l);e('a[data-toggle="tab"]',b).on("shown shown.bs.tab",m)};e.fn.bootstrapWizard=function(d){if("string"==typeof d){var k=Array.prototype.slice.call(arguments,1);1===k.length&&k.toString();return this.data("bootstrapWizard")[d](k)}return this.each(function(a){a=e(this);if(!a.data("bootstrapWizard")){var g=new n(a,d);a.data("bootstrapWizard",
            g);g.fixNavigationButtons()}})};e.fn.bootstrapWizard.defaults={tabClass:"nav nav-pills",nextSelector:".wizard li.next",previousSelector:".wizard li.previous",firstSelector:".wizard li.first",lastSelector:".wizard li.last",backSelector:".wizard li.back",onShow:null,onInit:null,onNext:null,onPrevious:null,onLast:null,onFirst:null,onBack:null,onTabChange:null,onTabClick:null,onTabShow:null}})(jQuery);

    </script>
    <script>

        var doBackup = function(){
            $('.backup_message .panel').fadeOut('slow',function(){
                $.get( "migrate.php?backup=1", function( data ) {
                    if(data == "OK"){
                        $('#do_backup').fadeOut('slow',function(){
                            $('#backup_next').fadeIn('slow');
                            $('.backup_message .panel-success .panel-body p').html('Aktion erfolgreich');
                            $('.backup_message .panel-success').fadeIn();
                        });
                    }else{
                        $('.backup_message .panel-red .panel-body p').html(data);
                        $('.backup_message .panel-red').fadeIn();
                        setTimeout(function(){$('#backup_next').fadeIn('slow');},2000);
                    }
                });
            });
        };

        var doRestore = function(){
            $('.restore_message .panel').fadeOut('slow',function(){
                $.get( "migrate.php?restore=1", function( data ) {
                    if(data == "OK"){
                        $('#do_restore').fadeOut('slow',function(){
                            $('#restore_next').fadeIn('slow');
                            $('.restore_message .panel-success .panel-body p').html('Aktion erfolgreich');
                            $('.restore_message .panel-success').fadeIn();
                        });
                    }else{
                        $('.restore_message .panel-red .panel-body p').html(data);
                        $('.restore_message .panel-red').fadeIn();
                    }
                });
            });
        };

        $(document).ready(function () {
            $('#rootwizard').bootstrapWizard({
                'nextSelector': '.button-next',
                onTabClick: function (tab, navigation, index) {
                    return false;
                },
                onTabShow: function (tab, navigation, index) {
                    var lis = navigation.find('li');
                    var $total = lis.length;
                    var $current = index + 1;
                    var $percent = ($current / $total) * 100;
                    var $oProgressBar = $('#rootwizard').find('.progress-bar');
                    $oProgressBar.css({width: $percent + '%'});
                    if($percent == 100){
                        $oProgressBar.removeClass('progress-bar-striped active');
                        setTimeout(function(){$('#rootwizard').find('.progress').fadeOut('fast')},1000);
                    }else{
                        $oProgressBar.addClass('progress-bar-striped active');
                        if(!$('#rootwizard').find('.progress').is(':visible')) {
                            setTimeout(function () {
                                $('#rootwizard').find('.progress').fadeIn('fast')
                            }, 0);
                        }
                    }
                    $(lis).removeClass('done');
                    $(navigation).find("i").removeClass('glyphicon glyphicon-ok');
                    for (var i = 0; i < index; i++) {
                        $(lis[i]).addClass('done');
                        $(lis[i]).find('i').addClass('glyphicon glyphicon-ok');
                    }
                }
            });
        });
    </script>
</body>
</html>