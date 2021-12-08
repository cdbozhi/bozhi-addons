<?php
/**
 * BozhiAdmin
 * ============================================================================
 * @copyright (C) 2016-2022 博智科技版权所有，并保留所有权利。
 * @link 网站地址: https://www.cdbozhi.com
 * ============================================================================
 * Author: arzn
 * Date: 2019/9/26
 */
namespace bozhi\helper;
use bozhi\helper\HttpHelper;
class ExpressHelper{

    /**
     * 查询快递
     * @param $postcom  快递公司编码
     * @param $getNu  快递单号
     * @return array  物流跟踪信息数组
     */
    function queryExpress($postcom , $getNu) {
        $url = "https://m.kuaidi100.com/query?type=".$postcom."&postid=".$getNu."&id=1&valicode=&temp=0.49738534969422676";
        $resp = HttpHelper::get($url);
        return json_decode($resp,true);
    }
}