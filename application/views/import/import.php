<div class="container_list" >
<form id="uploadForm" action="<?php echo base_url('job/import/csv_parents');?>" method="post">
    <div>
        <label>Upload Image File:</label>
        <input name="user_file" id="user_file" type="file" class="demoInputBox" />
    </div>
    <div id="progress-div"><div id="progress-bar"></div></div>
    <div id="targetLayer"></div>
</form>
<div id="loader-icon" style="display:none;"><img src="<?php image_url('index.pulsing-squares-loader.gif'); ?>" /></div>
</div>