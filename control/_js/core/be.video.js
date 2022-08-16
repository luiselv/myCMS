var LBN_VIDEO = {};
function loadVideo(root,img){
 jwplayer('mediaplayer').setup({
	'flashplayer': '_swf/player.swf',
	'id': 'playerID',
	'width': '460',
	'height': '313',
	'allowfullscreen':'true',
	'allowscriptaccess':'always',	
	'controlbar': 'bottom',
    'file': LBN_VIDEO_PATH + root,
    'image': 'thumb.php?src=../upload/'+img+'&w=460&h=270&full=1',
	'skin': '_swf/pmPlayer.zip'
 });
}
LBN_VIDEO.makeSlide = function(obj){
	var ID = $('#cuepoints').data('id');
	var data = 'json=1&field=slides&table='+LBN_TABLE.tableName+'&id='+ ID;				
	var jqxhr = $.getJSON(LBN_DI,data);
    jqxhr.success(function(data){
		$('#cuepoints').html('').html(data.html);
		$("input[type=radio]:last").focus();
	});
	return false;			
}
LBN_VIDEO.slideSelect = function(obj){
	var OBJ = $(obj);
	var ID = OBJ.data("id");
	var POSITION = OBJ.data("position");
	var data = 'table='+LBN_TABLE.tableName+'&type=cuepoint&id='+ ID + '&p=' + POSITION;				
	var jqxhr = $.getJSON(LBN_DF,data);
    jqxhr.success(function(data){
		$('#mediaplayer_wrapper').hide();
		$('#form-cuepoint').html(data.html).fadeIn();
		LBN_VIDEO.setRadio(obj);
	});	
	return false;
}
LBN_VIDEO.setRadio =function(obj){
	$('#cue-points li').find('span.active').removeClass('active');
	$(obj).parent().addClass('active');
}
LBN_VIDEO.setPoint = function (obj){
	var OBJ = $(obj);
	var ID = OBJ.data("id");
	var POSITION = OBJ.data("position");
	var TARGET = OBJ.data("target");		
	var time = jwplayer().getPosition();
	var data = 'json=1&field=time&table='+LBN_TABLE.tableName+'&id='+ ID + '&p=' + POSITION + '&time='+time;
	var jqxhr = $.getJSON(LBN_DU,data);
    jqxhr.success(function(data){
		var d=new Date(time*1000);
		var minuto = (d.getMinutes()<9)?"0"+d.getMinutes():d.getMinutes();
		var segundo = (d.getSeconds()<9)?"0"+d.getSeconds():d.getSeconds();		
		valor=minuto+":"+segundo;
		$('#'+TARGET).html(valor);
	});						
	return false;	
}
LBN_VIDEO.slideUpdate = function(obj){
	var OBJ = $(obj);
	var ID = OBJ.data("id");
	var POSITION = OBJ.data("position");
	var data = 'json=1&field=slides&table='+LBN_TABLE.tableName+'&id='+ ID + '&p=' + POSITION + '&' + $('#form-cuepoint').serialize();				
	var jqxhr = $.getJSON(LBN_DU,data);
    jqxhr.success(function(data){
		$('#cue-title-'+POSITION).val($('#cuetitle').val());
		LBN_VIDEO.slideClose(POSITION);
		LBN_UTIL.openMessage('Updated!!.',LBN_SUCCESS);	
	});	
	return false;
};
LBN_VIDEO.slideClose = function(p){
	$('#cue-li-'+p).find('.add-on').removeClass('active').find('input').attr('checked',false);	
	$('#form-cuepoint').fadeOut().html('');
	$('#mediaplayer_wrapper').show();	
}
LBN_VIDEO.slideDelete = function(obj){
	var OBJ = $(obj);
	var ID = OBJ.data("id");
	var POSITION = OBJ.data("position");
	var data = 'json=1&field=slides&table='+ LBN_TABLE.tableName + '&id='+ ID + '&p=' + POSITION;	
	var msg = "Delete this <b>Slide</b>.";
	$.msgbox(msg,{type: "confirm"}, 
		function(result) { 	
			if(result){	
				var jqxhr = $.getJSON(LBN_DD,data);
				jqxhr.success(function(data){
					$('#cue-li-'+POSITION).remove();					
				});
			}
		});									
		return false;
};
		
