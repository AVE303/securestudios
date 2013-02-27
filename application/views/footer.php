
    <div id="footer">
        <ul id="nav">
<!--          <li class="mainItem"><a href="/" class="bauhausfont">Home</a></li>-->
<!--          <li class="mainItem"><a href="--><?php //echo site_url('page/content/producten');?><!--"><img src="--><?php //echo site_url('images/button-producten.png');?><!--" /></a>-->
<!--          --><?php
//          if(!empty($productmenu)){
//
//              echo '<ul class="submenu">'.PHP_EOL;
//              foreach($productmenu as $item => $subValue){
//                  echo '<li class="submenu-item"><a href="/page/content/producten/'.$subValue['permalink'].'">'. $subValue['menu_title'] .'</a></li>';
//              }
//
//              echo '</ul>'.PHP_EOL;
//            }
//          ?>
<!--          </li>-->
<!--          <li class="mainItem"><a href="--><?php //echo site_url('page/content/projecten');?><!--"><img src="--><?php //echo site_url('images/button-projecten.png');?><!--" /></a>-->
<!--            --><?php
//            //$projectmenu
//            if(!empty($projectmenu)){
//
//              echo '<ul class="submenu">'.PHP_EOL;
//              foreach($projectmenu as $item => $subValue){
//                  echo '<li class="submenu-item"><a href="/page/content/projecten/'.$subValue['permalink'].'">'. $subValue['menu_title'] .'</a></li>';
//              }
//
//              echo '</ul>'.PHP_EOL;
//            }
//            ?>
<!--          </li>-->
<!--          <li class="mainItem"><a href="--><?php //echo site_url('page/content/contact');?><!--"><img src="--><?php //echo site_url('images/button-contact.png');?><!--" /></a></li>-->
            <?php


            foreach($menu as $item =>$value){
              if(is_object($value)){

                print '<li class="mainItem"><a href="/page/content/'.$value->permalink.'" class="bauhausfont">'.$value->menu_title.'</a>';
                if( array_key_exists($value->permalink,$submenu) AND $submenu[$value->permalink] != false){
                  print '<ul class="submenu">';
                  foreach($submenu as $subitem => $subValue){

                    if($submenu[$subitem]){
                      foreach($subValue as $subObj => $obj){

                        print '<li class="submenu-item"><a href="/page/content/'. $obj->permalink .'">'.$obj->menu_title.'</a></li>';
                      }
                    }
                  }
                  print '</ul>';
                }
                print '</li>';
              }

            }
            ?>
        </ul>
    </div>
<div class="clear">&nbsp;</div>
  </body>

</html>
