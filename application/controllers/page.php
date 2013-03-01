<?php
/**
 * @property CI_Loader $load
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Email $email
 * @property CI_DB_active_record $db
 * @property CI_DB_forge $dbforge
 * @property cms_model $cms_model
 * @property page_model $page_model
 */
class Page extends CI_Controller{

  function Page() {
    parent::__construct();
    $this->load->helper(array('date', 'url', 'form'));
    $this->load->library(array('table','form_validation', 'pagination'));
    $this->load->model('page_model');
    $this->load->model('cms_model');
  }

  function  Index() {
    

    $data = array(
        'header' => 'header',
        'main_content' => 'view_page',
        'footer' => 'footer',
        'background' => 'home'
    );
    $content = $this->page_model->get_row('home');
    $filmdata =  $this->page_model->get_film('home');

    $mainMenu = $this->page_model->get_menu(0);

    if(isset($mainMenu) && $mainMenu != NULL){
      foreach($mainMenu as $parent){
        $data['submenu'][$parent->permalink] = $this->page_model->get_menu($parent->id);
      }
    }

    if(!empty($mainMenu)){
      $data['menu'] = $mainMenu;
    }

    if(!empty($content)){
      $data['content'] = $content;
    } else {
      $data['content'] = show_404();
    }
    if(!empty($filmdata)){
      $data['filmdata'] = $filmdata;
    }
    $this->load->view('main_template', $data);
  }

  public function content(){

    // redirect back to index if permalink is home
    if($this->uri->segment(3) == 'home'){
      redirect($this->index());
    }

    $data = array();

    // Load the background image class variable
    switch ($this->uri->segment(3)) {
      case 'producten': $data['background'] = 'producten'; break;
      case 'projecten': $data['background'] = 'projecten'; break;
      case 'contact': $data['background'] = 'contact'; break;
      default: $data['background'] = 'home'; break;
    }
    if($this->uri->segment(3) != '' && $this->uri->segment(3) == 'projecten' ){
      $permalink = $this->uri->segment(3);
      
      $data['filmdata'] = $this->page_model->get_film($permalink);
      
    } elseif ($this->uri->segment(3) != '' && $this->uri->segment(3) == 'producten') {
      
      $permalink = $this->uri->segment(3);
      $data['filmdata'] = '';
      
    } else {
      $permalink = $this->uri->segment(3);
      $data['filmdata'] = '';
    }
    $content = $this->page_model->get_row($permalink);

    if(!empty($content)){
      $data['content'] = $content;
    } else {
      $data['content'] = '';
    }

    // Build the navigation
    $mainMenu = $this->page_model->get_menu(0);

    if(isset($mainMenu) && $mainMenu != NULL){
      foreach($mainMenu as $parent){
        $data['submenu'][$parent->permalink] = $this->page_model->get_menu($parent->id);
      }
    }

    if(!empty($mainMenu)){
      $data['menu'] = $mainMenu;
    }

    // Load the views
    $data['header'] = 'header';
    $data['footer'] = 'footer';
    $data['main_content'] = 'view_page';

    $this->load->view('main_template', $data);
  }

  public function get_menu($parent = 0){
    
    $menu = $this->page_model->get_menu($parent);
    return $menu;
  }


}