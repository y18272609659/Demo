<?php

namespace App\Http\Controllers\Common;


use App\Models\Resource;
use App\Policy;
use App\Service\LogService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ResourceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * showdoc
     * @catalog 前后端接口/资源
     * @title [获取]用户的资源
     * @description -
     * @method get
     * @url https://{url}/user/get-resource
     * @return {"id":26,"userId":26,"people":200,"peopleChip":0,"peopleOutput":0,"food":3000,"foodChip":0,"foodOutput":0,"wood":2000,"woodChip":0,"woodOutput":0,"stone":1000,"stoneChip":0,"stoneOutput":0,"money":1322770,"moneyChip":0,"moneyOutput":0,"area":200,"areaChip":0,"areaOutput":0,"created_at":"2018-12-22 12:45:57","updated_at":"2018-12-24 01:24:47"}
     * @return_param id int 资源ID
     * @return_param userId int 用户ID
     * @return_param people int 人口数量（整数）
     * @return_param peopleChip int 人口数量（小数）
     * @return_param peopleOutput int 人口增长（小时）
     * @return_param wood int 木材数量（整数）
     * @return_param woodChip int 木材数量（小数）
     * @return_param woodOutput int 木材增长（小时）
     * @return_param stone int 石料数量（整数）
     * @return_param stoneChip int 石料数量（小数）
     * @return_param stoneOutput int 石料增长（小时）
     * @return_param money int 货币数量（整数）
     * @return_param moneyChip int 货币数量（小数）
     * @return_param moneyOutput int 货币增长（小时）
     * @return_param area int 土地面积（整数）
     * @return_param areaChip int 土地面积（小数）
     * @return_param areaOutput int 土地面积增长（永远为0）
     * @return_param created_at int 创建时间
     * @return_param updated_at int 更新时间
     * @number 10
     */
    public function getMeResource()
    {
        $info = Resource::where('userId', Auth::id())->first();

        return $info;
    }

    /**
     * showdoc
     * @catalog 前后端接口/领地
     * @title [动作]发布流民招募启示
     * @description 该政令耗费 10 金钱，返回政令的结束时间戳，届时，需前端发起请求，获取该政令的状态并提示给用户
     * @method get
     * @url https://{url}/lord/policy/enlisting/open
     * @return {1546777084}
     * @return_param - int|string 政令完成的时间戳或失败原因
     * @number 50
     */
    public function openEnlisting()
    {
        $resource = Resource::where('userId', Auth::id())->first();
        if ($resource->money < 10) {
            return response('大爷，咱们的钱不够啦！', 400);
        }
        $resource->money -= 10;
        DB::beginTransaction();
        try {
            if (!$resource->save()) {
                return '失败：付钱行为无法保存';
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }

        return '失败：移除政策';

        // 启动政策
        $endTime = Policy::POLICIES_ENLISTING['time'];
        $result = (new Policy())->addWithMe(Policy::POLICIES_ENLISTING['id'], $endTime);

        if (is_bool($result)) {
            return $_SERVER['REQUEST_TIME'] + Policy::POLICIES_ENLISTING['time'];
        }

        $resource->money += 10;
        $resource->save();

        return response($result, 500);
    }

    /**
     * showdoc
     * @catalog 前后端接口/领地
     * @title [动作]流民招募启示的进度
     * @description -
     * @method get
     * @url https://{url}/lord/policy/enlisting/know
     * @return {"id":26,"created_at":"2018-12-22 12:45:57","updated_at":"2018-12-24 01:24:47"}
     * @return_param id int 资源ID
     * @return_param created_at int 创建时间
     * @return_param updated_at int 更新时间
     * @number 50
     */
    public function knowEnlisting()
    {
        // 启动政策
        $endTime = Policy::POLICIES_ENLISTING['time'];
        $result = (new Policy())->addWithMe(Policy::POLICIES_ENLISTING['id'], $endTime);

        if (is_bool($result)) {
            return $result;
        }

        return response($result, 500);
    }

    /**
     * showdoc
     * @catalog 前后端接口/领地
     * @title [动作]终止流民招募启示
     * @description 发布流民招募启示，在 20 秒后结束招募
     * @method get
     * @url https://{url}/lord/policy/enlisting/stop
     * @return {"id":26,"created_at":"2018-12-22 12:45:57","updated_at":"2018-12-24 01:24:47"}
     * @return_param id int 资源ID
     * @return_param created_at int 创建时间
     * @return_param updated_at int 更新时间
     * @number 50
     */
    public function stopEnlisting()
    {
        // 启动政策
        $endTime = Policy::POLICIES_ENLISTING['time'];
        $result = (new Policy())->addWithMe(Policy::POLICIES_ENLISTING['id'], $endTime);

        if (is_bool($result)) {
            return $result;
        }

        return response($result, 500);
    }
}
