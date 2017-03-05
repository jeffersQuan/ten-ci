<?php
class Stock_list_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_stock_list_all()
    {
        $query = $this->db->query('select * from ten_stock');
        return $query->result_array();
    }

    public function get_stock_list($page_index=0)
    {
        $query = $this->db->query('select * from ten_stock limit 20 offset ' . $page_index * 20);
        return $query->result_array();
    }

    public function tui_jian ()
    {
        $query = $this->db->query('select tss.code, ts.name from ten_stock_small as tss left join ten_stock as ts on tss.code=ts.code '
        . 'left join ten_zhangfu_leiji as tzl on tzl.code=tss.code left join ten_zhangfu as tz on tz.code=tss.code '
        . ' where (tzl.d2<1.2 AND tzl.d2>-0.5) and ts.zhangfu>=0 and tz.d1<1.5 and tz.d1>-1 and tz.d2<1.5 and tz.d2>-1');
        return $query->result_array();
    }

    public function get_stock_selected()
    {
        $query = $this->db->query('select tss.code, ts.name from ten_stock_selected as tss left join ten_stock as ts on tss.code=ts.code');
        return $query->result_array();
    }

    public function add_stock_selected($code)
    {
        $stock['code'] = $code;
//        $stock['add_time'] = time();
        return $this->db->insert('ten_stock_selected', $stock);
    }

    public function remove_stock_selected($code)
    {
        $query = $this->db->query("delete from ten_stock_selected where code='$code'");
    }

    public function update_stock_list ($arr) {
        if (count($arr) > 0) {
            $query = $this->db->query('select * from ten_stock where code = "' . $arr['code'] . '"');
            $result = $query->row_array();
            $stock['name'] = $arr['name'];
            $stock['code'] = $arr['code'];
            $stock['zuixin'] = $arr['zuixin'];
            $stock['kaipan'] = $arr['kaipan'];
            $stock['chengjiaoliang'] = $arr['chengjiaoliang'];
            $stock['zhangfu'] = $arr['zhangfu'];
            $stock['zuigao'] = $arr['zuigao'];
            $stock['zuidi'] = $arr['zuidi'];
            $stock['liutong'] = $arr['liutong'];
            $stock['chengjiaoe'] = $arr['chengjiaoe'];
            $stock['huanshou'] = $arr['huanshou'];
            $stock['shiying'] = $arr['shiying'];
            $stock['shijing'] = $arr['shijing'];

            if (!isset($result)) {
                $this->db->insert('ten_stock', $stock);
            } else {
                $this->db->query('update ten_stock set name="' . $stock['name'] . '", zuixin=' . $stock['zuixin']
                    . ', kaipan=' . $stock['kaipan'] . ', chengjiaoliang=' . $stock['chengjiaoliang'] . ', zhangfu=' . $stock['zhangfu']
                    . ', zuigao=' . $stock['zuigao'] . ', zuidi=' . $stock['zuidi'] . ', liutong=' . $stock['liutong']
                    . ', chengjiaoe=' . $stock['chengjiaoe'] . ', huanshou=' . $stock['huanshou'] . ', shiying=' . $stock['shiying']
                    . ', shijing=' . $stock['shijing'] . ' where code="' . $stock['code'] . '"');
            }
        }
    }

    public function set_gengxinliebiao($status=0)
    {
        $this->db->query('update ten_status set gengxinliebiao="' . $status . '"');
    }

    public function set_gengxinshuju($status=0)
    {
        $this->db->query('update ten_status set gengxinshuju="' . $status . '"');
    }

    public function set_beifen($status=0)
    {
        $this->db->query('update ten_status set beifen="' . $status . '"');
    }

    public function set_update_progress($progress=0)
    {
        $this->db->query('update ten_status set update_progress="' . $progress . '"');
    }

    public function set_init_progress($progress=0)
    {
        $this->db->query('update ten_status set init_progress="' . $progress . '"');
    }

    public function get_status()
    {
        $query = $this->db->query('select * from ten_status limit 1');
        return $query->row();
    }

    public function update_data($arr)
    {
        $code = $arr['code'];
        $query = $this->db->query('select * from ten_stock where code = "' . $code . '"');
        $result = $query->row_array();

        $stock['name'] = $arr['name'];
        $stock['code'] = $arr['code'];
        $stock['zuixin'] = $arr['zuixin'];
        $stock['kaipan'] = $arr['kaipan'];
        $stock['chengjiaoliang'] = $arr['chengjiaoliang'];
        $stock['zhangfu'] = $arr['zhangfu'];
        $stock['zuigao'] = $arr['zuigao'];
        $stock['zuidi'] = $arr['zuidi'];
        $stock['liutong'] = $arr['liutong'];
        $stock['chengjiaoe'] = $arr['chengjiaoe'];
        $stock['huanshou'] = $arr['huanshou'];
        $stock['shiying'] = $arr['shiying'];
        $stock['shijing'] = $arr['shijing'];

        if (count($result) < 1) {
            $this->db->insert('ten_stock', $stock);
        } else {
            $this->db->query('update ten_stock set name="' . $stock['name'] . '", zuixin=' . $stock['zuixin']
                . ', kaipan=' . $stock['kaipan'] . ', chengjiaoliang=' . $stock['chengjiaoliang'] . ', zhangfu=' . $stock['zhangfu']
                . ', zuigao=' . $stock['zuigao'] . ', zuidi=' . $stock['zuidi'] . ', liutong=' . $stock['liutong']
                . ', chengjiaoe=' . $stock['chengjiaoe'] . ', huanshou=' . $stock['huanshou'] . ', shiying=' . $stock['shiying']
                . ', shijing=' . $stock['shijing'] . ' where code="' . $stock['code'] . '"');
        }
    }

    public function back_up ()
    {
        $this->db->query('update ten_stock set zuixin=0,zuigao=0,zuidi=0,zhangfu=0,chengjiaoliang=0,chengjiaoe=0'
            . ',kaipan=0,huanshou=0,shiying=0,shijing=0,liutong=0');
    }
}
?>
