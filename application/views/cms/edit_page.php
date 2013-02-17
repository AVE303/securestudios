<?php
?>

<div id="content">
<div id="inner-content">
    <br />
    <h2><?php echo $pageTitle;?></h2>
    <?php
    echo validation_errors();
    echo form_open($action, array('class' => 'edit-form')).PHP_EOL;
    echo '<table width="100%">'.PHP_EOL;

    echo '<tr>'.PHP_EOL;
    echo '<td colspan="2">&nbsp;</td>'.PHP_EOL;
    echo '</tr>'.PHP_EOL;
    echo '<tr>'.PHP_EOL;
    echo '<td colspan="2">'. form_hidden('id', $id) .'</td>'.PHP_EOL;
    echo '</tr>'.PHP_EOL;

    echo '<tr>'.PHP_EOL;
    echo '<td>'.PHP_EOL;
    echo form_label('Page status', 'page_status').PHP_EOL;
    echo '</td>'.PHP_EOL;
    echo '<td>'.PHP_EOL;
    $options = array('1' => 'Actief', '2' => 'Inactief');
    echo form_dropdown('page_status', $options, $page_status);
    echo '</td>'.PHP_EOL;
    echo '</tr>'.PHP_EOL;
    echo '<tr>'.PHP_EOL;

    echo '<tr>'.PHP_EOL;
    echo '<td>'. form_label('Pagina is een subpagina?') .'</td>'.PHP_EOL;
    echo '<td>'. form_dropdown('parent_ID', $parent_ID, $selected) .'</td>'.PHP_EOL;
    echo '</tr>'.PHP_EOL;

    echo '<tr>'.PHP_EOL;
    echo '<td>'.PHP_EOL;
    echo form_label('Content title', 'content_title').PHP_EOL;
    echo '</td>'.PHP_EOL;
    echo '<td>'.PHP_EOL;
    echo form_input('content_title', $content_title, 'id="title"').PHP_EOL;
    echo '</td>'.PHP_EOL;
    echo '</tr>'.PHP_EOL;

    echo '<tr>'.PHP_EOL;
    echo '<td>'.PHP_EOL;
    echo form_label('Browser title', 'browser_title').PHP_EOL;
    echo '</td>'.PHP_EOL;
    echo '<td>'.PHP_EOL;
    echo form_input('browser_title', $browser_title, 'id="browser_title"').PHP_EOL;
    echo '</td>'.PHP_EOL;
    echo '</tr>'.PHP_EOL;

    echo '<tr>'.PHP_EOL;
    echo '<td>'.PHP_EOL;
    echo form_label('Menu title', 'menu_title').PHP_EOL;
    echo '</td>'.PHP_EOL;
    echo '<td>'.PHP_EOL;
    echo form_input('menu_title', $menu_title, 'id="menu_title"').PHP_EOL;
    echo '</td>'.PHP_EOL;
    echo '</tr>'.PHP_EOL;

    echo '<tr>'.PHP_EOL;
    echo '<td>'.PHP_EOL;
    echo form_label('Meta keywords', 'meta_keywords').PHP_EOL;
    echo '</td>'.PHP_EOL;
    echo '<td>'.PHP_EOL;
    echo form_input('meta_keywords', (isset($meta_keywords)) ? $meta_keywords : '', 'id="meta_keywords"').PHP_EOL;
    echo '</td>'.PHP_EOL;
    echo '</tr>'.PHP_EOL;
    
    echo '<tr>'.PHP_EOL;
    echo '<td valign="top">'.PHP_EOL;
    echo form_label('Meta description', 'meta_description').PHP_EOL;
    echo '</td>'.PHP_EOL;
    echo '<td >'.PHP_EOL;
//    echo form_textarea($meta_description, null, 'id="meta_description"').PHP_EOL;
    echo '<textarea id="meta_description" name="meta_description" rows="10" cols="50">'.set_value('meta_description', (isset($meta_description)) ? $meta_description : '').'</textarea>'.PHP_EOL;
    echo '</td>'.PHP_EOL;
    echo '</tr>'.PHP_EOL;
    echo '<tr>'.PHP_EOL;
    echo '<td valign="top">'.PHP_EOL;
    echo form_label('Content', 'content_textarea').PHP_EOL;
    echo '</td>'.PHP_EOL;
    echo '<td>'.PHP_EOL;
    echo form_textarea('content', $content, 'id="content_textarea" class="mceEditor"').PHP_EOL;
    echo '</td>'.PHP_EOL;
    echo '</tr>'.PHP_EOL;
    echo '<tr>'.PHP_EOL;
    echo '<td>'.PHP_EOL;
    echo form_submit('submit', 'Save').PHP_EOL;
    echo '<td>'.PHP_EOL;
    echo '</tr>'.PHP_EOL;
    echo '</table>'.PHP_EOL;
    echo form_close().PHP_EOL;
    echo $link_back;
    ?>