<?php
class Page_model extends CI_Model{

  public function Page_model(){
    // Call the Model constructor
    parent::__construct();
  }

  public function get_row($permalink, $id = null, $limit = null, $offset = null) {

    if (!empty($permalink)) {
      $this->db->select('*')->from('page')->where(array('permalink' => $permalink, 'page_status' => 1));
      $query = $this->db->get();
      
    } elseif ($id != null){
      $this->db->select('*')->from('page')->where(array('id' => $id, 'page_status' => 1));
      $query = $this->db->get();
    }
    if($query->num_rows() >0){

    return $query->result_array();
    }
    return false;
  }

  public function get_film($permalink = null, $limit = null, $offset = null){

    if(!empty($permalink)){

      $this->db->select('page.id, film.name, film.link, film.page_id')->from('page')->where(array('page.permalink' => $permalink))->join('film', 'film.page_id = page.id');

      $result = $this->db->get();
      
    }
    if($result->num_rows() > 0){
      return $result->result();
    } else {
      return false;
    }
  }

  public function get_all_films() {
    $result = $this->db->get('film');
    return $result->result_array();
  }

  public function get_menu($parent = 0){
    $this->db->select('menu_title')->select('permalink')->select('id')->select('page_parent_ID')->from('page')->where(array('page_parent_ID' => $parent))->order_by('id', 'ASC');
    $menu = $this->db->get();

    if($menu->num_rows() >0){

      return $menu->result();
    }
    return false;
  }
}

