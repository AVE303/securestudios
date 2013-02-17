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

    $mainMenu = $this->page_model->get_menu();
      $submenu = new stdClass();
//      var_dump($mainMenu);
    foreach($mainMenu as $parent){
        $subMenu = $this->page_model->get_menu($parent->id);
//        echo $this->db->last_query(); echo '<br>'.PHP_EOL;
    }
//    var_dump($subMenu); die;
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
    if($this->uri->segment(4) != '' && $this->uri->segment(3) == 'projecten' ){
      $permalink = $this->uri->segment(4);
      
      $data['filmdata'] = $this->page_model->get_film($permalink);
      
    } elseif ($this->uri->segment(4) != '' && $this->uri->segment(3) == 'producten') {
      
      $permalink = $this->uri->segment(4);
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
    
    //Get the product submenu
    $products = $this->get_menu($this->cms_model->getPermalinkId('producten', 'page')->id);

    foreach($products as $item) {
      $data['productmenu'][$item->id]['menu_title'] = $item->menu_title;
      $data['productmenu'][$item->id]['permalink'] = $item->permalink;
    }
    //Get the project submenu
    $projects = $this->get_menu($this->cms_model->getPermalinkId('projecten', 'page')->id);

    foreach($projects as $item) {
      $data['projectmenu'][$item->id]['menu_title'] = $item->menu_title;
      $data['projectmenu'][$item->id]['permalink'] = $item->permalink;
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
//Get the project submenu
//    $projects = $this->get_menu($this->cms_model->getPermalinkId('projecten', 'page')->id);
//
//    foreach($projects as $item) {
//      $data['projectmenu'][$item->id]['menu_title'] = $item->menu_title;
//      $data['projectmenu'][$item->id]['permalink'] = $item->permalink;
//    }
//
//    //Get the product submenu
//    $products = $this->get_menu($this->cms_model->getPermalinkId('producten', 'page')->id);
//    foreach($products as $item) {
//      $data['productmenu'][$item->id]['menu_title'] = $item->menu_title;
//      $data['productmenu'][$item->id]['permalink'] = $item->permalink;
//    }
  

}