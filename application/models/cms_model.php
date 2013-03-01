<?php
class Cms_model extends CI_Model{

  public function Cms_model(){
    parent::__construct();
  }

  public function getAll($table, $orderColumn = 'id', $orderDirection = 'ASC', $subs = FALSE, $limit = null, $offset = null, $condition = array()) {

    if($subs){
      $this->db->where('page_parent_ID !=', 0);
    } elseif($table == 'page') {
      $this->db->where('page_parent_ID =', 0);
    }

    if(!empty($condition)){
      foreach($condition as $q => $con){
        $this->db->where($q,$con);
      }
    }

    // set order column and direction
    $this->db->order_by($orderColumn, $orderDirection);

    $query = $this->db->get($table, $limit, $offset);

    if ($query->num_rows() > 0) {
      return $query->result();
    }
    return FALSE;

  }
  
  public function getParents($table){
    if(!$table){
      return false;
    }
    $this->db->select('id, menu_title, permalink')->where('page_parent_ID =', 0);
    $q = $this->db->get($table);
    
    if($q->num_rows() >0) {
      return $q->result();
    } else {
      return false;
    }
  }


  public function getAllProjectNames() {
    $this->db->select('id, menu_title')->where('page_parent_ID !=', 0);
    $query = $this->db->get('page');
    
    if($query->num_rows() > 0){
      return $query->result();
    }
    else {
      return false;
    }
  }

  /*
   * Get all page titles
   */
  public function getAllPageTitles($skiphome = true) {
    $this->db->select('id, menu_title');
    if($skiphome === true) {
      $this->db->where('menu_title !=', 'Home');
    }
    $query = $this->db->get('page');

    if($query->num_rows() > 0) {
      return $query->result();
    }
    else {
      return false;
    }
  }

  /**
   * get one record
   * @param $id int the id of the record to fetch
   * @param $table string the name of the table to fetch from
   * @param $whereField string Optional column to look in.
   * @param $whereVal string Optional value to look for in the where column
   */
  public function getRecord($table, $id = NULL, $whereField = '', $whereVal = NULL){
    if($whereField) {
      $this->db->where($whereField, $whereVal);
    } else {
      $this->db->where('id', $id);
    }
    
    $res = $this->db->get($table);
    if($res->num_rows() >0){
      return $res->result();
    } else {
      return FALSE;
    }
  }

  /**
   * get the id of given permalink
   * @param string $permalink
   * @param string $table
   */
  public function getPermalinkId($permalink, $table){
    
    if(is_array($permalink)){
      $this->db->select('id')->where_in('permalink',$permalink); 
      $query = $this->db->get($table);
      if($query->num_rows() >0){
        return $query->result();
      } else {
        return FALSE;
      }
    } else {
      $this->db->select('id')->where('permalink', $permalink);
    }
    
    $query = $this->db->get($table);
    if($query->num_rows() >0){
      return $query->row();
    } else {
      return FALSE;
    }
  }

  /**
   * Insert a record
   * @param $data array()
   */
  public function addRecord($data, $table){
    $this->db->insert($table, $data);
    return;
  }

  /**
   * Update a record
   * @param $id
   * @param $data array()
   */
  public function updateRecord($id, $data, $table){
    $this->db->where('id', $id);
    $this->db->update($table, $data);
    return;
  }

  /**
   * Delete a record
   * @param $id
   */
  public function delete($id, $table = 'page'){

    $this->db->where('id' , $id);
    $this->db->delete($table);
  }

  public function search($search_string, $columns = array()){


    foreach($columns as $column){
        $data[$column] = $column;
    }

    $this->db->like($data,$search_string);

    return $this->db->get('page');
  }


  /**
   * @return array with column names of a table
   * @param $table
   */
  function get_column_names($table){
    $arrayColumns = array();

    $query = $this->db->query("SHOW COLUMNS FROM `" . $table. "`");


    foreach ($query->result_array() as $row) {
      $arrayColumns[] = $row['Field'];
    }

    return $arrayColumns;
  }
}