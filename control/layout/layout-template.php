<script id="boxTemplate" type="text/x-jquery-tmpl">
	<li id="item_${_ID_}" class="item box-mask ${_TYPE_} ${_NEW_}" data-id="${_ID_}" >
		{{tmpl "#itemboxTemplate"}}
	</li>
</script> 
<script id="itemboxTemplate" type="text/x-jquery-tmpl">
		<div id="box-${_ID_}" class="grid-box" >
			<div class="btn-toolbar tool-header" >
				<div class="btn-group group-title" >
					<input class="checks" id="file-${_ID_}" name="files[]" onclick="LBN_NAV.selectOne(this)" value="${_ID_}" type="checkbox" />{{html _TITLE_}}
				</div>
				<div class="holder-edit" ><div class="btn-group group-edit" >{{html _EDIT_}}</div></div>
			</div>
			<div id="img-${_ID_}" class="div-info" {{html _IMG_}} >
			{{if _P_}}
				<div class="info" ><blockquote>${_P_}</blockquote></div>
			{{/if}}
			 </div>					
			<div class="btn-toolbar tool-footer" >
				<div class="btn-group group-status" >{{html _STATUS_}} </div>
				<div class="btn-group group-actions" >
					{{if _TYPE_}}
					<a href="javascript:void(0)" onclick="$('#bpreview-${_ID_}').click();" rel="tooltip" title="Preview : ${_TYPE_NAME_}" class="btn btn-mini "><i class="icon-${_TYPE_}"></i></a>
					{{/if}}
					<a href="#" data-toggle="dropdown" class="btn btn-mini dropdown-toggle">Action <span class="caret"></span></a>
					<ul class="dropdown-menu">{{html _ACTIONS_}}</ul>
				</div>					
			</div>				      
			<div class="arrow" ></div>
		</div>
		<div class="group-upload" >				
		</div>  
</script> 
<script id="photoholderTemplate" type="text/x-jquery-tmpl">
	<li id="item_${_ID_}" class="item box-mask ${_TYPE_} ${_NEW_}" data-id="${_ID_}" >
		{{tmpl "#photoTemplate"}}
	</li>
</script>
<script id="photoTemplate" type="text/x-jquery-tmpl">
		<div id="box-${_ID_}" class="grid-box" {{html _IMG_}} >
			<div class="btn-toolbar tool-header" >
				<div class="btn-group group-title" >
					<input class="checks" id="file-${_ID_}" name="files[]" onclick="LBN_NAV.selectOne(this)" value="${_ID_}" type="checkbox" />
				</div>
				<div class="holder-edit" ><div class="btn-group group-edit" >{{html _EDIT_}}</div></div>
			</div>
			<div class="div-info"  ></div>					
			<div class="btn-toolbar tool-footer" >
				<div class="btn-group group-status" >{{html _STATUS_}}</div>
				<div class="btn-group group-actions" >
					{{if _TYPE_}}
					<a href="javascript:void(0)" onclick="$('#bpreview-${_ID_}').click();" rel="tooltip" title="Preview : ${_TYPE_NAME_}" class="btn btn-mini"><i class="icon-${_TYPE_}"></i></a>
					{{/if}}
					<a href="#" data-toggle="dropdown" class="btn btn-mini dropdown-toggle">Action <span class="caret"></span></a>
					<ul class="dropdown-menu">{{html _ACTIONS_}}</ul>
				</div>					
			</div>				      
			<div class="arrow" ></div>
		</div>
		<div class="group-upload" >				
		</div>  
</script> 
<script id="textholderTemplate" type="text/x-jquery-tmpl">
	<li id="item_${_ID_}" class="item box-mask ${_TYPE_} ${_NEW_}" data-id="${_ID_}" >
		{{tmpl "#textTemplate"}}
	</li>
</script> 
<script id="textTemplate" type="text/x-jquery-tmpl">
		<div id="box-${_ID_}" class="grid-box" >
			<div class="btn-toolbar tool-header" >
				<div class="btn-group group-title" >
					<input class="checks" id="file-${_ID_}" name="files[]" onclick="LBN_NAV.selectOne(this)" value="${_ID_}" type="checkbox" />{{html _TITLE_}}
				</div>
				<div class="holder-edit" ><div class="btn-group group-edit" >{{html _EDIT_}}</div></div>
			</div>
			<div id="img-${_ID_}" class="div-info" >
				<div class="info" ><blockquote>${_P_}</blockquote></div>
		    </div>					
			<div class="btn-toolbar tool-footer" >
				<div class="btn-group group-status" >{{html _STATUS_}}</div>
				<div class="btn-group group-actions" >					
					<a href="#" data-toggle="dropdown" class="btn btn-mini dropdown-toggle">Action <span class="caret"></span></a>
					<ul class="dropdown-menu">{{html _ACTIONS_}}</ul>
				</div>					
			</div>				      
			<div class="arrow" ></div>
		</div>
		<div class="group-upload" >				
		</div>  
</script>
<script id="uploadTemplate" type="text/x-jquery-tmpl">
   <div id="container_upload_${_ID_}">
		<div id="filelist_${_ID_}" class="upload_files" ></div>
		<br />
		<a id="pickfiles_${_ID_}" href="javascript:;" class="btn btn-mini btn-primary" ><i class="icon-search icon-white" ></i> Select file</a> 
		<a class="close" data-id="${_ID_}" href="javascript:;" onclick="LBN_FILE.close(this)" >&times;</a>
   </div>		
</script> 