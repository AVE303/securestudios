
  <div id="content">
    <?php 
    if(isset($message)){
    echo $message;
    }
    ?>
    <table width="100%" class="list" cellpadding="1" cellspacing="0">
      <thead>
        <tr>
          <td width="25%">Project pagina titel</td>
          <td width="45%" align="left">Youtube link</td>
          <td width="30%" align="center">Actie</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <?php
        if ($pages) {
          foreach ($pages as $page => $value) {
            if(!empty($value->link)) {
              $youtube = '<a href="http://www.youtube.com/watch?v='.$value->link.'" target="_blank">http://www.youtube.com/watch?v='.$value->link.'</a>';
            } else {
              $youtube = 'Voeg link toe';
            }
            echo '<tr>' . PHP_EOL;
            echo '<td><a href="' . site_url('cms/update_project/' . $value->id) . '">' . $value->name . '</a></td>' . PHP_EOL;
            echo '<td align="left">'. $youtube .'</td>' . PHP_EOL;
            echo '<td align="center"><a href="' . site_url('cms/update_project/' . $value->id) . '"><img src="' . site_url('assets/icons/documents_pencil.png') . '" alt="edit" /></a>
            <a href="' . site_url('cms/delete_project/' . $value->id) . '" onclick="alert("Weet je het zeker?")"><img src="' . site_url('assets/icons/cross_circle.png') . '" alt="delete" /></a></td>' . PHP_EOL;
            echo '</tr>' . PHP_EOL;
          }
          echo '<tr>';
          echo '<td>' . $this->pagination->create_links() . '</td>';
          echo '</tr>';
        } else {
          echo '<tr>' . PHP_EOL;
          echo '<td><em>'. $no_result .'</em></td>' . PHP_EOL;
          echo '</tr>' . PHP_EOL;
        }
        ?>
      </tbody>
    </table>
    
  </div>
  