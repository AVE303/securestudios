<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class MY_Session extends CI_Session
{
        
        function MY_Session()
        {
                parent::__construct();

        }



        /**
         * Add or change success flashdata, only available
         * until the next request
         *
         * @access      public
         * @param       mixed
         * @param       string
         * @return      void
         */
        function set_success_flashdata($newdata = array(), $newval = '')
        {
                if (is_string($newdata))
                {
                        $newdata = array($newdata => $newval);
                }

                if (count($newdata) > 0)
                {
                        foreach ($newdata as $key => $val)
                        {
                                $flashdata_key = $this->flashdata_key.':new:'.$key;
                                $this->set_userdata($flashdata_key, "<p class='success'>".$val."</p>");
                        }
                }
        }
        
        /**
         * Add or change error flashdata, only available
         * until the next request
         *
         * @access      public
         * @param       mixed
         * @param       string
         * @return      void
         */
        function set_error_flashdata($newdata = array(), $newval = '')
        {
                if (is_string($newdata))
                {
                        $newdata = array($newdata => $newval);
                }

                if (count($newdata) > 0)
                {
                        foreach ($newdata as $key => $val)
                        {
                                $flashdata_key = $this->flashdata_key.':new:'.$key;
                                $this->set_userdata($flashdata_key, "<p class='error'>".$val."</p>");
                        }
                }
        }
}
