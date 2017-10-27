<?php
class Huan_shou_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function update_data($arr)
    {
        $s_data = $arr[0];
        $code = $s_data['code'];
        $query = $this->db->query("select * from ten_huanshou where code = '$code'");
        $query_result = $query->row_array();
        $huanshou_arr = array();


        if (count($query_result) < 1) {
            for ($i = 0; $i < count($arr); $i++) {
                $huanshou_arr['d' . $i] = $arr[$i]['huanshou'];
            }
            $huanshou_arr['code'] = $code;
            $this->db->insert('ten_huanshou',$huanshou_arr);
        } else {
            $sql = "update ten_huanshou set ";

            for ($i = 0; $i < count($arr); $i++) {
                array_push($huanshou_arr,'d' . $i . '=' . $arr[$i]['huanshou']);
            }
            $sql = $sql . join(',',$huanshou_arr) . " where code='$code'";
            $this->db->query($sql);
        }
    }

    public function back_up ()
    {
        $this->db->query("update ten_huanshou set d60=d59,d59=d58,d58=d57,d57=d56,d56=d55,d55=d54,d54=d53,d53=d52,d52=d51,d51=d50,
                          d50=d49,d49=d48,d48=d47,d47=d46,d46=d45,d45=d44,d44=d43,d43=d42,d42=d41,d41=d40,
                          d40=d39,d39=d38,d38=d37,d37=d36,d36=d35,d35=d34,d34=d33,d33=d32,d32=d31,d31=d30,
                          d30=d29,d29=d28,d28=d27,d27=d26,d26=d25,d25=d24,d24=d23,d23=d22,d22=d21,d21=d20,
                          d20=d19,d19=d18,d18=d17,d17=d16,d16=d15,d15=d14,d14=d13,d13=d12,d12=d11,d11=d10,
                          d10=d9,d9=d8,d8=d7,d7=d6,d6=d5,d5=d4,d4=d3,d3=d2,d2=d1,d1=d0,d0=0");
    }


}
?>
