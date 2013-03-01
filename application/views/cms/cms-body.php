
  <div id="content">
    <h1 class="h1">Content Management Systeem</h1>
    <?php 
    if(isset($message)){
    echo $message;
    }
    if($this->session->flashdata('message_login')){ 
      echo '<div class="message">' . $this->session->flashdata('message_login') . '</div>';
    }
    ?>
    <table width="100%" class="list" cellpadding="1" cellspacing="0">
      <thead style="padding: 2px;">
        <tr>
          <td width="45%">Title</td>
          <td width="35%" align="left">Status</td>
          <td width="30%" align="center">Action</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <?php
        if ($pages) {
          foreach ($pages as $page => $value) {
            ($value->page_status == 1) ? $status = 'Actief' : $status = 'inactief';
            echo '<tr>' . PHP_EOL;
            echo '<td><a href="' . site_url('cms/update/' . $value->id) . '">' . $value->menu_title . '</a></td>' . PHP_EOL;
            echo '<td align="left">'. $status .'</td>' . PHP_EOL;
            echo '<td align="center"><a href="' . site_url('cms/update/' . $value->id) . '"><img src="' . site_url('assets/icons/documents_pencil.png') . '" alt="edit" /></a>
            <a href="' . site_url('cms/delete/' . $value->id) . '"><img src="' . site_url('assets/icons/cross_circle.png') . '" alt="delete" /></a></td>' . PHP_EOL;
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
        echo '<tr><td>&nbsp;</td></tr>'.PHP_EOL;
        echo '<tr>'.PHP_EOL;
        echo '<td>'.PHP_EOL;
        echo '<h2>Sub pagina\'s'.PHP_EOL;
        echo '</td>'.PHP_EOL;
        echo '</tr>'.PHP_EOL;
        if($project_pages) {
          foreach($project_pages as $projects => $proj_value) {
            echo '<tr>' . PHP_EOL;
            echo '<td><a href="' . site_url('cms/update/' . $proj_value->id) . '">' . $proj_value->menu_title . '</a></td>' . PHP_EOL;
            echo '<td align="left">'. $status .'</td>' . PHP_EOL;
            echo '<td align="center"><a href="' . site_url('cms/update/' . $proj_value->id) . '"><img src="' . site_url('assets/icons/documents_pencil.png') . '" alt="edit" /></a>
            <a href="' . site_url('cms/delete/' . $proj_value->id) . '"><img src="' . site_url('assets/icons/cross_circle.png') . '" alt="delete" /></a></td>' . PHP_EOL;
            echo '</tr>' . PHP_EOL;
          }
        } else {
          echo '<tr>'.PHP_EOL;
          echo '<td colspan="3">'.PHP_EOL;
          echo '<em>Er zijn op dit moment nog geen project pagina\'s aanwezig in het systeem.</em>';
          echo '</td>'.PHP_EOL;
          echo '</tr>'.PHP_EOL;
        }
        ?>

      </tbody>
    </table>
    
  </div>
 
