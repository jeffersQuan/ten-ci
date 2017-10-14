<?php
class Huan_shou_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
        $this->liutong_max = 70;
        $this->zuixin_min = 3;
        $this->zuixin_max = 40;
        $this->zhangfu_max_5 = 0.08;
        $this->zhangfu_max_0 = 0.05;
        $this->shijing_max = 10;
        $this->huanshou_min = 5;
        $this->huanshou_max = 16;
    }

    public function index ()
    {
        $liutong_max = $this->liutong_max;
        $zuixin_min = $this->zuixin_min;
        $zuixin_max = $this->zuixin_max;
        $huanshou_min = $this->huanshou_min;
        $huanshou_max = $this->huanshou_max;
        $shijing_max = $this->shijing_max;
        $zhangfu_max_5 = $this->zhangfu_max_5;
        $zhangfu_max_0 = $this->zhangfu_max_0;
        $query = $this->db->query("SELECT s.name, s.code, s.zuixin
            FROM ten_stock AS s LEFT JOIN ten_zuixin AS z ON s.code = z.code
            LEFT JOIN ten_zhangfu_leiji AS zl ON s.code = zl.code
            WHERE s.name NOT LIKE '%S%' AND s.name NOT LIKE '%T%' AND s.name NOT LIKE '%银行%'
            AND s.liutong < $liutong_max AND s.zuixin >= $zuixin_min AND s.zuixin <= $zuixin_max 
            AND s.shijing <= $shijing_max AND s.huanshou >= $huanshou_min AND s.huanshou <= $huanshou_max
            AND s.zhangfu < $zhangfu_max_0 AND greatest(zl.d0, zl.d1, zl.d2, zl.d3, zl.d4, zl.d5, zl.d6, zl.d7, zl.d8, zl.d9, zl.d10, zl.d11, zl.d12, zl.d13, zl.d14) < 10
            AND greatest(zl.d0, zl.d1, zl.d2, zl.d3, zl.d4, zl.d5) < $zhangfu_max_5 
            ORDER BY s.liutong");

        return $query->result_array();
    }

    public function update_data($arr)
    {
        if (count($arr) > 0) {
            $code = $arr['code'];
            $huanshou = $arr['huanshou'];
            $query = $this->db->query('select * from ten_huanshou where code = "' . $code . '"');
            $query_result = $query->row_array();

            $stock = array(
                'code' => $code,
                'd0' => $huanshou,
                'd1' => 0,
                'd2' => 0,
                'd3' => 0,
                'd4' => 0,
                'd5' => 0,
                'd6' => 0,
                'd7' => 0,
                'd8' => 0,
                'd9' => 0,
                'd10' => 0,
                'd11' => 0,
                'd12' => 0,
                'd13' => 0,
                'd14' => 0,
                'd15' => 0,
                'd16' => 0,
                'd17' => 0,
                'd18' => 0,
                'd19' => 0,
                'd20' => 0,
                'd21' => 0,
                'd22' => 0,
                'd23' => 0,
                'd24' => 0,
                'd25' => 0,
                'd26' => 0,
                'd27' => 0,
                'd28' => 0,
                'd29' => 0,
                'd30' => 0,
                'd31' => 0,
                'd32' => 0,
                'd33' => 0,
                'd34' => 0,
                'd35' => 0,
                'd36' => 0,
                'd37' => 0,
                'd38' => 0,
                'd39' => 0,
                'd40' => 0,
                'd41' => 0,
                'd42' => 0,
                'd43' => 0,
                'd44' => 0,
                'd45' => 0,
                'd46' => 0,
                'd47' => 0,
                'd48' => 0,
                'd49' => 0,
                'd50' => 0,
                'd51' => 0,
                'd52' => 0,
                'd53' => 0,
                'd54' => 0,
                'd55' => 0,
                'd56' => 0,
                'd57' => 0,
                'd58' => 0,
                'd59' => 0,
                'd60' => 0
            );

            if (count($query_result) < 1) {
                $this->db->insert('ten_huanshou', $stock);
            } else {
                $this->db->query('update ten_huanshou set d0=' . $huanshou . ' where code="' . $code . '"');
            }
        }
    }

    public function back_up ()
    {
        $query = $this->db->query('select * from ten_huanshou');
        foreach ($query->result() as $row)
        {
            $code = $row->code;
            $d0 = $row->d0;
            $d1 = $row->d1;
            $d2 = $row->d2;
            $d3 = $row->d3;
            $d4 = $row->d4;
            $d5 = $row->d5;
            $d6 = $row->d6;
            $d7 = $row->d7;
            $d8 = $row->d8;
            $d9 = $row->d9;
            $d10 = $row->d10;
            $d11 = $row->d11;
            $d12 = $row->d12;
            $d13 = $row->d13;
            $d14 = $row->d14;
            $d15 = $row->d15;
            $d16 = $row->d16;
            $d17 = $row->d17;
            $d18 = $row->d18;
            $d19 = $row->d19;
            $d20 = $row->d20;
            $d21 = $row->d21;
            $d22 = $row->d22;
            $d23 = $row->d23;
            $d24 = $row->d24;
            $d25 = $row->d25;
            $d26 = $row->d26;
            $d27 = $row->d27;
            $d28 = $row->d28;
            $d29 = $row->d29;
            $d30 = $row->d30;
            $d31 = $row->d31;
            $d32 = $row->d32;
            $d33 = $row->d33;
            $d34 = $row->d34;
            $d35 = $row->d35;
            $d36 = $row->d36;
            $d37 = $row->d37;
            $d38 = $row->d38;
            $d39 = $row->d39;
            $d40 = $row->d40;
            $d41 = $row->d41;
            $d42 = $row->d42;
            $d43 = $row->d43;
            $d44 = $row->d44;
            $d45 = $row->d45;
            $d46 = $row->d46;
            $d47 = $row->d47;
            $d48 = $row->d48;
            $d49 = $row->d49;
            $d50 = $row->d50;
            $d51 = $row->d51;
            $d52 = $row->d52;
            $d53 = $row->d53;
            $d54 = $row->d54;
            $d55 = $row->d55;
            $d56 = $row->d56;
            $d57 = $row->d57;
            $d58 = $row->d58;
            $d59 = $row->d59;

            $this->db->query('update ten_huanshou set d0=0, d1=' . $d0 . ', d2=' . $d1 . ', d3=' . $d2
                . ', d4=' . $d3 . ', d5=' . $d4 . ', d6=' . $d5 . ', d7=' . $d6
                . ', d8=' . $d7 . ', d9=' . $d8 . ', d10=' . $d9 . ', d11=' . $d10
                . ', d12=' . $d11 . ', d13=' . $d12 . ', d14=' . $d13
                . ', d15=' . $d14 . ', d16=' . $d15 . ', d17=' . $d16
                . ', d18=' . $d17 . ', d19=' . $d18 . ', d20=' . $d19 . ', d21=' . $d20
                . ', d22=' . $d21 . ', d23=' . $d22 . ', d24=' . $d23
                . ', d25=' . $d24 . ', d26=' . $d25 . ', d27=' . $d26
                . ', d28=' . $d27 . ', d29=' . $d28 . ', d30=' . $d29 . ', d31=' . $d30 
                . ', d32=' . $d31 . ', d33=' . $d32 . ', d34=' . $d33
                . ', d35=' . $d34 . ', d36=' . $d35 . ', d37=' . $d36
                . ', d38=' . $d37 . ', d39=' . $d38 . ', d40=' . $d39 . ', d41=' . $d40
                . ', d42=' . $d41 . ', d43=' . $d42 . ', d44=' . $d43
                . ', d45=' . $d44 . ', d46=' . $d45 . ', d47=' . $d46
                . ', d48=' . $d47 . ', d49=' . $d48 . ', d50=' . $d49 . ', d51=' . $d50 
                . ', d52=' . $d51 . ', d53=' . $d52 . ', d54=' . $d53
                . ', d55=' . $d54 . ', d56=' . $d55 . ', d57=' . $d56
                . ', d58=' . $d57 . ', d59=' . $d58 . ', d60=' . $d59
                . '  where code="' . $code . '"');
        }
    }


}
?>
