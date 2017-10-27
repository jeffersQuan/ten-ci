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

    private function backup_mysql() {
        // Load the DB utility class
        $this->load->dbutil();

        // Backup your entire database and assign it to a variable
        $backup = $this->dbutil->backup();

        // Load the file helper and write the file to your server
        $this->load->helper('file');
        log_message('info','backup mysql');
        write_file('/var/www/ten-ci/www/back/mysql_backup.gz', $backup);
    }

    public function check_update_data_status ()
    {
        $this->load->model('stock_list_model');
        $result = $this->stock_list_model->get_status();
        if ($result->gengxinshuju == 0) {
            echo 'ok';
            $this->backup_mysql();
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
        $start = isset($_GET['start'])? $_GET['start'] : '';
        $end = isset($_GET['end'])? $_GET['end'] : '';

        if (!$start || !$end) {
            exit('缺少参数');
        }

        try {
            $this->load->model('cheng_jiao_e_model');
            $this->load->model('cheng_jiao_liang_model');
            $this->load->model('huan_shou_model');
            $this->load->model('stock_list_model');
            $this->load->model('zhang_fu_model');
            $this->load->model('zui_xin_model');

            $this->stock_list_model->set_gengxinshuju(1);
            log_message('info','start update data!');
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

            for (; $index < $max; $index++) {
                $index = floor($index);
                $stockCode = $stocks[$index]['code'];
                $dataArr = $this->requestStockData($stockCode, $start, $end);
		    
                if (!$dataArr) {
                    $this->set_update_progress(($index + 1) / $max);
                    continue;
                }

                $this->stock_list_model->update_data($dataArr);
                $this->zui_xin_model->update_data($dataArr);
                $this->zhang_fu_model->update_data($dataArr);
                $this->huan_shou_model->update_data($dataArr);
                $this->cheng_jiao_e_model->update_data($dataArr);
                $this->cheng_jiao_liang_model->update_data($dataArr);

                $this->set_update_progress(($index + 1) / $max);
            }
            $this->stock_list_model->set_gengxinshuju(0);
	        $this->set_update_progress(0);
	        $this->backup_mysql();
            log_message('info','update_data success!');
        } catch (Error $e) {
            log_message('info','update_data error!' . var_export($e, true));
        } catch (Exception $e) {
            log_message('info','update_data exception!' . var_export($e, true));
        }
    }

    public function back_up ()
    {
        $this->load->model('cheng_jiao_e_model');
        $this->load->model('cheng_jiao_liang_model');
        $this->load->model('huan_shou_model');
        $this->load->model('stock_list_model');
        $this->load->model('zhang_fu_model');
        $this->load->model('zui_xin_model');

        $this->stock_list_model->set_beifen(1);
        $this->stock_list_model->back_up();
        $this->zui_xin_model->back_up();
        $this->zhang_fu_model->back_up();
        $this->huan_shou_model->back_up();
        $this->cheng_jiao_e_model->back_up();
        $this->cheng_jiao_liang_model->back_up();
        $this->stock_list_model->set_beifen(0);
        echo 0;
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

            array_push($dataArr, $data);
        }

        return $dataArr;
    }

    private function set_update_progress ($progress) {
        $this->load->model('stock_list_model');

        $this->stock_list_model->set_update_progress($progress);
    }
}
