<div id="footer">
    <ul>
      <?php
        if($this->session->userdata('is_logged_in')):
      ?>
      <li><a href="/cms">Pagina overzicht</a></li>
      <li><a href="/cms/add">Pagina toevoegen</a></li>
      <li><a href="/cms/projects">Project overzicht</a></li>
      <li><a href="/cms/addproject">Project toevoegen</a></li>
      <li><a href="/films/addmainpagefilm">Film toevoegen op hoofdpagina</a></li>
      <li><a href="/login/logout">Uitloggen</a></li>
      <?php endif;?>
    </ul>
  </div>
</div> <!-- End of wrapper div -->
</body>

</html>
