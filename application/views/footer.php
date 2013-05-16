
    <div id="footer">
        <ul id="nav">

            <?php


            foreach($menu as $item =>$value){

                print '<li class="mainItem"><a href="/page/content/'.$value->permalink.'" class="bauhausfont">'.$value->menu_title.'</a>';
                if( $value->submenu AND !empty($value->submenu)){
                  print '<ul class="submenu">';
                    foreach($value->submenu as $subitem => $subValue){
                          print '<li class="submenu-item"><a href="/page/content/'. $subValue->permalink .'">'.$subValue->menu_title.'</a></li>';
                    }
                  print '</ul>';
                }
                print '</li>';

            }
            ?>
        </ul>
    </div>
<div class="clear">&nbsp;</div>
  </body>

</html>
