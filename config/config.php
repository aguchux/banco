<?php

define("appname","banco");
define('app_title','');
define('appid','2');
define("version","2.1.0");
define("debug",true);
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('DIR', __DIR__);
define("display_error",true);
define("language","en_US");
define("url",__DIR__);
define("baseurl",__DIR__);
define("apps_dir","./_apps/");
define("templates_dir","./templates/");
define("templates_default","404");
define("templates_default_route","/error/404/");
define("vendor_dir","./vendor/");
define("assets_dir","./templates/assets/");
define("admin_assets_dir","./templates/admin/assets/");
define("layouts_dir","./templates/layouts/");
define("template_file_extension","php");
define("store_dir","./_store/");
define("public_dir","./_public/");
define("plugins_dir","./templates/_plugins/");
define("server","remote");
define("use_token_security",true);
define("encrypt_salt","=32chars=salt=for=encryption=");
define("default_timezone","Africa/Lagos");
define("offset_timezone",true);
define("session_path","./_sessions/");

define("session_timout",20);
define("session_delete_timout",30);
define("auth_session_key","logged_in");

define("auth_url","/login");
define("domain", "https://online.citizensbcanada.com/");
define("enable_DKIM_keys",false);

define("site_use_key","d485e0c84b4c555d707f2815dc7c94fb593ccbf9");

define("db_host","localhost");
define("db_user","citizensban_gilkio");
define("db_password","OMb0n953eekee82pl8hiS");
define("db","citizensban_gilkio");

define("db_port",3306);
define("db_charset","utf8");
define("db_socket",null);

define("start_accid",6809800000);
define("transfer_redirect_time",10);
define("show_currency_market",true);

define("PHPMAILER_IS_HTML",false);

define("fromEmail","noReply@banco.com");
define("fromName","Banco Bank");
define("replyEmail","noReply@banco.com");
define("replyName","Banco Bank");
define("subject","Banco Bank");