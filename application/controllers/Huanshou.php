<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Huanshou extends CI_Controller {
	public function index()
	{
		$this->load->model('huan_shou_model');
        $data['stock_list'] = $this->huan_shou_model->index();
        $this->load->view('huanshou/huanshou', $data);
	}
}
