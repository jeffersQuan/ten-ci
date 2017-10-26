<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \JJG\Request as Request;

class Lists extends CI_Controller {
	public function index()
	{
		$page_index = 0;

		if (isset($param["page_index"])) {
		     $page_index = $param["page_index"];
		}

		$this->load->model('stock_list_model');
        $data['stock_list'] = $this->stock_list_model->get_stock_list($page_index);
        $this->load->view('lists', $data);
	}

    public function init_stock()
    {
        $index = 1;
        $max = 604500;

        $params = $_GET;

        if (!$params.isset($start) || !$params.isset($end)) {
            exit('缺少参数');
        } else {
            exit(var_export($params.isset($start), true));
        }

        $this->load->model('stock_list_model');
        $result = $this->stock_list_model->get_status();
        $progress = $result->init_progress;
        if ($progress == 1) {
            $progress = 0;
            $index = 0;
        } else if ($progress > 0) {
            $index = $progress * $max - 3;
            if ($index < 0) {
                $index = 0;
            }
        }

        include 'JJG/Request.php';

        $this->load->model('stock_list_model');

        $this->stock_list_model->set_gengxinliebiao(1);
        log_message('info','start init data!');

        for (; $index < $max; $index++) {
            $stockCode = $index;
            $dataArr = $this->requestStockData($stockCode, $params['start'], $params['end']);
            log_message('info','init: ' . var_export($dataArr, true));

            $this->stock_list_model->update_stock_list($dataArr);
            log_message('info','init_stock: ' . $stockCode);
            sleep(0.1);
            $this->set_init_progress(($index + 1) / $max);
        }

        $this->stock_list_model->set_gengxinliebiao(0);

    }

    private function requestStockData($stockCode, $start, $end)
    {
        $url = 'http://q.stock.sohu.com/hisHq?code=';
        $request = new Request($url . $stockCode . '&start=' . $start . '&end=' . $end);
        $request->setContentType('application/json; charset=utf8');
        $request->execute();
        $response = $request->getResponse();

        if ($response['status'] != 0) {
            return array();
        }

        $res_data = $response['hq'];
        $dataArr = array();

        for ($i = 0; $i < count($res_data); $i++) {
            $s_data = $res_data[$i];
            $data['code'] = $stockCode;
            $data['kaipan'] = $s_data[1];
            $data['zuixin'] = $s_data[2];
            $data['zhangfu'] = $s_data[4];
            $data['chengjiaoliang'] = $s_data[7];
            $data['chengjiaoe'] = $s_data[8];
            $data['huanshou'] = $s_data[9];

            array_unshift($dataArr, $data);
        }

        return $dataArr;
    }

    private function set_init_progress ($progress) {
        $this->load->model('stock_list_model');
        $this->stock_list_model->set_init_progress($progress);
    }
}
