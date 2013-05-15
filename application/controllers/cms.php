<?php
/**
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
 * @todo Form validation callbacks for duplicate film-projects
 */
class Cms extends CI_Controller {

   public $header = 'cms/header';
   public $tpl    = 'main_template';
   public $footer = 'cms/footer';

  public function Cms(){
    parent::__construct();
    
//    $this->session->keep_flashdata('message_login');
    
    $this->is_logged_in();

    $this->load->helper(array('form', 'url'));
    $this->load->library(array('table','form_validation', 'pagination'));
    $this->load->model('cms_model', '', TRUE);
    
  }

  public function index() {
    $data = array();
    $config = array();
    $pages = $this->cms_model->getAll('page', 'id');

    // configure the pagination
    $config['base_url'] = site_url().'cms/index/';
    $config['per_page'] = '10';
    $config['total_rows'] = count($pages);
    $config['uri_segment'] = 2;

    $this->pagination->initialize($config);

    $data['pages'] = $this->cms_model->getAll('page', 'id', 'ASC', FALSE);

    if(empty($data['pages'])){
      $data['no_result'] = 'Er zijn nog geen pagina\'s toegevoegd aan het systeem';
    } else {
      $data['no_result'] = '';
    }

    $data['project_pages'] = $this->cms_model->getAll('page', 'id', 'ASC', TRUE);

    $data['browserTitle'] = 'Secure Studios';
    $data['header'] = $this->header;
    $data['footer'] = $this->footer;
    $data['main_content'] = 'cms/cms-body';

    $this->load->view('main_template', $data);

  }

  /**
   * Security check
   * checks if the request has a user session
   */
  public function is_logged_in()
  {
    $is_logged_in = $this->session->userdata('is_logged_in');

      if(!isset($is_logged_in) || $is_logged_in != true)
      {
          redirect('index.php/login/index');
      }
  }
  
  public function add(){
    $data = array();
    $data['action'] = site_url('cms/addpage');
    $data['link_back'] = anchor('cms/index/','Terug naar de lijst',array('class'=>'button'));
    $data['pageTitle'] = 'Nieuwe pagina';
    $data['message'] = '';
    $data['browserTitle'] = 'Pagina';

    // Get column names and store them in the data array
    $columns = $this->cms_model->get_column_names('page');
    foreach($columns as $key ){
      $data[$key] = '';
    }

    $data['meta_description']['value']  = '';
    $data['meta_description']['rows']   = '10';
    $data['meta_description']['cols']   = '50';
    $data['meta_description']['name']   = 'meta_description';

    $parents = $this->cms_model->getParents('page');
    $data['parent_ID'][0] = '-- Kies een pagina --';
    foreach($parents as $page => $row){
      $data['parent_ID'][$row->id] = $row->menu_title;
    }
    $data['selected'] = '';
    $data['header'] = $this->header;
    $data['footer'] = $this->footer;
    $data['main_content'] = 'cms/edit_page';
    $this->load->view('main_template', $data);
  }

  public function addpage(){
    $data = array();

    // setting properties
    $data['main_content'] = 'cms/edit_page';
    $data['pageTitle'] = 'Create new page';
    $data['action'] = site_url('cms/addpage');
    $data['link_back'] = anchor('cms/index','Terug naar de lijst',array('class'=>'button'));
    $data['message'] = '';
    $data['browserTitle'] = 'Pagina';


    // setting validation rules
    $this->_set_rules();

    // Set error messages
    $this->form_validation->set_message('required', '%s is verplicht!');
    $this->form_validation->set_message('isset', '* Verplicht veld');

    if ($this->form_validation->run('page') == FALSE) {

      // Put post values in the data array for repopulation of the form
      foreach ($_POST as $key => $value) {
        $data[$key] = $value;
      }
      $this->load->view('main_template', $data);
    } else {

      $data = array(
          'id'                  => $this->input->post('id'),
          'page_parent_ID'      => $this->input->post('parent_ID'),
          'page_status'         => $this->input->post('page_status'),
          'menu_title'          => $this->input->post('menu_title'),
          'browser_title'       => $this->input->post('browser_title'),
          'content_title'       => $this->input->post('content_title'),
          'content'             => $this->input->post('content'),
          'meta_keywords'       => $this->input->post('meta_keywords'),
          'meta_description'    => $this->input->post('meta_description'),
      );


      // Create human and bot friendly permalink
        $data['permalink'] = url_title($data['menu_title'], 'dash', true);

      $id = $this->cms_model->addRecord($data, 'page');

      // set form input name="id"
      $this->form_validation->id = $id;

      // set user message
      $data['message'] = '<div class="message success">Pagina succesvol toegevoegd</div>';
      $data['pages'] = $this->cms_model->getAll('page', 'id');
      $data['project_pages'] = $this->cms_model->getAll('page', 'id', 'ASC', TRUE);
      $data['title'] = 'Pagina toegevoegd!';
      $data['header'] = $this->header;
      $data['footer'] = $this->footer;
      $data['main_content'] = 'cms/cms-body';
      $data['browserTitle'] = 'Pages';
      $data['link_back'] = anchor('index.php/cms/index', 'Terug naar de lijst', array('class' => 'button'));

      // load view
      $this->load->view('main_template', $data);
    }
  }

  function update($id) {

    $data = array();

    // prefill form values
    $pageData = $this->cms_model->getRecord('page', $id);
    
    foreach ($pageData as $key => $object) {

      foreach($object as $key => $value){
        $data[$key] = $value;
      }
    }
    
    $parents = $this->cms_model->getParents('page');

    $data['parent_ID'][0] = '-- Kies een pagina --';
    foreach($parents as $row){
      $data['parent_ID'][$row->id] = $row->menu_title;
      $data['selected'] = array($row->id);
    }
    
    // Set common properties
    $data['pageTitle'] = 'Update Pagina';
    $data['message'] = '';
    $data['action'] = site_url('cms/update_page');
    $data['link_back'] = anchor('cms/index', 'Terug naar de lijst', array('class' => 'button'));
    $data['main_content'] = 'cms/edit_page';
    $data['browserTitle'] = 'Pagina bewerken';
    $data['header'] = $this->header;
    $data['footer'] = $this->footer;

    // Load view
    $this->load->view('main_template', $data);
  }

  function update_page() {

    $data = array();

    $id = $this->input->post('id');

    // prefill form values
    $pageData = $this->cms_model->getRecord('page', $id);

    foreach ($pageData as $key => $object) {
      foreach($object as $key =>$value){
        $data[$key] = $value;
      }
    }

    $data['pageTitle'] = 'Update Page';
    $data['action'] = site_url('cms/update_page');
    $data['link_back'] = anchor('cms/index', 'Terug naar de lijst', array('class' => 'button'));
    $data['main_content'] = 'cms/edit_page';
    $data['browserTitle'] = 'Pagina';
    $data['header'] = $this->header;
    $data['footer'] = $this->footer;

    // set validation properties
    $this->_set_rules();

    // Set error messages
    $this->form_validation->set_message('required', '<font style="color: red; font-size:12px;">%s is required!</font>');
    $this->form_validation->set_message('isset', '* required');

    // run validation
    if ($this->form_validation->run('page_update') == FALSE) {
      //return to edit page
      $this->load->view('main_template', $data);
    } else {

      // save data
      $id = $this->input->post('id');
      $updatedPage = array(
          'id' => $this->input->post('id'),
          'page_parent_ID' => $this->input->post('parent_ID'),
          'page_status' => $this->input->post('page_status'),
          'menu_title' => $this->input->post('menu_title'),
          'browser_title' => $this->input->post('browser_title'),
          'content_title' => $this->input->post('content_title'),
          'content' => $this->input->post('content'),
          'meta_keywords' => $this->input->post('meta_keywords'),
          'meta_description' => $this->input->post('meta_description'),
      );

//var_dump($updatedPage); die;
      $this->cms_model->updateRecord($id, $updatedPage, 'page');

      $data['pages'] = $this->cms_model->getAll('page');
      $data['project_pages'] = $this->cms_model->getAll('page', 'id', 'ASC', TRUE);
//echo $this->db->last_query();

      // set user confirm message
      $data['message'] = '<div class="success">Pagina is aangepast</div>';
      $data['title'] = 'Pagina aangepast';
      $data['main_content'] = 'cms/cms-body';
      $data['link_back'] = anchor('cms/index', 'Terug naar de lijst.', array('class' => 'button'));

      //load updatesucces view
      $this->load->view('main_template', $data);
    }
  }

  function projects() {
    $data = array();

    //Set where condition for the query to select subpage films
    $conditions = array('is_parent !='=> '1');
    $projects = $this->cms_model->getAll('film', 'id', 'ASC', FALSE, NULL,NULL, $conditions);

    // configure the pagination
    $config['base_url'] = site_url().'cms/projects/';
    $config['per_page'] = '10';
    $config['total_rows'] = count($projects);
    $config['uri_segment'] = 2;

    $this->pagination->initialize($config);

    $data['pages'] = $this->cms_model->getAll('film', 'id', 'ASC', FALSE, NULL,NULL, $conditions);
    if(empty($data['pages'])){
      $data['no_result'] = 'Er zijn nog geen projecten toegevoegd aan het systeem';
    } else {
      $data['no_result'] = '';
    }

    $conditions = array('is_parent =' => '1');
    $data['mainpages'] = $this->cms_model->getAll('film', 'id', 'ASC', FALSE, NULL, NULL, $conditions);

    $data['message'] = '';
    $data['header'] = $this->header;
    $data['footer'] = $this->footer;
    $data['browserTitle'] = 'Film Overzicht';
    $data['main_content'] = 'cms/cms-body-projecten';

    $this->load->view($this->tpl, $data);
  }

  function addproject() {
    $data = array();

    $data['main_content'] = 'cms/edit_project';
    $data['action'] = site_url('cms/process_addproject');
    $data['link_back'] = anchor('cms/projects/','Terug naar de lijst',array('class'=>'button'));
    $data['title'] = 'Voeg een nieuw project toe';
    $data['message'] = '';
    $data['browserTitle'] = 'Projecten';
    $data['error'] = '';
    
    $data['pages'] = $this->cms_model->getAllProjectNames();
    $data['active_page'][] = '';

    if($data['pages'] == FALSE) {
      $data['message'] = '<div class="message warning">Let op: je moet eerst een project pagina maken voordat je een filmpje kan koppelen.</div>';
    }
    
//    echo $this->db->last_query();
//    var_dump($data['pages']); die;
    
    // Get column names and store them in the data array
    $columns = $this->cms_model->get_column_names('film');
    foreach($columns as $key ){
      $data[$key] = '';
    }

//    $data['meta_description']['value']  = '';
    $data['meta_description']['rows']   = '10';
    $data['meta_description']['cols']   = '50';
    $data['meta_description']['name']   = 'meta_description';
    $data['header'] = $this->header;
    $data['footer'] = $this->footer;

    $this->load->view($this->tpl, $data);
  }

  function process_addproject() {
    $data = array();

    // setting properties
    $data['main_content'] = 'cms/edit_project';
    $data['title'] = 'Voeg een nieuwe film aan een projectpagina toe.';
    $data['action'] = site_url('cms/process_addproject');
    $data['link_back'] = anchor('/cms/projects','Terug naar de lijst',array('class'=>'back'));
    $data['message'] = '';
    $data['browserTitle'] = 'Projecten';
    $data['header'] = $this->header;
    $data['footer'] = $this->footer;

    
    // setting validation rules
    $this->_set_rules();

    // Set error messages
    $this->form_validation->set_message('required', '%s is verplicht!');
    $this->form_validation->set_message('isset', '* Verplicht');

    if ($this->form_validation->run('film') == FALSE) {

      $data['error'] = '1 of meer verplichte velden waren leeg!';
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
          'page_id' => $this->input->post('page_id'),
      );
      $projectData = new stdClass();
      $projectData = $this->cms_model->getRecord('page', $data['page_id']);
      
      if($projectData){
        foreach($projectData as $row){
          $data['name'] = $row->menu_title;
        }
      }
      
      // save the new record
      $id = $this->cms_model->addRecord($data, 'film');
//echo $this->db->last_query();

      // set form input name="id"
      $this->form_validation->id = $id;


      // set user message
      $data['message'] = '<div class="message success">Succesvol een nieuwe film aan een projectpagina toegevoegd!</div>';
      $data['title'] = 'Project toegevoegd!';
      $data['main_content'] = 'cms/cms-body-projecten';
      $data['header'] = $this->header;
      $data['footer'] = $this->footer;
      $data['link_back'] = anchor('/cms/projects', 'Terug naar de lijst', array('class' => 'button'));
      
      // Get film list
      $data['pages'] = $this->cms_model->getAll('film', 'id', 'ASC', FALSE);
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

  function update_project($id) {
    $data = array();

    // prefill form values
    $filmData = $this->cms_model->getRecord('film', $id);
//echo $this->db->last_query();
    
    foreach ($filmData as $key => $object) {
      foreach($object as $key => $value){
        $data[$key] = $value;
      }
    }

    // Set common properties
    $data['title'] = 'Update project';
    $data['message'] = '';
    $data['action'] = site_url('cms/process_update_project/');
    $data['link_back'] = anchor('cms/projects', 'Terug naar de lijst.', array('class' => 'button'));
    $data['main_content'] = 'cms/edit_project';
    $data['browserTitle'] = 'Projecten';
    $data['error'] = '';

    $data['pages'] = $this->cms_model->getAllProjectNames();
    $data['active_page'][] = $data['page_id'];
    
    // Load view
    $data['header'] = $this->header;
    $data['footer'] = $this->footer;
    $this->load->view($this->tpl, $data);
  }

  function process_update_project(){
    $data['browserTitle'] = 'Projecten';
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

    // Set common page properties
    $data['pageTitle']      = 'Update film';
    $data['message']        = '';
    $data['action']         = site_url('film/update_film');
    $data['browserTitle']   = 'Projecten';
    $data['main_content']   = 'cms/edit_film';
    $data['link_back']      = anchor('cms/projects', 'Terug naar de lijst.', array('class' => 'button'));
    $data['error']          = '';

    // set pages array
    $data['pages'] = $this->cms_model->getAllProjectNames();
//echo $this->db->last_query();
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
          'is_parent' => 0,
          'page_id' => $this->input->post('page_id'),
      );

      $this->cms_model->updateRecord($id, $data, 'film');
      $conditions = array('is_parent !='=> '1');
      $data['pages'] = $this->cms_model->getALL('film', 'id', 'ASC', FALSE, NULL, NULL, $conditions);
      $conditions = array('is_parent ='=> '1');
      $data['mainpages'] = $this->cms_model->getALL('film', 'id', 'ASC', FALSE, NULL, NULL, $conditions);

      // set user confirm message
      $data['message'] = '<div class="success">Het project is aangepast in de database.</div>';
      $data['title'] = 'Project aangepast';
      $data['browserTitle'] = 'Projecten';
      $data['main_content'] = 'cms/cms-body-projecten';
      $data['link_back'] = anchor('cms/projects', 'Terug naar de lijst.', array('class' => 'button'));

      //load updatesucces view
      $data['header'] = $this->header;
      $data['footer'] = $this->footer;
      $this->load->view($this->tpl, $data);
    }
  }

    function delete($id) {
    $pageId = array();
    $pages = array('home', 'projecten', 'producten', 'contact');
    foreach($pages as $page){
      $pageId[] = $this->cms_model->getPermalinkId($page, 'page');
    }
    foreach($pageId as $pid){
      foreach($pid as $ids){
        if($ids->id == $id){
          redirect('cms/index');
        }
      }
    }

    $this->cms_model->delete($id);

    //Refresh the overview page
    redirect('cms/index/');
  }
  function delete_project($id) {

    $this->cms_model->delete($id,'film');

    //Refresh the overview page
    redirect('cms/projects/');
  }

  function _set_rules() {

    $rules = $this->config->load('form_validation');

    $this->form_validation->set_rules($rules);
  }

  function film_vali($page_id){

    $result = $this->cms_model->getRecord('film', NULL, 'page_id', $page_id);
    if($result->num_rows() >0){
      $this->form_validation->set_message('film_vali', 'Deze film id is al gelinkt aan een project pagina.');
      return FALSE;
    } else {
      return TRUE;
    }
  }
  
  function permalink_check($permalink) {

    $result = $this->cms_model->get_row_permalink($permalink);

    if ($result->num_rows() > 0) {
      $this->form_validation->set_message('permalink_check', $permalink . ' allready exists, a permalink should be unique!');
      return FALSE;
    } else {
      return TRUE;
    }
  }
}