<?php
/**
 * @property CI_Loader $load
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Email $email
 * @property CI_DB_active_record $db
 * @property CI_DB_forge $dbforge
 */
class Login extends CI_Controller {
  
  public $header = 'cms/header';
  public $tpl    = 'main_template';
  public $footer = 'cms/footer';
  
  public function Login(){
    parent::__construct();
//    $this->session->keep_flashdata('message_login');
  }
  public function index() {
    $data = array();
    $data['browserTitle'] = 'Login please!';
    $data['header'] = $this->header;
    $data['footer'] = $this->footer;
    $data['main_content'] = 'cms/login_form';
    $this->load->view($this->tpl, $data);
  }

  public function validate_credentials() {

    $this->load->library('form_validation');
    $this->form_validation->set_rules('name', 'Gebruikersnaam', 'trim|required|xss_clean');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

    $this->load->model('cms_user_model');
    

    if ($this->form_validation->run() == FALSE) {
      //if the form validation throws back errors reload the login
      //view and display the errors
      $this->index();
    } else {
      //prep the form data and check against users database
      $username = $this->input->post('username');
      $password = md5($this->input->post('password'));

      $result = $this->cms_user_model->validate($username, $password);
//      var_dump($result);
      if(is_object($result)){
        if ($result->num_rows() > 0) {
          $user_details = $result->row();
          $data = array(
              'username' => $username,
              'is_logged_in' => TRUE,
              'user_id' => $user_details->id,
  //            'user_type' => $user_details->user_type
          );
          $this->session->set_userdata($data);
          redirect('cms/index');
        } else {
//          $this->session->set_error_flashdata('message_login', 'Sorry. De gebruikersnaam en het wachtwoord komen niet overeen.');
          $this->index();
        }
      } else {
        $this->index();
      }
    }
  }

  public function logout() {
    $this->session->sess_destroy();
//    $this->session->sess_create();
//    $this->session->set_success_flashdata('message_login', 'Je bent uitgelogd!');
    redirect('cms/login');
  }

}

