Install Instructions for Options as Images BS v2.2
===================================================

version 2.2
This is a working version for osC CE Frozen version, and will only work on the community bootstrap versions of oscommerce..

The operational module and framework was made by andes1 and the compilation of working fixes used 
here were made by rusNN, some of this working fixes were made for a lot o people among them lildog.

This version has been simlified. I have removed the option to vary the number of images per row as bootstrap works on a grid bases and it controls how many images show per row based on the screen sixe of the device used.

I have also removed the option to have a larger pop up image of the option as I never used it, and cannot see a benefit in keeping it.

=====================================================



How to Install v2.2.1
===============
1. Copy all the new files into their respective folders. You should have the following files to copy:

  /catalog/admin/options_images.php
  /catalog/admin/includes/languages/english/options_images.php
  /catalog/admin/includes/languages/english/modules/boxes/options_images.php
  /catalog/includes/languages/english/modules/boxes/bm_options_images.php
  /catalog/includes/languages/english/modules/content/product_info/cm_pi_options_images.php
  /catalog/includes/modules/content/product_info/cm_pi_options_images.php
  /catalog/includes/modules/content/product_info/templates/tpl_cm_pi_options_images.php
  
2. Create a new folder within the images folder and name it options. Be sure that the folder /catalog/images/options has the permissions set to 777.

------------------------------------------------------------------------------

How to use this app
====================

First of all, you should find that you have a new entry under the Configuration Menu in admin
called "Options as Images". Use this to configure the contrib for your desired behaviour. Please leave the images size set to 100 x 100 otherwise the page layout may change.

Next, you should find a new option under the Categories menu also called "Options as Images".
Use this to select an option category - you should then see a list of the options available in 
that category. Now click the option you wish to add an image to and click the "Edit" button that 
appears. A dialogue now appears with which you can select and image from your hard drive for uploading.

When you use "Options as Images" you should disable "Options & Attributes" in admin: Modules/Content/Options & Attributes (product_info section).

-------------------------------------------------------------------------
Support Thread: http://forums.oscommerce.com/index.php?showtopic=317064
-------------------------------------------------------------------------


Copy CSS to the end of your catalog/user.css file:
--------------------------------------------------


/* Options as images BOF */

/* Remove input from document flow */
label > input{
  position: absolute;
}

/* IMAGE STYLES */
label > input + img {
  cursor: pointer;
  border: 2px solid transparent;
}
label > input + img:hover {
  -webkit-box-shadow: 1px 1px 5px 3px rgba(0,0,0,0.75);
  -moz-box-shadow: 1px 1px 5px 3px rgba(0,0,0,0.75);
  box-shadow: 1px 1px 5px 3px rgba(0,0,0,0.75);
  border: none;
}

/* (RADIO CHECKED) IMAGE STYLES */
label > input:checked + img {
  border: 2px solid #00d502;
}

/* ZOOM */
.cm-pi-options-images label:not(.control-label) {
  padding: 0px;
  transition: transform .33s;
  margin: 0 auto;
  max-width: 50vw;
}
.cm-pi-options-images label:not(.control-label):hover {
  z-index: 9;
  transform: scale(2.5);
  max-width: 100%;
  /* (Note: if the zoom is too large, it will go outside of the viewport) */
  /* Maximum zoom scale should by 2.5 to be able to click the next thumbnail */
  }
 
/* Options as images block */  
.cm-pi-options-images {
  margin-top: 0rem;
  margin-bottom: 5rem;
      
  }
/* Options as images caption */  
.cm-pi-options-images h4,  
.cm-pi-options-images h4.h3 {
  font-size: 110%;
  }  
/* Options labels */
.cm-pi-options-images .control-label {
  margin-top: 1rem;      
  }
/* Options as images EOF */


ToDo
****
1. IMPORTANT : function remove() - have to backup affected data before deleting them and avoid a conflict with dependency of other addons using same db columns
2. Full width thumbnails without zoom for mobile devices
3. Bootstrap 4 form class="was-validated" to mark labels (products_options_name) of empty options which are required. May need to change the file catalog/product_info.php - add class to the form on line 46 (BS Frozen) 
3. Sorting Options, remove temporary "$byField" solution
