<?php
namespace Http\controller;

use Http\Common\BridgeResponse;
use Http\repository\CategoryRepository;

class TestController extends Controller
{
    public $informationRepo;
    public $informationDetailRepo;
    public $categoryRepo;
    public $gameRepo;
    public $gameInfo;


    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function testList($id)
    {
        if (empty($id)) {
            return new BridgeResponse(BridgeResponse::UNKNOWN, '未知错误');
        }
//        return new BridgeResponse(
//            BridgeResponse::SUCCESS,
//            $id
//        );
        // $this->categoryRepo->find($id);
        return view("informations.test.test.detail", ['info' => ['111']]);
    }

    // 获取公告详情
    public function detailShow($customId, $gameId)
    {
        return env('TEST');
    }
}