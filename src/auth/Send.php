<?php
/**
 * BozhiAdmin
 * ============================================================================
 * @copyright (C) 2016-2022 博智科技版权所有，并保留所有权利。
 * @link 网站地址: https://www.cdbozhi.com
 * ============================================================================
 * Author: arzn
 * Date: 2019/9/22
 */
namespace bozhi\auth;

use think\exception\HttpResponseException;
use think\Response;

trait Send
{
    public  $timeDif = 10000;
    public  $refreshExpires = 3600 * 24 * 30;   //刷新token过期时间
    public  $expires = 7200*12;
    public  $responseType = 'json';

    /**
     * 操作成功返回的数据
     * @param string $msg 提示信息
     * @param mixed $data 要返回的数据
     * @param int $code 错误码，默认为1
     * @param string $type 输出类型
     * @param array $header 发送的 Header 信息
     */
    public  function success($msg = '', $data = null, $code = 200, $type = null, array $header = [])
    {
        $this->result($msg, $data, $code, $type, $header);
    }

    /**
     * 操作失败返回的数据
     * @param string $msg 提示信息
     * @param mixed $data 要返回的数据
     * @param int $code 错误码，默认为0
     * @param string $type 输出类型
     * @param array $header 发送的 Header 信息
     */
    public function error($msg = '', $data = null, $code = 404, $type = null, array $header = [])
    {
        $this->result($msg, $data, $code, $type, $header);
    }

    protected  function result($msg, $data = null, $code = 404, $type = null, array $header = [])
    {
        $result = [
            'code' => $code,
            'msg' => $msg,
            'time' => \think\facade\Request::instance()->server('REQUEST_TIME'),
            'data' => $data,
        ];
        // 如果未设置类型则自动判断
        $type = $type ? $type : (\think\facade\Request::param(config('var_jsonp_handler')) ? 'jsonp' : $this->responseType);
        // 发送头部信息
        foreach ($header as $name => $val) {
            if (is_null($val)) {
                header($name);
            } else {
                header($name . ':' . $val);
            }
        }
        $response = Response::create($result, $type, (int)$code)->header($header);
        throw new HttpResponseException($response);
    }
}

