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

    public function update_stock_list ($arr) {
        $s_data = $arr[0];
        $code = $s_data['code'];
        $kaipan = $s_data['kaipan'];
        $zuixin = $s_data['zuixin'];
        $zhangfu = $s_data['zhangfu'];
        $chengjiaoe = $s_data['chengjiaoe'];
        $chengjiaoliang = $s_data['chengjiaoliang'];
        $huanshou = $s_data['huanshou'];
        $query = $this->db->query('select * from ten_stock where code = "' . $code . '"');
        $result = $query->row_array();

        if (count($result) < 1) {
            $this->db->insert('ten_stock', $s_data);
        } else {
            $this->db->query("update ten_stock set kaipan=$kaipan, zuixin=$zuixin, zhangfu=$zhangfu, chengjiaoe=$chengjiaoe, 
                    chengjiaoliang=$chengjiaoliang, huanshou=$huanshou where code=$code");
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

    public function set_send_email($status=0)
    {
        $this->db->query('update ten_status set send_email="' . $status . '"');
    }

    public function get_status()
    {
        $query = $this->db->query('select * from ten_status limit 1');
        return $query->row();
    }

    public function update_data($arr)
    {
        $s_data = $arr[0];
        $code = $s_data['code'];
        $kaipan = $s_data['kaipan'];
        $zuixin = $s_data['zuixin'];
        $zhangfu = $s_data['zhangfu'];
        $chengjiaoe = $s_data['chengjiaoe'];
        $chengjiaoliang = $s_data['chengjiaoliang'];
        $huanshou = $s_data['huanshou'];
        $query = $this->db->query('select * from ten_stock where code = "' . $code . '"');
        $result = $query->row_array();

        if (count($result) < 1) {
            $this->db->insert('ten_stock', $s_data);
        } else {
            $this->db->query("update ten_stock set kaipan=$kaipan, zuixin=$zuixin, zhangfu=$zhangfu, chengjiaoe=$chengjiaoe, 
                    chengjiaoliang=$chengjiaoliang, huanshou=$huanshou where code=$code");
        }
    }

    public function back_up ()
    {
        $this->db->query('update ten_stock set zuixin=0,zhangfu=0,chengjiaoliang=0,chengjiaoe=0,kaipan=0,huanshou=0');
    }
}
?>
