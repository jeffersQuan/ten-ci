<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Selected extends CI_Controller {
	public function index()
	{
		$this->load->model('stock_list_model');
        $data['stock_list'] = $this->stock_list_model->selected();
        $this->load->view('diefu/diefu', $data);
	}
}
