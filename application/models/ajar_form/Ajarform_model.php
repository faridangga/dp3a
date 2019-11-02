<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Ajarform_model extends CI_Model {

	public $form_id;
        public $form_details;

	public function set_form( $form_id ) {
		$this->form_id = $form_id;
	}

	public function get_form_description( $form_id = NULL ) {

		if (!is_null($form_id)) $this->set_form( $form_id );

		$query = $this->db->get_where('forms', array( 'frm_id' => $this->form_id, 'frm_status' => 1 ));
		return $query->row_array();
	}

	public function get_form_details( $form_id = NULL ) {

		if (!is_null($form_id)) $this->set_form( $form_id );

		$elements = array();

		$this->form_id = $form_id;

		$_elements = $this->_get_form_elements( $this->form_id );

		foreach($_elements as $key => $val) {
			if( in_array($val['meta_type'], array(3, 4, 14) )) {
				$val['options'] = $this->_get_element_options( $val['meta_id'] );
			}

			$elements[$key] = $val;
		}

		return $elements;
	}

	public function get_form_record( $frm_id, $data_id ) {

		$query = $this->db->join('form_metadata meta', 'meta.meta_id = rec.meta_id')->get_where('form_records rec', array( 'rec.data_id' => $data_id, 'rec.frm_id' => $frm_id ));
		return $query->result_array();
	}

	public function save_record( $data ) {
		$this->db->insert('form_records', $data);

		return $this->db->affected_rows();
	}

	public function save_data( $data ) {
		$this->db->insert('form_data', $data);

		return $this->db->affected_rows();
	}

	public function check_existing_registrant( $field_key, $field_value = NULL ) {
		if( is_array($field_key) ) {
			$query = $this->db->get_where('form_records', $field_key);
		} else {
			$query = $this->db->get('form_records')->where($field_key, $field_value);
		}

		$_result = $this->db->affected_rows();

		return ( $_result > 0 )? TRUE : FALSE;
	}

        private function _get_form_elements( $form_id = NULL ) {
		if(!is_null( $form_id )) {
			$this->form_id = $form_id;
		}

                $query = $this->db->order_by('sort', 'ASC')->get_where('form_metadata', array('frm_id' => $this->form_id));

                return $query->result_array();
        }


        private function _get_element_options( $meta_id ) {
                $query = $this->db->order_by('sort', 'ASC')->get_where('form_metavalue', array('meta_id' => $meta_id));

                return $query->result_array();
        }
}
