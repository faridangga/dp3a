<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajarform {

	private $CI;

	public $form_id 		= NULL;
	public $form_elements 	= array();
	public $html_form 		= NULL;

	public function __construct() {
	        $this->CI =& get_instance();

		$this->CI->config->load('ajar_forms');
		$this->CI->load->database();
		$this->CI->load->model('ajar_form/ajarform_model');
		$this->CI->load->helper('form');
	}

        public function generate_form( $form_id, $additional = NULL ) {
		$additional 		= 'class="ajarform"';
		$this->form_id 		= $form_id;
		
		$form_data 		= $this->CI->ajarform_model->get_form_details( $this->form_id );
		$this->form_elements 	= $this->_data_set( $form_data );

		$html_form = '';

		// open form
		$html_form .= form_open( $this->CI->config->item('ajarform_submission_url') .DIRECTORY_SEPARATOR. $this->form_id, $additional );
			
		// get fields
		foreach( $this->form_elements as $key => $val ) {
			switch( $val['element_type'] ) {
				case 1: 
					$val['type']  = 'text';
					$html_form .= $this->_set_input( $val );
					break;

				case 2: 
					$val['type']  = 'password';
					$html_form .= $this->_set_input( $val );
					break;

				case 3: /*
					$html_form .= form_label( $val['placeholder'], $val['name']);
					foreach($val['options'] as $subkey => $subval) {
						$subdata = array(
							'name' 	=> $val['name'],
							'id'	=> $val['name'].'-'.$subval['mval_id'],
							'value' => $subval['mval_key'],
							'checked' => FALSE
							);
						$html_form .= form_radio( $subdata );
						if($subval['mval_value'] == 'Other') {
							$subopt = array(
									'name' 	=> $val['name'],
									'id'	=> $val['name'],
									'value' => $subval['mval_key'],
									'checked' => FALSE
							);
							$html_form .= form_label( form_input( $subopt ), $val['name'].'-'.$subval['mval_id']); 
						} else {
							$html_form .= form_label( $subval['mval_value'], $val['name'].'-'.$subval['mval_id']);
						}
					}
					*/
					$html_form .= $this->_set_radio( $val );
					break;

				case 4: 
					$val['type']  = 'email';
					$html_form .= $this->_set_input( $val );
					break;

				case 8: 
					$val['type']  = 'email';
					$html_form .= $this->_set_input( $val );
					break;
				
				default:
					break;
					
			}
		}

		// Submit Button
		$html_form .= '<div class="action-botton row">'.form_submit( 'save', 'Submit', 'class="btn btn-primary col-sm-12 col-md-6"' ).'</div>';
		

		// close form
		$html_form .= '</form>';

		return $html_form;
        }

	private function _data_set( $data = array() ) {
		$output = array();
		
		if ( is_array($data) && sizeof($data)>0 ) {
			foreach ( $data as $key => $val ) {

				if( array_key_exists('meta_type', $val) ) {
					$output[$key]['element_type'] 	= $val['meta_type'];
				}

				if( array_key_exists('meta_id', $val) ) {
					$output[$key]['id'] 		= $val['meta_name'].'-'.$val['meta_id'];
				}
				
				if( array_key_exists('meta_name', $val) ) {
					$output[$key]['name'] 		= $val['meta_name'].'-'.$val['meta_id'];
				}
				
				if( array_key_exists('meta_disp_name', $val) ) {
					$output[$key]['placeholder'] 	= $val['meta_disp_name'];
				}
			
				if( array_key_exists('meta_icon', $val) ) {
					$output[$key]['icon'] 	= $val['meta_icon'];
				}

				if( array_key_exists('meta_class', $val) ) {
					$output[$key]['class'] 		= $val['meta_class'];
				}

				if( array_key_exists('mandatory', $val) ) {
					$output[$key]['required'] 	= $val['mandatory'];
				}
				
				if( array_key_exists('options', $val) ) {
					$output[$key]['options'] 	= $val['options'];
				}	
			}
		}

		return $output;
	}

	private function _set_input( $data ) {
		$data['class'] = 'form-control';
		$_html_icon = ((null !== $data['icon']) ? '<img src="'.$data['icon'].'" width="19px"> ' : '');
		$_html_required = (($data['required']==1) ? ' <span class="field-required">*</span>' : '');

		$_html = '';
		$_html .= '<div class="form-group">';
		$_html .= form_label( '<span class="form-icon">' . $_html_icon . '</span> ' . $data['placeholder'] . $_html_required, $data['name']);
		$_html .= form_input( $data ); 
		$_html .= '</div>';

		return $_html;
	}

	// generate checkbox
	private function _set_radio( $data ) {
		$_html_icon = ((null !== $data['icon']) ? '<img src="'.$data['icon'].'" width="19px"> ' : '');
		$_html_required = (($data['required']==1) ? ' <span class="field-required">*</span>' : '');

		$_html = '';
		$_html .= '<div class="form-group">';
		$_html .= form_label( '<span class="form-icon">'. $_html_icon . '</span> ' . $data['placeholder'] . $_html_required, $data['name']);

		foreach($data['options'] as $subkey => $subval) {
			$subdata = array(
				'name' 	=> $data['name'],
				'id'	=> $data['name'].'-'.$subval['mval_id'],
				'value' => $subval['mval_key'],
				'class' => 'form-check-input',
				'checked' => FALSE
				);
			//$_html .= '<div class="form-check">';
			$_label = $subval['mval_key'] . form_radio( $subdata ) .'<span class="checkmark"></span>';
			/* Option other
			if($subval['mval_key'] == 'Other') {
				$subopt = array(
						'type'	=> 'text',
						'name' 	=> $data['name'],
						'id'	=> $data['name'],
						'placeholder' => $subval['mval_key'],
						'class' => 'form-control'
				);
				//$_html .= '-- '.form_input( $subopt ); 
				$_html .= form_label( form_input( $subopt ), $data['name'].'-'.$subval['mval_id']); 
			} else {
				$_html .= form_label( $subval['mval_value'], $data['name'].'-'.$subval['mval_id']);
			}
			*/
			$_html .= form_label( $_label, $data['name'].'-'.$subval['mval_id'], 'class="radio-container"');
			//$_html .= '</div>';
		}
		$_html .= '</div>';

		return $_html;
		
	}
}
