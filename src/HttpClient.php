<?php

declare(strict_types=1);

namespace hulang;

/**
 * Class HttpClient
 *
 * @package hulang\BaiduPush
 */
class HttpClient
{
    /**
     * 使用百度推送API提交URLs
     * 
     * @param string $token 百度资源提交API的令牌
     * @param string $site 需要提交的网站域名
     * @param array $urls 需要提交的URL地址数组
     * 
     * @return mixed|array 返回推送操作的结果,包含成功与否的信息
     */
    public static function post($token, $site, $urls)
    {
        // 构造百度资源提交API的URL
        $api = "http://data.zz.baidu.com/urls?site={$site}&token={$token}";

        // 初始化cURL会话
        $ch = curl_init();

        // 设置cURL选项
        $options = [
            // 设置请求的URL
            CURLOPT_URL => $api,
            // 设置请求方法为POST
            CURLOPT_POST => true,
            // 将返回结果保存到变量中
            CURLOPT_RETURNTRANSFER => true,
            // 设置POST请求的数据,URLs以换行符分隔
            CURLOPT_POSTFIELDS => implode(PHP_EOL, $urls),
            // 设置请求头,指定数据类型为纯文本
            CURLOPT_HTTPHEADER => ['Content-Type: text/plain'],
        ];

        // 一次性设置cURL选项
        curl_setopt_array($ch, $options);

        // 执行cURL请求并获取结果
        $result = curl_exec($ch);

        // 关闭cURL会话
        curl_close($ch);

        // 将结果解码为关联数组并返回
        return json_decode($result, true);
    }
}
