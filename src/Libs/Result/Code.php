<?php
/**
 * 接口和内部函数(如service,model等)调用的返回码枚举值
 */

namespace MapleSnow\LaravelCore\Libs\Result;


class Code {
    const
        /** 成功请求 */
        SUCCESS = "00000",

        /**
         * 基础异常返回码
         */
        /** 坏请求,如果不知道报什么错误,就报这个 */
        BAD_REQUEST = '40000',

        /** 参数类型错误,如需要传递数组,但是传递了字符串等 */
        PARAM_ERROR = "40001",

        /** 参数丢失,没有传递必须的参数 */
        PARAM_MISS = "40002",

        /** 操作错误 */
        OPERATING_EXCEPTION = "40400",

        /** 未授权，请求需要先登录后才能够访问 */
        UNAUTHORIZED = "40401",

        /** (已登录)权限限制 */
        FORBIDDEN = "40403",

        /** 资源不存在 */
        RESOURCE_NOT_FOUND = "40404",

        /** 不支持该操作,如对一个开机中的虚拟机进行关机等 */
        NOT_ACCEPTABLE = "40406",

        /** 服务器错误,通常是未捕捉的异常导致 */
        UNEXPECTED_ERROR = "40500",

        /**
         * Rpc调用异常码
         */
        /** 未知错误，服务未响应 */
        RPC_NO_RESPONSE  = "40600",

        /** 远程服务接口请求异常 */
        RPC_RESPONSE_EXCEPTION = "40601"
    ;

}