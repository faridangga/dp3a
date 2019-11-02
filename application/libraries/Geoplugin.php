<?php defined('BASEPATH') OR exit('No direct script access allowed');

use ipinfo\ipinfo\IPinfo;
/**
 * Geoplugin
 * @author <Vive Vio Permana>
 * 
 * Library for auto-redirecting into yourdomain.com/en url when the user
 * was detected come from outside Indonesia
 * this library use ipinfo.io that has of charge for 1k request.
 * Actually, there is an optional free method, by collecting the ip's
 * from https://lite.ip2location.com/indonesia-ip-address-ranges,
 * save it to csv, format the ip as well so our code can read the ip ranges
 * 
 */
class Geoplugin {

	protected $ci;
	
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->helper('cookie');
	}
	
	public function geo_redirect_check()
	{

		$country = get_cookie('my_country_cookies');

		/**
		 * Access token from https://ipinfo.io/account
		 * -------------------
		 */
		$access_token = '85b1659d92938b';

		try {

			if( is_null($country) ) {

				$client 	= new IPinfo($access_token);
				$ip_address = $this->ci->input->ip_address();
				$details 	= $client->getDetails($ip_address);
				$country 	= $details->country;

				$cookies_country_duration = 3600*24; // 1 day

				// set country cookies for 1 day
				set_cookie('my_country_cookies', $country, $cookies_country_duration );
				
			}
			
			$uri_segment = $this->ci->uri->segment(1);
			$flash_cookie = get_cookie('manual_switch_to_id');
			if($country !== 'ID' && $uri_segment != 'en' && is_null($flash_cookie) ) {
				redirect('en', 'location');
			}

		} catch (Exception $e) {
			return false;
		}
	}

}