<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TestApidocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        echo $this->app
        $user = Auth::user();
        dd($user);
    }

    /**
     * @api                   {get} /test/apidoc/detail/:id 详情接口
     * @apiGroup              forum
     * @apiversion            1.0.0
     * @apiDescription
     * --------------------------------------
     * 备注: 测试apidoc生成的格式
     * 时间：2019-1-24 18:22:03
     * 作者：刘海云
     * --------------------------------------
     * @apiParam {Number} id 用户id
     * @apiParam {String} token 用户token
     *
     * @apiSuccess {Number} status_code 状态码
     * @apiSuccess {String} message  提示信息
     * @apiSuccess (200) {Object} data 用户详情
     * @apiSuccess {Number} data.id 用户id
     * @apiSuccess {String} data.token 用户token
     *
     * @apiExample {curl} 使用示例:
     *  curl -i http://laravel51.local/test/apidoc/1
     *
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *      "status_code": 200,
     *      "message": "OK",
     *      "data": {
     *          "id": 1,
     *          "token": "kfitnjgueytw98hu47yg0nv"
     *      }
     *  }
     *
     * @apiError {Number} status_code 状态码
     * @apiError {String} message  提示信息
     *
     * @apiErrorExample {json} Error-Response:
     *  HTTP/1.1 404 Not Found
     *  {
     *      "status_code": 404,
     *      "message": "OK",
     *  }
     *
     * @return mixed
     */
    public function detail($id, Request $request){

        if($id == 0){
            return new Response([
                'status_code' => 404,
                'message' => 'User Not Found',
            ], 200, ['Access-Control-Allow-Origin' => '*']);
        }

        return new Response([
            'status_code' => 200,
            'message' => 'ok',
            'data' => [
                'id' => $id,
                'token' => $request->token
            ]
        ], 200, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * @api {post} /test/apidoc/create 新建接口
     * @apiName GetUser
     * @apiGroup User
     *
     * @apiParam {String} username 用户名
     *
     * @apiExample {curl} 使用示例:
     *  {"username": "张三"}
     *
     * @apiSuccess {Number} status_code 状态码
     * @apiSuccess {String} message  提示信息
     * @apiSuccess (200) {Object} data 用户详情
     * @apiSuccess {Number} data.id 用户id
     * @apiSuccess {String} data.username 用户名
     * @apiSuccess {String} data.created_at 创建时间
     *
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *      "status_code": 200,
     *      "message": "OK",
     *      "data": {
     *          "id": 1,
     *          "username": "张三",
     *          "created_at": "2019-1-24 18:25:47"
     *      }
     *  }
     *
     * @apiError {Number} status_code 状态码
     * @apiError {String} message  提示信息
     *
     * @apiErrorExample {json} Error-Response:
     *  HTTP/1.1 404 Not Found
     *  {
     *      "status_code": 400,
     *      "message": "缺少username参数"
     *  }
     *
     * @return mixed
     */
    public function create(Request $request){
        if(!$request->has('username')){
            return new Response(
                [
                    'status_code' => 400,
                    'message' => '缺少username参数',
                ],
                200,
                ['Access-Control-Allow-Origin' => '*']
            );
        }

        return new Response(
            [
                'status_code' => 200,
                'message' => 'success',
                'data' => [
                    'id' => 1,
                    'username' => $request->username,
                    'created_at' => date('Y-m-d H:i:s')
                ]
            ],
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }
}
