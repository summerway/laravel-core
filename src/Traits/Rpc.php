<?php
/**
 * Created by PhpStorm.
 * User: MapleSnow
 * Date: 2019/3/25
 * Time: 10:35 PM
 */

namespace MapleSnow\LaravelCore\Traits;

use GuzzleHttp\Client;
use MapleSnow\LaravelCore\Libs\Result\Code;
use MapleSnow\LaravelCore\Libs\Result\Result;
use MapleSnow\LaravelCore\Helpers\ExceptionReport;
use GuzzleHttp\Exception\GuzzleException;
use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * 远程接口调用
 * Trait Rpc
 * @package App\Traits
 */
trait Rpc {

    /**
     * get方法
     * @param $url
     * @param array $params
     * @param array $headers
     * @param $timeout
     * @return Result

     */
    public function get($url, $params=[], $headers=[],$timeout = 5) : Result
    {
        $response = $this->request("GET",$url,$params,$headers,$timeout);
        if($response->wrong()){
            return $response;
        }
        return $this->parseResponse($response->getData());
    }

    /**
     * post方法
     * @param $url
     * @param array $params
     * @param array $headers
     * @param $timeout
     * @return Result
     */
    public function post($url, $params=[], $headers=[],$timeout = 5) : Result
    {
        $response =$this->request("POST",$url,$params,$headers,$timeout);
        if($response->wrong()){
            return $response;
        }

        return $this->parseResponse($response->getData());
    }

    /**
     * 请求
     * @param $method
     * @param $url
     * @param array $params
     * @param array $headers
     * @param int $timeout
     * @return Result
     */
    private function request($method,$url, $params=[], $headers=[],$timeout = 5) {
        if (!$url) {
            return Result::paramMiss("请求地址必填");
        }
        $client = new Client();
        try {
            $response = $client->request($method, $url, [
                "verify"=>false,
                "headers" => $headers,
                "form_params" => $params,
                "timeout" => $timeout
            ]);
            if (!$response) {
                return Result::rpcNoResponse("服务器无响应");
            }
            if ($response->getStatusCode() != Response::HTTP_OK) {
                return Result::rpcResponseException("远程服务器错误");
            }
            return Result::success($response->getBody()->getContents(), "请求成功");
        }  catch (GuzzleException $ex){
            return Result::error("Rpc请求失败", $ex);
        } catch (Exception $ex){
            return Result::error($ex->getMessage(), $ex);
        }
    }

    /**
     * 解析返回数据
     * @param $response
     * @return Result
     */
    private function parseResponse($response){
        $res = json_decode($response,true);
        if(isset($res['code'])){
            if(Response::HTTP_OK == $res['code'] || Code::SUCCESS == $res['code']){
                return Result::success(array_get($res,"data") ? : $res);
            }else{
                return Result::error($res['message']?? "");
            }
        }else{
            return Result::rpcResponseException("错误的返回信息");
        }
    }
}