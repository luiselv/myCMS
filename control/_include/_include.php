<?php 
//echo dirname(__FILE__);
//exit;
$File_Config = "_include/config.php";                                                              
if (@is_readable($File_Config)) {
    include $File_Config;
} else if (@is_readable('../'.$File_Config)) {
    include '../'.$File_Config;	
} else if (@is_readable('../../'.$File_Config)) {
    include '../../'.$File_Config;	
} else if (@is_readable('../../../'.$File_Config)) {
    include '../../../'.$File_Config;		
} else if (@is_readable(dirname(__FILE__).'/config.php')){
    include dirname(__FILE__).'/config.php';	
}else {
    header('Location: error.php?tznMessage='
        .urlencode('Could not find or access config.php file. Please edit _include.php file.'));
    exit;
}
?>