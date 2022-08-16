<?php
	/* Variables Global */
    function p($str){echo $str;}
	function echo_s($str){echo str_replace('\\', '', $str);}
	function pLang($a,$b){echo $GLOBALS[$a][$b];}
	function gLang($a,$b){return $GLOBALS[$a][$b];}
	function setName($a,$b){echo $GLOBALS[$a][$b];}
	function getName($a,$b){return $GLOBALS[$a][$b];}
	/* */	
    function formatDate(){
		$date=strtotime($objItem->date_create);
		$final_date=date("d/m/y g:i a", $date);
		return $final_date;
	}
	function removeHTTP($url){return str_replace(array('http://','https://'), '', $url);}
	function youtubeId($id) {$_id = parse_url($id);parse_str($_id['query']);unset($_id);$id = empty($v) ? $id : $v;return $id;}
	function vimeoId($id) {$_id = parse_url($id);return str_replace('/','',$_id['path']);}
	function truncate_string($string, $max_length){
		if (strlen($string) > $max_length) {
			 $string = substr($string,0,$max_length);
			 $string .= ' ';
		}
		return $string;
	} 	
	function getFechaFormat($fecha,$format='m.d.y - g:i a'){return date($format, strtotime($fecha));}	
	function arr2json($arr = array(), $seek) {
		if(!is_array($seek)){
			$seek = explode('|',$seek);
		}
		
		if (count($seek) == 0) {
			return json_encode($arr);
		} else {
			$out = array();
			foreach ($seek as $item) {
				if (array_key_exists($item, $arr)) $out[$item] = $arr[$item];
			}
			return  json_encode($out);  
		} 
	}	    
 	function getDurationOfVideo($path, $isYoutube = false) {
		if (!$isYoutube) {
			if(file_exists($path)){
				//echo $path;
				require_once(PRJ_ID3_PATH.'getid3.php');
				$getID3 = new getID3;
				$metaData = $getID3->analyze($path);
				return $metaData['playtime_seconds'];
			}
			
		} else {
			$json = json_decode(file_get_contents("http://gdata.youtube.com/feeds/api/videos/{$path}?v=2&alt=jsonc"));
			return $json ->data ->duration;
		}
	}
	function detect_mobile()
	{
		$_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
		$mobile_browser = '0';
		if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
			$mobile_browser++;
		if((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') !== false))
			$mobile_browser++;
		if(isset($_SERVER['HTTP_X_WAP_PROFILE']))
			$mobile_browser++;
		if(isset($_SERVER['HTTP_PROFILE']))
			$mobile_browser++;
		$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
		$mobile_agents = array(
							'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
							'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
							'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
							'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
							'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
							'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
							'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
							'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
							'wapr','webc','winw','winw','xda','xda-'
							);
	 
		if(in_array($mobile_ua, $mobile_agents))
			$mobile_browser++;
		if(strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)
			$mobile_browser++;
		// Pre-final check to reset everything if the user is on Windows
		if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)
			$mobile_browser=0;
		// But WP7 is also Windows, with a slightly different characteristic
		if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)
			$mobile_browser++;
		if($mobile_browser>0)
			return true;
		else
			return false;
	}
	function Send_Email_Notify($id=0,$msg='',$email,$Type=0) {
		# Check Config
		if (!MWM_EMAIL_ENABLED) {
			return true;
		}
		# Subject & Data
		switch ($Type) {
			case 1:  			
				$Subject = "";			
				$Body  =$msg;
				break;
			case 2: 
				$Subject = "";
				$Body  = $msg;
				break;
			case 3: 
			case 4: 
				break;
			case 5:
				break;
		}		
		# Message
		$Message  = $Body;
		$To = $email;
		SwiftMail($From, $To, $Subject, $Message);
	}
	function SwiftMail($From, $To, $Subject, $Messa) {
		require(MWM_EMAIL_DIR."swift_required.php");
		$transport = Swift_SmtpTransport::newInstance();	
		$mailer = Swift_Mailer::newInstance($transport);	
		$message = Swift_Message::newInstance($Subject)
		->setFrom(array(MWM_EMAIL_FROM => MWM_EMAIL_FROM_NAME))
		  ->setTo($To)
		  ->setBody($Messa,'text/html')
		  ;
		$numSent = $mailer->batchSend($message);	
	}
function urls_to_links($originalString) {
   return preg_replace("/\b(([\w-]+:\/\/?|(www[.]|\w+\.))([^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|\/))))/", '<a target="_blank" href="http://$3$4"><img src="img/png/linked-in.png" alt=""  /></a>', $originalString);
	}
/*	function json_encode ( $output,$flag=false ){
		$json = new Services_JSON;
		if($flag){
			return $json->encode($output);			
		}else{	
			return $json->encode($output);	
		}
	}	
	function json_decode ( $output ){		
		$json = new Services_JSON();
		//echo 'aaa : '. $output;
		return $json->decode($output);	
	}	
	*/
?>