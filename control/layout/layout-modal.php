   <!-- help -->
  <div class="modal hide fade" id="modal-help">
    <div class="modal-header">
    	<a class="close" data-dismiss="modal">×</a>
        <h3><?php pLang('langCommon','help_modal_title') ?></h3>
    </div>
    <div class="modal-body">
        <form >
          <fieldset>
              <div class="clearfix">
              <label for="textarea"><?php pLang('langCommon','help_modal_textarea') ?></label>
              <div class="input">
                <textarea rows="4" name="textarea2" id="textarea2" style="width:520px;" ></textarea>
                <span class="help-block"><?php pLang('langCommon','help_modal_help') ?></span>
              </div>
            </div>
          </fieldset>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal" ><?php pLang('langForm','cancel') ?></a>
    	<a href="#" class="btn btn-primary"><?php pLang('langForm','send') ?></a>
    </div>
    </div>
   <!-- layout --> 
	<div class="modal hide fade" id="modal-layout">
    <div class="modal-header">
	    <a class="close" data-dismiss="modal">×</a>
        <h3>Select your layout</h3>
    </div>
    <div class="modal-body" id="layout-option" >
    	<a href="layout/layout-change.php?action=1&value=sidebar" class="sidebar <?php p(($layoutMode=='sidebar')?'active':''); ?>" ></a>
        <a href="layout/layout-change.php?action=1&value=center" class="center <?php p(($layoutMode=='center')?'active':''); ?>" ></a>
        <a href="layout/layout-change.php?action=1&value=full" class="full <?php p(($layoutMode=='full')?'active':''); ?>" ></a>
    </div>
    </div>    
