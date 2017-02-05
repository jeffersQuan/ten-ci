<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chengjiaoliang extends CI_Controller {
	public function lowest_30()
	{
		$this->load->model('cheng_jiao_liang_model');
        $this->load->model('stock_list_model');
        $stock_list = $this->cheng_jiao_liang_model->get_lowest_30();
        $stock_selected = $this->stock_list_model->get_stock_selected();

        for ($index = 0, $max = count($stock_list); $index < $max; $index++) {
            $stock = $stock_list[$index];
            $stock_list[$index]['selected'] = 0;

            for ($index1 = 0, $max1 = count($stock_selected); $index1 < $max1; $index1++) {
                if ($stock_selected[$index1]['code'] == $stock['code']) {
                    $stock_list[$index]['selected'] = 1;
                    break;
                }
            }
        }

        $data['stock_list'] = $stock_list;
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
