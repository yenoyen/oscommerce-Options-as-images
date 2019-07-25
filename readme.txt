Install Instructions for Options as Images BS v2.2
===================================================

version 2.2
This is a working version for osC CE Frozen version, and will only work on the community bootstrap versions of oscommerce..

The operational module and framework was made by andes1 and the compilation of working fixes used 
here were made by rusNN, some of this working fixes were made for a lot o people among them lildog.

This version has been simlified. I have removed the option to vary the number of images per row as bootstrap works on a grid bases and it controls how many images show per row based on the screen sixe of the device used.

I have also removed the option to have a larger pop up image of the option as I never used it, and cannot see a benefit in keeping it.

=====================================================



How to Install
===============
1. Copy all the new files into their respective folders. You should have the following files to copy:

  /catalog/admin/options_images.php
  /catalog/admin/includes/boxes/catalog_oi_content.php
  /catalog/admin/includes/languages/english/options_images.php
  /catalog/admin/includes/languages/english/modules/boxes/catalog_oi_content.php
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

-------------------------------------------------------------------------
Support Thread: http://forums.oscommerce.com/index.php?showtopic=317064
-------------------------------------------------------------------------