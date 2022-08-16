var LBN_CORE_REMOTE = '_include/plugins/';
var LBN_CORE_LOCAL = '_js/';
function _init(){
	yepnope({
		load: [LBN_CORE_LOCAL+'core/be.lang.js',LBN_CORE_REMOTE+'min/js.php?g=js',LBN_CORE_LOCAL+'core/be.custom.js'],
		callback: function (url, result,key) {
			if(key==2){
				$(document).ready(function(){
					__init();
				});
			}
		}
	});
}
function __init(){	
	if(typeof window.pageInit == 'function') {
		pageInit(); 
		$('.page-header-sub').unmask();
	}	
	init();
	if(typeof window.tabInit == 'function') {
		$('.tabs').tabs();
		tabInit(); 
	}
}
_init();