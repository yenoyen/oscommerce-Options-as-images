<div class="col-sm-<?php echo $content_width; ?> cm-pi-options-images">
  <h4 class="h3"><?php echo MODULE_CONTENT_PI_OI_HEADING_TITLE; ?></h4>
  
  <?php echo $options_images_output; ?>
  
</div>
<style>
label > input{
  position: absolute; /* Remove input from document flow */
}
label > input + img{ /* IMAGE STYLES */
  cursor:pointer;
  border:2px solid transparent;
}
label > input:checked + img{ /* (RADIO CHECKED) IMAGE STYLES */
  border:2px solid #f00;
}
</style>