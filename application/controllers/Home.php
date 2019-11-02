<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
    }

    
    /**
     * Index Page
     */
    public function index()
    {

        error_reporting(0);
    
    /**
         * Uncomment two line below to enable geo redirect feature
         * What is that? When the server detect user has an ip that come outside from
         * Indonesia. it will be auto-redirecting to ajar.id/en url
         */
        // $this->load->library('geoplugin');
        // $this->geoplugin->geo_redirect_check();

        echo 'Helo';
        $this->load->view('home');
        //$this->load->view('index');

    }
    public function welcome(){
        echo 'home';
        $this->load->view('home');
    }
    
    public function error_404()
    {
        $data['title'] = "Error 404";
        $data['description'] = "Error 404";
        $data['keywords'] = "error,404";

        $this->load->view('errors/error_404');
        
    }

}
