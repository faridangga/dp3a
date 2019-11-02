<?php (!defined('BASEPATH')) and exit('No direct script access allowed');

/**
 * Handle all user activity on Ajar.ID
 * Listed activity
 * 1. Log every post that user read
 */
class User_activity {

    private $_ci;

   function __construct() {
       $this->_ci =& get_instance();
   }

   public function get_browser_origin()
   {

        $agent[]   = $this->_ci->agent->platform();
        $agent[]   = $this->_ci->agent->browser();
        $agent[]   = $this->_ci->agent->version();

        return implode( '::', $agent );
   }

   public function get_top_learner($limit=false)
   {
        if( $limit != false ) return $this->_ci->auth_model->get_top_learner($limit);
        return $this->_ci->auth_model->get_top_learner();
   }

}
