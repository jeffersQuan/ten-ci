<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chengjiaoliang extends CI_Controller {
	public function lowest_30()
	{
		$this->load->model('cheng_jiao_liang_model');
        $data['stock_list'] = $this->cheng_jiao_liang_model->get_lowest_30();
        $this->load->view('chengjiaoliang/chengjiaoliang', $data);
	}

    public function pulse_7()
    {
        $this->load->model('cheng_jiao_liang_model');
        $data['stock_list'] = $this->cheng_jiao_liang_model->get_pulse_7();
        $this->load->view('chengjiaoliang/chengjiaoliang', $data);
    }

    public function pulse_15()
    {
        $this->load->model('cheng_jiao_liang_model');
        $data['stock_list'] = $this->cheng_jiao_liang_model->get_pulse_15();
        $this->load->view('chengjiaoliang/chengjiaoliang', $data);
    }

    public function pulse_30()
    {
        $this->load->model('cheng_jiao_liang_model');
        $data['stock_list'] = $this->cheng_jiao_liang_model->get_pulse_30();
        $this->load->view('chengjiaoliang/chengjiaoliang', $data);
    }
}
