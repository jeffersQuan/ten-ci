<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diefu extends CI_Controller {
	public function index()
	{
		$this->load->model('zhang_fu_model');
        $data['stock_list'] = $this->zhang_fu_model->diefu();
        $this->load->view('diefu/diefu', $data);
	}
}
