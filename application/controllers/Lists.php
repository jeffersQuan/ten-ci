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
        log_message('info','enter init data!');
        $index = 1;
        $max = 604500;
//        $max = 2;

        $start = isset($_GET['start'])? $_GET['start'] : '';
        $end = isset($_GET['end'])? $_GET['end'] : '';

        if (!$start || !$end) {
            exit('缺少参数');
        }

        $this->load->model('stock_list_model');
        $result = $this->stock_list_model->get_status();
        $progress = $result->init_progress;
        if ($progress == 1) {
            $progress = 0;
            $index = 1;
        } else if ($progress > 0) {
            $index = $progress * $max - 3;
            if ($index < 0) {
                $index = 1;
            }
        } else {
            $index = 1;
        }

        include 'JJG/Request.php';

        $this->load->model('stock_list_model');

        $this->stock_list_model->set_gengxinliebiao(1);
        log_message('info','start init data!');

        for (; $index < $max; $index++) {
            $index = floor($index);

            if (($index < 3000) || ($index >= 300000 && $index <= 301000) || ($index >= 600000)) {
                $stockCode = $this->getStockCode($index);
                log_message('info','init code: ' . $stockCode . ', start:' . $start . ' , end:' . $end);
                $dataArr = $this->requestStockData($stockCode, $start, $end);

                if (!$dataArr) {
                    sleep(0.1);
                    $this->set_init_progress(($index + 1) / $max);
                    continue;
                }

                $this->stock_list_model->update_stock_list($dataArr);
                sleep(0.1);
                $this->set_init_progress(($index + 1) / $max);
            }
        }

        $this->stock_list_model->set_gengxinliebiao(0);

    }

    private function getStockCode($index)
    {
        $code = '';

        if ($index > 100000) {
            $code = '' . $index;
        } else {
            $code = $code . $index;
            while (strlen($code) < 6) {
                $code = '0' . $code;
            }
        }

        return 'cn_' . $code;
    }


    private function requestStockData($stockCode, $start, $end)
    {
        $url = 'http://q.stock.sohu.com/hisHq?code=';
        $request = new Request($url . $stockCode . '&start=' . $start . '&end=' . $end);
        $request->setContentType('application/json; charset=utf8');
        $request->execute();
        $response = $request->getResponse();

        log_message('info', var_export($response, true));

        if (!$response) {
            return null;
        }

        if (is_string($response)) {
            $response = json_decode($response);
        }

        //空对象
        if (!count((array)$response)) {
            return null;
        }

        //数组
        if (is_array($response)) {
            $response = $response[0];
        }

        if (isset($response->status) && ($response->status!= 0)) {
            return null;
        }

        $res_data = $response->hq;
        $dataArr = array();

        for ($i = 0; $i < count($res_data); $i++) {
            $s_data = $res_data[$i];
            $data['code'] = $stockCode;
            $data['kaipan'] = $s_data[1];
            $data['zuixin'] = $s_data[2];
            $data['zhangfu'] = str_replace('%', '', $s_data[4]);
            $data['chengjiaoliang'] = $s_data[7];
            $data['chengjiaoe'] = $s_data[8];
            $data['huanshou'] = str_replace('%', '', $s_data[9]);

            array_unshift($dataArr, $data);
        }

        return $dataArr;
    }

    private function set_init_progress ($progress) {
        $this->load->model('stock_list_model');
        $this->stock_list_model->set_init_progress($progress);
    }
}
