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
        $this->db->query("update ten_zhangfu set
            d120=d119,d119=d118,d118=d117,d117=d116,d116=d115,d115=d114,d114=d113,d113=d112,d112=d111,d111=d110,
            d110=d109,d109=d108,d108=d107,d107=d106,d106=d105,d105=d104,d104=d103,d103=d102,d102=d101,d101=d100,
            d100=d99,d99=d98,d98=d97,d97=d96,d96=d95,d95=d94,d94=d93,d93=d92,d92=d91,d91=d90,
            d90=d89,d89=d88,d88=d87,d87=d86,d86=d85,d85=d84,d84=d83,d83=d82,d82=d81,d81=d80,
            d80=d79,d79=d78,d78=d77,d77=d76,d76=d75,d75=d74,d74=d73,d73=d72,d72=d71,d71=d70,
            d70=d69,d69=d68,d68=d67,d67=d66,d66=d65,d65=d64,d64=d63,d63=d62,d62=d61,d61=d60,
            d60=d59,d59=d58,d58=d57,d57=d56,d56=d55,d55=d54,d54=d53,d53=d52,d52=d51,d51=d50,
            d50=d49,d49=d48,d48=d47,d47=d46,d46=d45,d45=d44,d44=d43,d43=d42,d42=d41,d41=d40,
            d40=d39,d39=d38,d38=d37,d37=d36,d36=d35,d35=d34,d34=d33,d33=d32,d32=d31,d31=d30,
            d30=d29,d29=d28,d28=d27,d27=d26,d26=d25,d25=d24,d24=d23,d23=d22,d22=d21,d21=d20,
            d20=d19,d19=d18,d18=d17,d17=d16,d16=d15,d15=d14,d14=d13,d13=d12,d12=d11,d11=d10,
            d10=d9,d9=d8,d8=d7,d7=d6,d6=d5,d5=d4,d4=d3,d3=d2,d2=d1,d1=d0,d0=0");
    }
}
?>
