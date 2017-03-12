<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Small extends CI_Controller {
	public function index()
	{
		$this->load->model('stock_list_model');
        	$data['stock_list'] = $this->stock_list_model->get_stock_small();
		
        	$this->load->view('stock/common', $data);
	}
}
