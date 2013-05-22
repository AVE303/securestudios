<div id="content">
  <h1><?php echo $title; ?></h1>
<?php
echo $message;
echo $error;
echo validation_errors();
echo form_open_multipart($action, array('class' => 'edit-form'));
?>
  <table width="100%">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><?php

        echo form_hidden($page_name[0]->menu_title);

      ?></td>
    </tr>

<!--    <tr>
      <td>
        <?php// echo form_label('Tekst bij dit project', 'filmtext', array('class' => 'bold')); ?>
      </td>
    </tr>
    <tr>
      <td>
        <?php
//        $data = array(
//              'name'        => 'filmtext',
//              'id'          => 'filmtext',
//              'value'       => $filmtext,
//              'rows'        => '20',
//              'cols'        => '20',
//            );
//        echo form_textarea($data, 'filmtext', 'class="mceEditor"'); ?>
      </td>
    </tr>-->
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>
        <?php echo form_label('Youtube link gedeelte', 'link', array('class' => 'bold')); ?>
      </td>
    </tr>
    <tr>
      <td>
      <?php 
      echo form_hidden('id',$id);
//      echo form_hidden('page_id', $page_id);
      $filmLinkInput = array('name' => 'link', 'id' => 'link', 'value' => $link);
      echo form_input($filmLinkInput);
      ?>
      </td>
    </tr>
    <tr>
      <td>
        <?php echo form_label('Project pagina', 'project_page'); ?>
      </td>
    </tr>
    <tr>
      <td>
        <?php
          $options = array();
          $options[0] = '-- Selecteer een pagina --';
          if($pages == TRUE){
            foreach($pages as $page => $value){

              $options[$value->id] = $value->menu_title;
            }
          }
          
          echo form_dropdown('page_id', $options, $active_page);
        ?>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input type="submit" value="save"/></td>
    </tr>
  </table>
<?php
echo form_fieldset_close() . PHP_EOL;
echo form_close() . PHP_EOL;
echo $link_back . PHP_EOL;
?>