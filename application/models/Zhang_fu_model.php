<?php
class Zhang_fu_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function update_data($arr)
    {
        $s_data = $arr[0];
        $code = $s_data['code'];
        $query = $this->db->query("select * from ten_zhangfu where code = '$code'");
        $query_result = $query->row_array();
        $zhangfu_arr = array();


        if (count($query_result) < 1) {
            for ($i = 0; $i < count($arr); $i++) {
                $zhangfu_arr['d' . $i] = $arr[$i]['zhangfu'];
            }
            $zhangfu_arr['code'] = $code;
            $this->db->insert('ten_zhangfu',$zhangfu_arr);
        } else {
            $sql = "update ten_zhangfu set ";

            for ($i = 0; $i < count($arr); $i++) {
                array_push($zhangfu_arr,'d' . $i . '=' . $arr[$i]['zhangfu']);
            }
            $sql = $sql . join(',',$zhangfu_arr) . " where code='$code'";
            $this->db->query($sql);
        }
    }

    public function back_up ()
    {
        $query = $this->db->query('select * from ten_zhangfu');
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

            $this->db->query("update ten_zhangfu set d0=0,d1=$d0,d2=$d1,d3=$d2,d4=$d3,d5=$d4,d6=$d5,d7=$d6,
               d8=$d7,d9=$d8,d10=$d9,d11=$d10,d12=$d11,d13=$d12,d14=$d13,d15=$d14,d16=$d15,d17=$d16,
               d18=$d17,d19=$d18,d20=$d19,d21=$d20,d22=$d21,d23=$d22,d24=$d23,d25=$d24,d26=$d25,d27=$d26,
               d28=$d27,d29=$d28,d30=$d29,d31=$d30,d32=$d31,d33=$d32,d34=$d33,d35=$d34,d36=$d35,d37=$d36,
               d38=$d37,d39=$d38,d40=$d39,d41=$d40,d42=$d41,d43=$d42,d44=$d43,d45=$d44,d46=$d45,d47=$d46,
               d48=$d47,d49=$d48,d50=$d49,d51=$d50,d52=$d51,d53=$d52,d54=$d53,d55=$d54,d56=$d55,d57=$d56,
               d58=$d57,d59=$d58,d60=$d59 where code='$code'");
        }
    }
}
?>
