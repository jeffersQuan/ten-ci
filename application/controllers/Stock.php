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
            echo $result->init_progress;
        }
    }

    public function check_update_data_status ()
    {
        $this->load->model('stock_list_model');
        $result = $this->stock_list_model->get_status();
        if ($result->gengxinshuju == 0) {
            echo 'ok';
        } else {
            echo $result->update_progress;
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

    public function tui_jian ()
    {
        $this->load->model('stock_list_model');
        $data['stock_list'] = $this->stock_list_model->tui_jian();

        $this->load->view('stock/tui_jian', $data);
    }

    public function update_stock_data ()
    {
        try {
            $this->load->model('cheng_jiao_e_model');
            $this->load->model('cheng_jiao_liang_model');
            $this->load->model('huan_shou_model');
            $this->load->model('liu_tong_model');
            $this->load->model('stock_list_model');
            $this->load->model('zhang_fu_model');
            $this->load->model('zui_xin_model');

            $this->stock_list_model->set_gengxinshuju(1);
            error_log('start update data!');
            $stocks = $this->stock_list_model->get_stock_list_all();
            $max = count($stocks);
            $index=0;
            $result = $this->stock_list_model->get_status();
            $progress = $result->update_progress;

            if ($progress > 0) {
                $index = $progress * $max - 3;

                if ($index < 0) {
                    $index = 0;
                }
            }


            include 'JJG/Request.php';

            for ($index; $index < $max; $index++) {
                error_log('-------');
                $stockCode = $stocks[$index]['code'];
                $dataArr = $this->requestStockData($stockCode);
                error_log('stock_data: ' . var_export($dataArr, true));

                $this->stock_list_model->update_data($dataArr);
                $this->zui_xin_model->update_data($dataArr);
                $this->zhang_fu_model->update_data($dataArr);
                $this->liu_tong_model->update_data($dataArr);
                $this->huan_shou_model->update_data($dataArr);
                $this->cheng_jiao_e_model->update_data($dataArr);
                $this->cheng_jiao_liang_model->update_data($dataArr);
                error_log('update_data: ' . $stockCode);
                $this->set_update_progress(($index + 1) / $max);
                sleep(0.1);
            }
            $this->stock_list_model->set_gengxinshuju(0);
	    $this->set_update_progress(0);
            error_log('update_data success!');
        } catch (Error $e) {
            error_log('update_data error!' . var_export($e, true));
        } catch (Exception $e) {
            error_log('update_data exception!' . var_export($e, true));
        }
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

    public function get_stock_selected ()
    {
        $this->load->model('stock_list_model');
        $data['stock_list'] = $this->stock_list_model->get_stock_selected();
        $this->load->view('lists', $data);
    }

    public function add_stock_selected ($code)
    {
        if (!$code) {
            return;
        }
        $this->load->model('stock_list_model');
        $data['stock_list'] = $this->stock_list_model->add_stock_selected($code);
        echo 'success';
    }

    public function remove_stock_selected ($code)
    {
        if (!$code) {
            return;
        }
        $this->load->model('stock_list_model');
        $this->stock_list_model->remove_stock_selected($code);
        echo 'success';
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

    private function set_update_progress ($progress) {
        $this->load->model('stock_list_model');

        $this->stock_list_model->set_update_progress($progress);
    }
}
