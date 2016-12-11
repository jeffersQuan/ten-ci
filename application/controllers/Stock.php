<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \JJG\Request as Request;

class Stock extends CI_Controller {
	public function index()
	{
		$this->load->view('stock');
	}

    public function check_server_status ()
    {
        echo 'ok';
    }

    public function check_update_stock_status ()
    {
        $this->load->model('stock_list_model');
        $result = $this->stock_list_model->get_status();
        if ($result->gengxinliebiao == 0) {
            echo 'ok';
        } else {
            echo 'processing';
        }
    }

    public function check_update_data_status ()
    {
        $this->load->model('stock_list_model');
        $result = $this->stock_list_model->get_status();
        if ($result->gengxinshuju == 0) {
            echo 'ok';
        } else {
            echo 'processing';
        }
    }

    public function check_backup_status ()
    {
        $this->load->model('stock_list_model');
        $result = $this->stock_list_model->get_status();
        if ($result->beifen == 0) {
            echo 'ok';
        } else {
            echo 'processing';
        }
    }

    public function update_stock_data ()
    {
        $this->load->model('cheng_jiao_e_model');
        $this->load->model('cheng_jiao_liang_model');
        $this->load->model('huan_shou_model');
        $this->load->model('liu_tong_model');
        $this->load->model('stock_list_model');
        $this->load->model('zhang_fu_model');
        $this->load->model('zui_xin_model');

        $this->stock_list_model->set_gengxinshuju(1);
        $stocks = $this->stock_list_model->get_stock_list_all();
        $index = 0;
        $max = count($stocks);

        include 'JJG/Request.php';

        for ($index; $index < $max; $index++) {
            $stockCode = $stocks[$index]['code'];
            $this->requestStockData($stockCode);
            $dataArr = $this->requestStockData($stockCode);

            $this->stock_list_model->update_data($dataArr);
            $this->zui_xin_model->update_data($dataArr);
            $this->zhang_fu_model->update_data($dataArr);
            $this->liu_tong_model->update_data($dataArr);
            $this->huan_shou_model->update_data($dataArr);
            $this->cheng_jiao_e_model->update_data($dataArr);
            $this->cheng_jiao_liang_model->update_data($dataArr);
            error_log('update_data: ' . $stockCode);
            sleep(0.1);
        }
        $this->stock_list_model->set_gengxinshuju(0);
        error_log('update_data success!');
    }

    public function back_up ()
    {
        $this->load->model('cheng_jiao_e_model');
        $this->load->model('cheng_jiao_liang_model');
        $this->load->model('huan_shou_model');
        $this->load->model('liu_tong_model');
        $this->load->model('stock_list_model');
        $this->load->model('zhang_fu_model');
        $this->load->model('zui_xin_model');

        $this->stock_list_model->set_beifen(1);
        $this->stock_list_model->back_up();
        $this->zui_xin_model->back_up();
        $this->zhang_fu_model->back_up();
        $this->liu_tong_model->back_up();
        $this->huan_shou_model->back_up();
        $this->cheng_jiao_e_model->back_up();
        $this->cheng_jiao_liang_model->back_up();
        $this->stock_list_model->set_beifen(0);
        echo 0;
    }

    private function requestStockData($stockCode)
    {
        try {
            $request = new Request('http://qt.gtimg.cn/q=' . $stockCode);
            $request->setContentType('application/x-javascript; charset=GBK');
            $request->execute();
            $response = $request->getResponse();
        } catch (Error $e) {
            error_log('Request error!');
        } catch (Exception $e) {
            error_log('Request exception!');
        }

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
}
