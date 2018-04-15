<?php
class Cheng_jiao_e_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function update_data($arr)
    {
        $s_data = $arr[0];
        $code = $s_data['code'];
        $query = $this->db->query("select * from ten_chengjiaoe where code = '$code'");
        $query_result = $query->row_array();
        $chengjiaoe_arr = array();


        if (count($query_result) < 1) {
            for ($i = 0; $i < count($arr); $i++) {
                $chengjiaoe_arr['d' . $i] = $arr[$i]['chengjiaoe'];
            }
            $chengjiaoe_arr['code'] = $code;
            $this->db->insert('ten_chengjiaoe',$chengjiaoe_arr);
        } else {
            $sql = "update ten_chengjiaoe set ";

            for ($i = 0; $i < count($arr); $i++) {
                array_push($chengjiaoe_arr,'d' . $i . '=' . $arr[$i]['chengjiaoe']);
            }
            $sql = $sql . join(',',$chengjiaoe_arr) . " where code='$code'";
            $this->db->query($sql);
        }
    }

    public function back_up ()
    {
        $this->db->query("update ten_chengjiaoe set 
            d350=d349,d349=d348,d348=d347,d347=d346,d346=d345,d345=d344,d344=d343,d343=d342,d342=d341,d341=d340,
            d340=d339,d339=d338,d338=d337,d337=d336,d336=d335,d335=d334,d334=d333,d333=d332,d332=d331,d331=d330,
            d330=d329,d329=d328,d328=d327,d327=d326,d326=d325,d325=d324,d324=d323,d323=d322,d322=d321,d321=d320,
            d320=d319,d319=d318,d318=d317,d317=d316,d316=d315,d315=d314,d314=d313,d313=d312,d312=d311,d311=d310,
            d310=d309,d309=d308,d308=d307,d307=d306,d306=d305,d305=d304,d304=d303,d303=d302,d302=d301,d301=d300,
            d300=d299,d299=d298,d298=d297,d297=d296,d296=d295,d295=d294,d294=d293,d293=d292,d292=d291,d291=d290,
            d290=d289,d289=d288,d288=d287,d287=d286,d286=d285,d285=d284,d284=d283,d283=d282,d282=d281,d281=d280,
            d280=d279,d279=d278,d278=d277,d277=d276,d276=d275,d275=d274,d274=d273,d273=d272,d272=d271,d271=d270,
            d270=d269,d269=d268,d268=d267,d267=d266,d266=d265,d265=d264,d264=d263,d263=d262,d262=d261,d261=d260,
            d260=d259,d259=d258,d258=d257,d257=d256,d256=d255,d255=d254,d254=d253,d253=d252,d252=d251,d251=d250,
            d250=d249,d249=d248,d248=d247,d247=d246,d246=d245,d245=d244,d244=d243,d243=d242,d242=d241,d241=d240,
            d240=d239,d239=d238,d238=d237,d237=d236,d236=d235,d235=d234,d234=d233,d233=d232,d232=d231,d231=d230,
            d230=d229,d229=d228,d228=d227,d227=d226,d226=d225,d225=d224,d224=d223,d223=d222,d222=d221,d221=d220,
            d220=d219,d219=d218,d218=d217,d217=d216,d216=d215,d215=d214,d214=d213,d213=d212,d212=d211,d211=d210,
            d210=d209,d209=d208,d208=d207,d207=d206,d206=d205,d205=d204,d204=d203,d203=d202,d202=d201,d201=d200,
            d200=d199,d199=d198,d198=d197,d197=d196,d196=d195,d195=d194,d194=d193,d193=d192,d192=d191,d191=d190,
            d190=d189,d189=d188,d188=d187,d187=d186,d186=d185,d185=d184,d184=d183,d183=d182,d182=d181,d181=d180,
            d180=d179,d179=d178,d178=d177,d177=d176,d176=d175,d175=d174,d174=d173,d173=d172,d172=d171,d171=d170,
            d170=d169,d169=d168,d168=d167,d167=d166,d166=d165,d165=d164,d164=d163,d163=d162,d162=d161,d161=d160,
            d160=d159,d159=d158,d158=d157,d157=d156,d156=d155,d155=d154,d154=d153,d153=d152,d152=d151,d151=d150,
            d150=d149,d149=d148,d148=d147,d147=d146,d146=d145,d145=d144,d144=d143,d143=d142,d142=d141,d141=d140,
            d140=d139,d139=d138,d138=d137,d137=d136,d136=d135,d135=d134,d134=d133,d133=d132,d132=d131,d131=d130,
            d130=d129,d129=d128,d128=d127,d127=d126,d126=d125,d125=d124,d124=d123,d123=d122,d122=d121,d121=d120,
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
