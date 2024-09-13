<?php

declare(strict_types=1);

namespace hulang;

/**
 * Class BaiduPush
 *
 * @package hulang\BaiduPush
 *
 */
class BaiduPush
{
    /**
     * @var mixed|string
     */
    protected $token;

    /**
     * Page类的构造函数
     * 该构造函数接受一个字符串类型的令牌参数,并将其赋值给类属性
     * 
     * @param string $token 用于初始化Page对象的令牌字符串
     */
    public function __construct(string $token)
    {
        // 将传入的令牌赋值给类属性token
        $this->token = $token;
    }

    /**
     * 批量提交
     *
     * @param array $urls URL数组,包含要提交的所有URL
     *
     * @return mixed|array 返回包含所有提交结果的数组
     *
     */
    public function pushs(array $urls)
    {
        // 对URLs进行预处理,可能包括验证、筛选等操作
        $list = $this->formatUrl($urls);
        $res = [];
        // 遍历处理后的URL列表,对每个URL进行提交
        foreach ($list as $key => $val) {
            // 使用HTTP客户端以POST方法提交数据,$token为请求的令牌
            $res[$key] = HttpClient::post($this->token, $key, $val);
        }
        // 返回所有提交操作的结果
        return $res;
    }

    /**
     * 推送一条数据到指定URL
     *
     * 该方法封装了一次推送操作,主要用于向特定URL发送信息
     * 它调用了父方法pushs,但只推送一个URL
     *
     * @param string $url 要推送数据的URL
     *
     * @return mixed|array 推送操作的结果
     *
     */
    public function push(string $url)
    {
        // 调用pushs方法,将$url封装进数组中
        return $this->pushs([$url]);
    }

    /**
     * 格式化URL数组,将来自同一站点的URL分组
     *
     * 该方法接收一个URL数组,并返回一个关联数组
     * 其中键是主机名(例如example.com),值是属于该主机名的URL数组
     *
     * @param array $urls 输入的URL数组,每个元素是一个完整的URL字符串
     *
     * @return mixed|array 返回一个关联数组,键是主机名,值是属于该主机名的URL数组
     *
     */
    public function formatUrl(array $urls)
    {
        // 初始化空数组用于存储分组后的URL
        $list = [];

        // 遍历输入的URL数组
        foreach ($urls as $url) {
            // 使用内置函数parse_url解析URL,获取主机名
            $parse = parse_url($url);
            // 根据主机名将URL添加到相应的数组中,如果该主机名的键不存在,则创建
            $list[$parse['host']][] = $url;
        }

        // 返回分组后的URL数组
        return $list;
    }
}
