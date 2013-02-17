<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="<?php echo site_url(); ?>css/layout-cms.css" rel="stylesheet" media="screen" type="text/css" />
    <link href="<?php echo site_url(); ?>js//supersized/core/css/supersized.core.css" rel="stylesheet" media="screen" type="text/css" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo site_url()?>js/supersized/core/js/supersized.3.1.3.core.min.js"></script>

    <script type="text/javascript">

      jQuery(function($){

              $.supersized({
                      slides: [ { image : "<?php echo site_url('images/')?>/background_home.jpg" } ]
              });
      });
    </script>

    <script type="text/javascript" src="<?php echo site_url('js'); ?>/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script>
    <script type="text/javascript">
      tinyMCE.init({
              mode: "specific_textareas",
              editor_selector : "mceEditor",
              theme : "advanced",
              plugins : "emotions,spellchecker,advhr,insertdatetime,preview",

              // Theme options - button# indicated the row# only
              theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,fontselect,fontsizeselect,formatselect",
              theme_advanced_buttons2 : "cut,copy,paste,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,|,code,preview,|,forecolor,backcolor",
              theme_advanced_buttons3 : "insertdate,inserttime,|,spellchecker,advhr,,removeformat,|,sub,sup,|,charmap",
              theme_advanced_toolbar_location : "top",
              theme_advanced_toolbar_align : "left",
              theme_advanced_statusbar_location : "bottom",
              theme_advanced_resizing : true
      });
    </script>

    <title>Secure Studios <?php echo ($browserTitle)? '| '.$browserTitle : ''; ?></title>
  </head>
  <body>
    <div id="wrapper">
      <div id="header">
        <div id="logo"><img src="<?php echo site_url('images'); ?>/logo.png" alt="logo"/></div>
      </div>
