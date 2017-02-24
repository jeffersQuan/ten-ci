<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Selected extends CI_Controller {
	public function index()
	{
		$this->load->model('stock_list_model');
        	$data['stock_list'] = $this->stock_list_model->get_stock_selected();
		
		for ($index = 0, $max = count($data['stock_list']); $index < $max; $index++) {
		    $data['stock_list'][$index]['selected'] = true;
		}
		
        	$this->load->view('chengjiaoliang/chengjiaoliang', $data);
	}
}
