<?php
if(!empty($filmdata)){
//  var_dump($filmdata); die;
  echo '<div id="film-box">'.PHP_EOL;
  echo '<object width="400" height="304" >
                <param name="movie" value="http://www.youtube.com/v/'.$filmdata[0]->link.'?fs=1&rel=0"></param>
                <param name="allowFullScreen" value="true"></param>
                <param name="allowScriptAccess" value="always"></param>
                <embed src="http://www.youtube.com/v/'.$filmdata[0]->link.'?fs=1&rel=0"
                  type="application/x-shockwave-flash"
                  allowfullscreen="true"
                  allowscriptaccess="always"
                  width="400" height="304">
                </embed>
                </object>';
  echo '</div>'.PHP_EOL;
}
?>

<div id="content">
  <h1><?php echo $content[0]['content_title'];?></h1>
  <?php echo $content[0]['content']; ?>
  <?php 
  if($this->uri->segment(3) == 'contact'){
    echo 'E-mail: '.safe_mailto('meerinfo@securestudios.nl', 'meerinfo@securestudios.nl', array('class' => 'emaillink'));
  }
  ?>
</div>
<div class="clear">&nbsp;</div>