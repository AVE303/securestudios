<?php
/**
 * Created by JetBrains PhpStorm.
 * User: akko
 * Date: 15-2-13
 * Time: 15:36
 * To change this template use File | Settings | File Templates.

 * @property CI_Loader $load
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Email $email
 * @property CI_DB_active_record $db
 * @property CI_DB_forge $dbforge
 * @property CI_Table $table
 * @property CI_Session $session
 * @property CI_FTP $ftp
 * @property cms_model $cms_model
 */
require(APPPATH.'controllers/cms.php');
class Films extends Cms{

  function Films(){
    parent::Cms();

  }

  function listall(){
    redirect($this->index());
  }

  function addmainpagefilm(){
      // setting properties
      $data['main_content'] = 'cms/edit_parentpagefilm';
      $data['title'] = 'Voeg een nieuwe film aan een hoofdpagina toe.';
      $data['action'] = site_url('films/process_addmainpagefilm');
      $data['link_back'] = anchor('films/listall','Terug naar de lijst',array('class'=>'back'));
      $data['message'] = '';
      $data['browserTitle'] = 'Films op hoofdpagina';
      $data['header'] = $this->header;
      $data['footer'] = $this->footer;
      $data['error'] = '';
      $data['filmPages'] = '';

    /**
     * Form validation. No duplicate entries.
     *  Get the parent pages. Loop thrue them and check if their id exists in the film table.
     * */
    $parentpages = $this->cms_model->getParents('page');
    $filmPages = '';
    foreach($parentpages as $parent){
      $page_id = $this->cms_model->getRecord('film',NULL,'page_id',$parent->id);
      if(!empty($page_id)){
          $filmPages = $page_id;
      }
    }
    $data['filmPages'] = $filmPages;
    $data['pages'] = $this->cms_model->getParents('page');

    $data['active_page'][] = '';

    if($data['pages'] == FALSE) {
      $data['message'] = '<div class="message warning">Let op: je moet eerst een project pagina maken voordat je een filmpje kan koppelen.</div>';
    }

    // Get column names and store them in the data array
    $columns = $this->cms_model->get_column_names('film');
    foreach($columns as $key ){
      $data[$key] = '';
    }

    $data['header'] = $this->header;
    $data['footer'] = $this->footer;

    $this->load->view($this->tpl, $data);

  }

  function process_addmainpagefilm(){
    $data = array();

    // setting properties
    $data['main_content'] = 'cms/edit_parentpagefilm';
    $data['title'] = 'Voeg een nieuwe film aan een hoofdpagina toe.';
    $data['action'] = site_url('cms/process_addproject');
    $data['link_back'] = anchor('films/listall','Terug naar de lijst',array('class'=>'back'));
    $data['message'] = '';
    $data['browserTitle'] = 'Films op hoofdpaginas';
    $data['header'] = $this->header;
    $data['footer'] = $this->footer;

    /**
     * Form validation. No duplicate entries.
     * Get the parent pages. Loop thrue them and check if their id exists in the film table.
     * */
    $parentpages = $this->cms_model->getParents('page');

    foreach($parentpages as $parent){
      $page_id = $this->cms_model->getRecord('film',NULL,'page_id',$parent->id);
      if(!empty($page_id)){
        $filmPages = $page_id;
      }
    }
    $data['filmPages'] = $filmPages;


    // setting validation rules
    $this->_set_rules();

    // Set error messages
    $this->form_validation->set_message('required', '%s is verplicht!');
    $this->form_validation->set_message('isset', '* Verplicht');

    $this->form_validation->set_rules('callback_film_vali[page_id]');

    if ($this->form_validation->run('film') == FALSE) {

      $this->form_validation->set_message('1 of meer verplichte velden waren leeg!');

      // Put post values in the data array for repopulation of the form
      foreach ($_POST as $key => $value) {
        $data[$key] = $value;
      }
      $this->load->view('main_template', $data);
    } else {

      $data = array(
        'id' => $this->input->post('id'),
        'name' => $this->input->post('name'),
        'link' => $this->input->post('link'),
        'filmtext' => $this->input->post('filmtext'),
        'is_parent' => 1,
        'page_id' => $this->input->post('page_id'),
      );


      // save the new record
      $id = $this->cms_model->addRecord($data, 'film');


      // set form input name="id"
      $this->form_validation->id = $id;


      // set user message
      $data['message'] = '<div class="message success">Succesvol een nieuwe film aan een pagina toegevoegd!</div>';
      $data['title'] = 'Film toegevoegd!';
      $data['main_content'] = 'cms/cms-body-films';
      $data['header'] = $this->header;
      $data['footer'] = $this->footer;
      $data['link_back'] = anchor('/films/listall', 'Terug naar de lijst', array('class' => 'button'));

      // Get film list
      $data['pages'] = $this->cms_model->getAll('film', 'page_id', 'ASC', FALSE);
      // Set no result string
      if(!$data['pages']){
        $data['no_result'] = 'Er zijn nog geen films toegevoegd aan project pagina\'s';
      } else {
        $data['no_result'] = '';
      }
      // load view and return to the list
      $this->load->view($this->tpl, $data);
    }
  }
  function update_mainpage_film($id){
    $data = array();

    // prefill form values
    $filmData = $this->cms_model->getRecord('film', $id);

    foreach ($filmData as $key => $object) {
      foreach($object as $key => $value){
        $data[$key] = $value;
      }
    }

    // Set common properties
    $data['title'] = 'Update film';
    $data['message'] = '';
    $data['action'] = site_url('films/process_mainpage_film_update/');
    $data['link_back'] = anchor('cms/projects', 'Terug naar de lijst.', array('class' => 'button'));
    $data['main_content'] = 'cms/edit_project';
    $data['browserTitle'] = 'Films';
    $data['error'] = '';

    $data['pages'] = $this->cms_model->getParents('page');
    $data['active_page'][] = $data['page_id'];
    $data['page_name'] = $this->cms_model->getPageTitle($data['page_id']);

    // Load view
    $data['header'] = $this->header;
    $data['footer'] = $this->footer;
    $this->load->view($this->tpl, $data);
  }

  public function process_mainpage_film_update($id) {
    $data['browserTitle'] = 'Hoofdpagina film aangepast';
    $data = array();

    $id = $this->input->post('id');

    // prefill form values
    $filmData = $this->cms_model->getRecord('film', $id);
//echo $this->db->last_query();
    foreach ($filmData as $key => $object) {
      foreach($object as $key => $value){
        $data[$key] = $value;
      }
    }
//var_dump($data); die;
    // Set common page properties
    $data['pageTitle']      = 'Update hoofdpagina film';
    $data['message']        = '';
    $data['action']         = site_url('film/update_mainpage_film');
    $data['browserTitle']   = 'Projecten';
    $data['main_content']   = 'cms/edit_film';
    $data['link_back']      = anchor('cms/projects', 'Terug naar de lijst.', array('class' => 'button'));
    $data['error']          = '';

    // set pages array
    $data['page_name'] = $this->cms_model->getPageTitle($id);
//echo $this->db->last_query();
//    die;
    // setting validation rules
    $this->_set_rules();

    // Set error messages
    $this->form_validation->set_message('required', '%s is required!');
    $this->form_validation->set_message('isset', '* required');

    if ($this->form_validation->run('film_update') == FALSE) {
      $this->load->view($this->tpl, $data);
    } else {

      $id = $this->input->post('id');
      $data = array(
        'id' => $this->input->post('id'),
        'name' => $this->input->post('name'),
        'link' => $this->input->post('link'),
//        'filmtext' => $this->input->post('filmtext'),
        'page_id' => $this->input->post('page_id'),
        'is_parent' => 1
      );

      $this->cms_model->updateRecord($id, $data, 'film');
      $data['pages'] = $this->cms_model->getALL('film');

      // set user confirm message
      $data['message'] = '<div class="success">Het project is aangepast in de database.</div>';
      $data['title'] = 'Hoofdpagina film aangepast';
      $data['browserTitle'] = 'Projecten';
      $data['main_content'] = 'cms/cms-body-projecten';
      $data['link_back'] = anchor('cms/projects', 'Terug naar de lijst.', array('class' => 'button'));

      //load updatesucces view
      $data['header'] = $this->header;
      $data['footer'] = $this->footer;
      $this->load->view($this->tpl, $data);
    }
  }
}
