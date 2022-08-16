<?php
//date_default_timezone_set('America/Lima');
error_reporting(E_ALL ^ E_NOTICE);

define('LBN_FOLDER','/myCMS/');

define('TZN_DB_HOST','localhost');
define('TZN_DB_USER','root');       // edit here
define('TZN_DB_PASS','');           // edit here
define('TZN_DB_BASE','dbmycms');  // edit here

define('TZN_DB_PREFIX','lbn');
define('TZN_DB_DEBUG',2);
define('TZN_DB_PERMANENT',0);
define('TZN_DEBUG',0);
define('TZN_SPECIALCHARS',2);
define('TZN_TZDEFAULT','user');
define('TZN_DATEFIELD','USA');
define('TZN_TRANS_ID',0);
define('TZN_TRANS_STATUS',0);
define('TZN_DB_ERROR_PAGE','error.php');

define('TZN_DB_PAGING_OFF','');
define('TZN_DB_PAGING_ON','active');
define('TZN_DB_PAGING_ENABLED','active');
define('TZN_DB_PAGING_DISABLED','disabled');

define('TZN_USER_ID_LENGTH',8);		// length of room/user ID
define('TZN_USER_LOGIN','username');// Login mode = username OR email
define('TZN_USER_NAME_MIN',3);		// minimum length for username
define('TZN_USER_NAME_MAX',20);		// maximum length for username
define('TZN_USER_PASS_MIN',3);		// minimum length for password
define('TZN_USER_PASS_MAX',10);		// maximum length for password
define('TZN_USER_PASS_MODE',4);

define('LBN_LANGUAGE','es');
define('LBN_DOMAIN','http://www.visible.pe'.LBN_FOLDER);
define('LBN_ROOT','/2013/');
define('LBN_CHARSET','utf-8');
define('LBN_VERSION','4.0.2');
define('LBN_WEB','www.visible.pe');
define('LBN_WEB_COLOR','#f94000');
define('LBN_CONFIG_CHAT',true);
define('LBN_CONFIG_CHAT_KEY','LBN_CONFIG_CHAT_DISABLED');
define('LBN_CONFIG_SUPPORT',false);
define('LBN_CONFIG_HELP',false);
define('LBN_CONFIG_MULTIUSER',true);
define('LBN_CONFIG_QUICKSAND',0);
define('LBN_CORE_REMOTE','_include/plugins/');
define('LBN_MSG_TABLE','Loading data...');

define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('ROOT_ADMIN', 'control/');
if (@is_dir('./'.ROOT_ADMIN.'_include')){
	define('PRJ_ROOT_PATH','./'.ROOT_ADMIN);
}else if(@is_dir('./_include')){define('PRJ_ROOT_PATH','./');
}else if(@is_dir('../_include')){define('PRJ_ROOT_PATH','../');
}else if(@is_dir('../'.ROOT_ADMIN.'_include')){define('PRJ_ROOT_PATH','../'.ROOT_ADMIN);
}else{
	define('PRJ_ROOT_PATH','../../');
}

define('PRJ_INCLUDE_PATH',PRJ_ROOT_PATH.'_include/');
define('PRJ_PLUGINS_PATH',PRJ_INCLUDE_PATH.'plugins/');
define('PRJ_CLASS_PATH',PRJ_INCLUDE_PATH.'classes/');
define('PRJ_CORE_PATH',PRJ_INCLUDE_PATH.'core/');
define('PRJ_MAIL_PATH',PRJ_PLUGINS_PATH.'mail/');
define('PRJ_ID3_PATH',PRJ_PLUGINS_PATH.'id3/');
define('PRJ_CHAT_PATH',PRJ_PLUGINS_PATH.'chat/');
define('PRJ_MIN_PATH',PRJ_PLUGINS_PATH.'min/');
define('PRJ_CKEDITOR_PATH',PRJ_PLUGINS_PATH.'ckeditor/');
define('PRJ_CKFINDER_PATH',PRJ_PLUGINS_PATH.'ckfinder/');
define('PRJ_WWW_PATH',PRJ_ROOT_PATH);
define('THUMB',PRJ_INCLUDE_PATH.'thumb.php');

define('TZN_FILE_RANDOM',false);
define('TZN_FILE_GD_VERSION',2);
define('TZN_FILE_GD_QUALITY',85);
define('TZN_FILE_ICONS_PATH',PRJ_WWW_PATH.'icons/');
define('TZN_FILE_ICONS_URL','icons/');
define('TZN_FILE_TEMP_PATH',PRJ_WWW_PATH.'temp/');
define('TZN_FILE_TEMP_URL','temp/');
define('TZN_FILE_UPLOAD_PATH',PRJ_WWW_PATH.'upload/');
define('TZN_FILE_UPLOAD_URL','upload/');
define('TZN_FILE_UPLOAD_URL_ADMIN','../'.TZN_FILE_UPLOAD_URL);

/* BACK END */
define('ABSOLUTE_CKEDITOR_PATH','_include/plugins/ckeditor/');
define('ABSOLUTE_THUMB_UPLOAD_PATH',LBN_FOLDER.'upload');
define('ABSOLUTE_UPLOAD_PATH',LBN_FOLDER.'upload/');
define('BE_VIDEO_PATH',TZN_FILE_UPLOAD_PATH.'videos/');
define('BE_AUDIO_PATH',TZN_FILE_UPLOAD_PATH.'audios/');
define('BE_UP_PATH',TZN_FILE_UPLOAD_PATH);
define('BE_IMG_ROOT','_img/');
define('BE_IMG_PATH',BE_IMG_ROOT.'admin/');
define('BE_ICON_PATH',BE_IMG_ROOT.'icons/');
define('BE_ICON_GREY_PATH',BE_ICON_PATH.'grey/');
define('BE_ICON_WHITE_PATH',BE_ICON_PATH.'white/');
define('BE_AVATAR_PATH',BE_IMG_ROOT.'avatar/');
define('BE_JS_PATH',PRJ_ROOT_PATH.'_js/');
define('BE_CSS_PATH',PRJ_ROOT_PATH.'_css/');
define('BE_SWF_PATH',PRJ_ROOT_PATH.'_swf/');
define('BE_ICON_ADD',BE_ICON_GREY_PATH.'add.gif');
define('BE_ICON_EDIT','pencil');
define('BE_ICON_DELETE',BE_ICON_GREY_PATH.'Trashcan.png');
define('BE_ICON_PREVIEW',BE_ICON_GREY_PATH.'Preview.png');
define('BE_ICON_ITEMS',BE_ICON_GREY_PATH.'Coverflow.png');
define('BE_ICON_CONFIG',BE_ICON_GREY_PATH.'Cog.png');
define('BE_ICON_VIDEO',BE_ICON_GREY_PATH.'film_camera.png');
define('BE_ICON_IMAGE',BE_ICON_GREY_PATH.'Image.png');
define('BE_ICON_MESSAGE',BE_ICON_GREY_PATH.'speech_bubbles.png');

/* FRONT END */
define('FE_LAYOUT_URL',LBN_ROOT.'_layout/');
define('FE_VIDEO_URL',TZN_FILE_UPLOAD_URL.'video/');
define('FE_AUDIO_URL',TZN_FILE_UPLOAD_URL.'audio/');
define('FE_UP_URL',TZN_FILE_UPLOAD_URL);

// == EMAIL NOTIFICATION
define('LBN_EMAIL_DIR', PRJ_MAIL_PATH);
define('LBN_EMAIL_FROM', "info@visible.pe");
define('LBN_EMAIL_FROM_NAME', "");
define('LBN_EMAIL_TO', "");
define('LBN_EMAIL_BCC', false);
define('LBN_EMAIL_USER', true);
define('LBN_EMAIL_SWIFT', "smtp");  // smtp, sendmail or phpmail
define('LBN_EMAIL_SENDMAIL', "/usr/sbin/sendmail -bs");
define('LBN_EMAIL_SERVER', "");
define('LBN_EMAIL_SERVER_TIMEOUT', 30);
define('LBN_EMAIL_SERVER_AUTH',false);
define('LBN_EMAIL_SERVER_USER', "");
define('LBN_EMAIL_SERVER_PASS', "");
define('LBN_EMAIL_NO_RCP', true);  // false for silent
define('LBN_EMAIL_ENABLED', true);

// === DATE FORMATS ===========================================
define("TZN_DATE_SHT","%d %b %y");
define("TZN_DATE_SHX","%a %d %b %y");
define("TZN_DATE_LNG","%d %B %Y");
define("TZN_DATE_LNX","%d %B");
define("TZN_DATE_TG","%d %b %Y");
define("TZN_DATETIME_PER","%d/%m/%y %H:%M%p");
define("TZN_DATETIME_USA","%m/%d/%y %I:%M%p");
define("TZN_DATETIME_SHT","%d %b %y %H:%M");
define("TZN_DATETIME_SHX","%a %d %b %y %H:%M");
define("TZN_DATETIME_LNG","%d %B %Y, %H:%M");
define("TZN_DATETIME_LNX","%A %d %B %Y, %H:%M");


?>