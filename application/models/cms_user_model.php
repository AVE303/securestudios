<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Cms_user_model extends CI_Model {
  
  public function Cms_user_model(){
    parent::__construct();
  }  

  public function validate($username, $password) {
//    $this->db->where('user_name', $username);
//    $this->db->where('user_password', $password);
    $this->db->select('user.id')
             ->select('user.name')
             ->from('user')
             ->where('name', $username)
             ->where('password', $password)
             ->limit(1);
    $query = $this->db->get();
//    echo $this->db->last_query().'<br />'.PHP_EOL;

    if ($query->num_rows() > 0) {
      return $query;
    } else {
      return false;
    }
  }

}