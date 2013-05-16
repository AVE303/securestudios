<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="<?php echo $content[0]['meta_description']; ?>" />
    <meta name="keywords" content="<?php echo $content[0]['meta_keywords']; ?>" />
    <link href="<?php echo site_url(); ?>css/layout.css" rel="stylesheet" media="screen" type="text/css" />
<!--    <link href="<?php echo site_url(); ?>js//supersized/core/css/supersized.core.css" rel="stylesheet" media="screen" type="text/css" />-->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<!--    <script type="text/javascript" src="<?php echo site_url()?>js/supersized/core/js/supersized.3.1.3.core.min.js"></script>-->
 

    <title>Secure Studios</title>
<script type="text/javascript">

sfHover = function() {
	var sfEls = document.getElementById("nav").getElementsByTagName("LI");
	for (var i=0; i<sfEls.length; i++) {
		sfEls[i].onmouseover=function() {
			this.className+=" over";
		}
		sfEls[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" over\\b"), "");
		}
	}
}
if (window.attachEvent) window.attachEvent("onload", sfHover);

</script>
    <script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-19609801-5']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

  </script>
  </head>
  <body>

    <div id="wrapper" class="<?php echo $background;?>">
      <div id="header">
        <div id="logo"><img src="<?php echo site_url('images/logo.png'); ?>" alt="logo"/></div>
      </div>
    
    
