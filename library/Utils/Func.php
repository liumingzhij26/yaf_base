<?php
/**
 * Created by PhpStorm.
 * User: mingzhil
 * Date: 14/11/17
 * Time: 上午11:02
 */
namespace Utils;

use \Yaf\Exception;

class Func
{

    public static function NotFound()
    {

        throw new Exception("Page not Found", 599);
    }

    /**
     * 获取客户端IP地址
     * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
     * @return mixed
     */
    public static function ClientIp($type = 0, $adv = false)
    {
        $type = $type ? 1 : 0;
        static $ip = NULL;
        if ($ip !== NULL)
            return $ip[$type];
        if ($adv) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos = array_search('unknown', $arr);
                if (false !== $pos)
                    unset($arr[$pos]);
                $ip = trim($arr[0]);
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u", ip2long($ip));
        $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }

    /*
    *
    * example: echo httpGet("http://g.cn");
    */
    public static function HttpGet($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //  curl_setopt($ch,CURLOPT_HEADER, false);

        $output = curl_exec($ch);

        curl_close($ch);
        return $output;
    }

    /*
    example:
    $params = array(
       "name" => "Ravishanker Kusuma",
       "age" => "32",
       "location" => "India"
    );

    echo httpPost("http://google.com/post.php",$params);
     */

    public static function HttpPost($url, $params)
    {
        $postData = '';
        //create name value pairs seperated by &
        foreach ($params as $k => $v) {
            $postData .= $k . '=' . $v . '&';
        }
        rtrim($postData, '&');

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $output = curl_exec($ch);

        curl_close($ch);
        return $output;
    }


    /**
     * 根据PHP各种类型变量生成唯一标识号
     * @param mixed $mix 变量
     * @return string
     */
    public static function GuidString($mix)
    {
        if (is_object($mix)) {
            return spl_object_hash($mix);
        } elseif (is_resource($mix)) {
            $mix = get_resource_type($mix) . strval($mix);
        } else {
            $mix = serialize($mix);
        }
        return md5($mix);
    }



    public static function Assets($config, $smarty = null)
    {
        if ($config['url'] && preg_match('/\.(png|jpg|bmp|gif|svg)$/', $config['url'])) {
            echo \Yaf\Registry::get('config')->api['static_image'] . $config['url'] . '?'. \Yaf\Registry::get('config')->api['static_assets_date'];
        }else{
            echo \Yaf\Registry::get('config')->api['static_assets'] . $config['url'] . '?'. \Yaf\Registry::get('config')->api['static_assets_date'];
        }
        return null;
    }


    /**
     * 当前URL地址
     */
    //todo
    public static function SeftUrl()
    {
        return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }


    /**
     * Curl 免登录请求（携带cookie）
     * @return int
     */
    public static function HttpCookie($url)
    {// cookie拼装
        $cookie = self::CookieString($_COOKIE);
        $header = array('Accept: application/json; charset=UTF-8');
    // 初始化
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
// 执行
        $response = curl_exec($ch);
// 关闭
        curl_close($ch);
        $data = json_decode($response, true);
        return $data;
    }

    /**
     * Cookie字符串拼装(注意：值需要urlencode, 如果有特殊符号会出现问题)
     * @param $array
     * @param string $delimiter Cookie值对分隔符
     * @param string $assign
     * @return string Cookie字符串
     */
    public static function CookieString($array, $delimiter = ';', $assign = '=')
    {
        $string = '';
        foreach ($array as $k => $v) {
            $string .= $k . $assign . urlencode($v) . $delimiter;
        }
        return $string;
    }


    public static function CardCode($uid) {
        $id = base_convert($uid,10,27);
        $code = str_replace("o","z",str_replace("i","y",str_replace("1","x",str_replace("0","w",str_pad($id,6,"0",STR_PAD_LEFT)))));
        return strtoupper($code);
    }


}
