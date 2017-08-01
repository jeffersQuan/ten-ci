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
        $query = $this->db->query("SELECT s.code, s.name, s.huanshou, s.chengjiaoe,
greatest(cjl.d5,cjl.d6,cjl.d7,cjl.d8,cjl.d9,cjl.d10,cjl.d11,cjl.d12,cjl.d13,cjl.d14,cjl.d15,cjl.d16,cjl.d17,cjl.d18,cjl.d19) / s.chengjiaoliang AS ratio_max
FROM stock.ten_stock AS s
  LEFT JOIN stock.ten_liutong AS lt ON s.code = lt.code
  LEFT JOIN stock.ten_chengjiaoliang AS cjl ON s.code = cjl.code
  LEFT JOIN stock.ten_huanshou AS hs ON s.code = hs.code
  LEFT JOIN stock.ten_zhangfu AS zf ON s.code = zf.code
  LEFT JOIN stock.ten_zhangfu_leiji AS zflj ON s.code = zflj.code
WHERE s.liutong > 45 AND s.liutong < 200 AND s.chengjiaoliang > 0 AND s.huanshou < 4
AND (s.name NOT LIKE '%S%' OR s.name NOT LIKE '%T%')
AND greatest(hs.d1,hs.d2,hs.d3,hs.d4,hs.d5) < 12
AND least(zf.d1,zf.d2,zf.d3,zf.d4,zf.d5,zf.d6,zf.d7) > -5
AND greatest(zf.d1,zf.d2,zf.d3,zf.d4,zf.d5,zf.d6,zf.d7) < 7
AND least(zflj.d1,zflj.d2,zflj.d3,zflj.d4,zflj.d5,zflj.d6,zflj.d7) > -2
AND zflj.d5 > 0
AND s.zhangfu < 2 AND s.zhangfu > -1
AND greatest(cjl.d5,cjl.d6,cjl.d7,cjl.d8,cjl.d9,cjl.d10,cjl.d11,cjl.d12,cjl.d13,cjl.d14,cjl.d15,cjl.d16,cjl.d17,cjl.d18,cjl.d19) / s.chengjiaoliang > 3
ORDER BY greatest(cjl.d5,cjl.d6,cjl.d7,cjl.d8,cjl.d9,cjl.d10,cjl.d11,cjl.d12,cjl.d13,cjl.d14,cjl.d15,cjl.d16,cjl.d17,cjl.d18,cjl.d19) / s.chengjiaoliang DESC");
        return $query->result_array();
    }

    public function get_stock_selected()
    {
        $query = $this->db->query('select tss.code, ts.name from ten_stock_selected as tss left join ten_stock as ts on tss.code=ts.code');
        return $query->result_array();
    }

    public function get_stock_small()
    {
        $query = $this->db->query('select tss.code, ts.name from ten_stock_small as tss left join ten_stock as ts on tss.code=ts.code order by ts.zhangfu desc');
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
