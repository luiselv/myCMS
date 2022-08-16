LBN_FORM.success = function(data,modal,type){
	try{
		if(!modal){		
			switch (data.type){
				case 'ajax':				
					LBN_TABLE.table.fnStandingRedraw();
				break;
				default:
				break;
			}				
			LBN_FORM.complete(data,'Updated!!'); 
		}else{
		}		
	}
	catch(e){}	
}
LBN_FILE.success = function(data){
	data = jQuery.parseJSON(data);
	try{
	switch (data.type){
		case 'person':
			$('#img_'+data.id+' img').attr('src','thumb.php?av=64&src='+data.name);
			$('.account-group img').attr('src','thumb.php?av=32&src='+data.name);
			$('#credentials img').attr('src','thumb.php?av=50&src='+data.name);	
		break;
		case 'photo':
			var preview = $('#bpreview-'+data.id);
			preview.attr('data-src',data.name);
			$('#img-'+data.id).css('background-image','url(thumb.php?src='+data.name+')').fadeTo('slow', 1);
		break;		
		default:
			$('#img_'+data.id+' img').attr('src','thumb.php?w=120&src='+data.name);
		break;
	}		

	}
	catch(e){}	
}
LBN_NAV.customUpdateStatus = function(btn,mode){
	switch (mode){
			case 'isfree':
				LBN_NAV.updateStatus(btn,{field:mode,multi:false});
			break;
			default:
			    return false;
			break;
	}	
}
