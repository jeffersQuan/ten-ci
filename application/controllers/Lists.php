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
        $max = 605000;

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
        error_log('start init data!');

        for ($index; $index < $max; $index++) {
            if ($index < 3000) {
                $stockCode = $this->getStockCode('sz', $index);
                $dataArr = $this->requestStockData($stockCode);
                error_log('init: ' . var_export($dataArr, true));

                $this->stock_list_model->update_stock_list($dataArr);
                error_log('init_stock: ' . $stockCode);
                sleep(0.1);
            } else if ($index >= 300000 && $index <= 301000) {
                $stockCode = $this->getStockCode('sz', $index);
                $dataArr = $this->requestStockData($stockCode);
                error_log('init: ' . var_export($dataArr, true));

                $this->stock_list_model->update_stock_list($dataArr);
                error_log('init_stock: ' . $stockCode);
                sleep(0.1);
            } else if ($index >= 600000) {
                $stockCode = $this->getStockCode('sh', $index);
                $dataArr = $this->requestStockData($stockCode);
                error_log('init: ' . var_export($dataArr, true));

                $this->stock_list_model->update_stock_list($dataArr);
                error_log('init_stock: ' . $stockCode);
                sleep(0.1);
            } else {
                //没有对应的代码
            }
            $this->set_init_progress(($index + 1) / $max);
        }

        $this->stock_list_model->set_gengxinliebiao(0);

    }

    private function getStockCode($type = 'sz', $index)
    {
        $code = '';
        if ($type == 'sz') {
            if ($index > 100000) {
                $code = 'sz' . $index;
            } else {
                $code = $code . $index;
                while (strlen($code) < 6) {
                    $code = '0' . $code;
                }
                $code = 'sz' . $code;
            }
        } else if ($type == 'sh') {
            $code = 'sh' . $index;
        }
        return $code;
    }

    private function requestStockData($stockCode)
    {
        $request = new Request('http://qt.gtimg.cn/q=' . $stockCode);
        $request->setContentType('application/x-javascript; charset=GBK');
        $request->execute();
        $response = $request->getResponse();
        $resArr = explode('~', $response);

        if (count($resArr) < 2) {
            return array();
        }

        $dataArr['name'] = iconv('GBK', 'UTF-8', $resArr[1]);
        $dataArr['code'] = $stockCode;
        $dataArr['zuixin'] = $resArr[3];
        $dataArr['kaipan'] = $resArr[5];
        $dataArr['chengjiaoliang'] = $resArr[6];
        $dataArr['zhangfu'] = $resArr[32];
        $dataArr['zuigao'] = $resArr[41];
        $dataArr['zuidi'] = $resArr[42];
        $dataArr['liutong'] = $resArr[44];
        $dataArr['chengjiaoe'] = $resArr[37];
        $dataArr['huanshou'] = $resArr[38];
        $dataArr['shiying'] = $resArr[39];
        $dataArr['shijing'] = $resArr[46];

        if (!$dataArr['zuixin']) {
            $dataArr['zuixin'] = 0;
        }

        if (!$dataArr['kaipan']) {
            $dataArr['kaipan'] = 0;
        }

        if (!$dataArr['chengjiaoliang']) {
            $dataArr['chengjiaoliang'] = 0;
        }

        if (!$dataArr['zhangfu']) {
            $dataArr['zhangfu'] = 0;
        }

        if (!$dataArr['zuigao']) {
            $dataArr['zuigao'] = 0;
        }

        if (!$dataArr['zuidi']) {
            $dataArr['zuidi'] = 0;
        }

        if (!$dataArr['liutong']) {
            $dataArr['liutong'] = 0;
        }

        if (!$dataArr['chengjiaoe']) {
            $dataArr['chengjiaoe'] = 0;
        }

        if (!$dataArr['huanshou']) {
            $dataArr['huanshou'] = 0;
        }

        if (!$dataArr['shiying']) {
            $dataArr['shiying'] = 0;
        }

        if (!$dataArr['shijing']) {
            $dataArr['shijing'] = 0;
        }

        return $dataArr;
    }

    private function set_init_progress ($progress) {
        $this->load->model('stock_list_model');
        $this->stock_list_model->set_init_progress($progress);
    }
}
