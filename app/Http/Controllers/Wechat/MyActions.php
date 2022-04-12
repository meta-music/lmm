<?php

namespace App\Http\Controllers\Wechat;

use App\Models\Market\MArticle;
use App\Models\Project\PProject;
use App\Models\Study\SLesson;
use App\Models\Study\SLessonUser;
use App\Models\Wechat\EbUser;
use App\Models\Wechat\WUnifiedorder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Overtrue\Socialite\User as SocialiteUser;
use Illuminate\Support\Arr;

trait MyActions
{
    public $me;
    public $firstOfLastMonth;
    public $myPoints;
    public $timeline;

    public function getIndex()
    {
//        dd(session('wechat.oauth_user.default'));
        $user = $this->getMe();
        $token = auth('api')->login($user);
        // 获取积分专用课程
        $point2lessons = $this->getLessonsByPoints();
        // 获取已兑换积分课程
        $myLessonsByPoints = $this->getMyLessonsByPoints();
        // 获取用户订单
        $myOrders = $this->getMyOrders();
        // 获取用户项目
        $timeline = $this->getTimeline();
        // 获取用户当月积分
        $myPoints = $this->getMyPoints($timeline);
        // 获取最新文章列表
        $articleList = $this->getArticleList();
//        dd($myLessonsByPoints->where('s_lesson_id',52));
        return view('weui.index.index', compact('user', 'token', 'timeline', 'myLessonsByPoints','point2lessons', 'myPoints','myOrders','articleList'));
    }

    public function getArticleList()
    {
        $list = MArticle::with('category')->orderBy('created_at','desc')
            ->take(10)->get(['id','title', 'thumb_media', 'author', 'visit', 'sort', 'created_at']);
        return $list;
    }

    protected function detail($id)
    {
        $article = MArticle::findOrFail($id);
        $content = new \Parsedown();
        $html = '<div class="markdown">'.$content->text($article->content).'</div>';
        $title = $article->title;
        $author = $article->author;
        $visit = $article->visit;
        $url = $article->content_source_url;
        return [$html];
    }

    public function setMyLessonsByPoints(Request $request, SLessonUser $lessonUser)
    {
        if (!$request->has('lesson_id')){
            \Log::error('setMyLessonsByPoints: lesson_id is null');
            return request('课程当前不可兑换!,请联系客服', 422);
        }
        $lesson = $lessonUser
            ->where('user_id',$this->getMe()->uid)
            ->where('status','>',0)
            ->where('s_lesson_id',$request->get('lesson_id'))
            ->first();

        if ($this->getMyPoints() < 10) {
            return response('当前<span class="icon icon-38 f15 f-yellow"></span>不足, 请先分享或参与互动',422);
        }
        if (empty($lesson)) {
            $lesson = $lessonUser->create([
                'user_id' => $this->getMe()->uid,
                'status'  => '9',
                's_lesson_id' => $request->get('lesson_id')
            ]);
        }
        return $lesson;
    }

    public function getMyPoints()
    {
        // 获取用户已兑换课程
        if (!$this->myPoints){
            $myLessonsFromPoint = $this->getMyLessonsByPoints();
            $usedPoints = $myLessonsFromPoint->count()*10;
            $myPoints = $this->getAllPoints()-$usedPoints;
            $this->myPoints = $myPoints+9;
        }
        return $this->myPoints;
    }

    // todo 当前只计算当月项目的积分, 需在月末提醒用户将未花完积分兑换为活动课程
    public function getAllPoints()
    {
        $timeline = $this->getTimeline();
        $feedbackCount = $timeline->where('feedback','<>',null)->count();
        $shareCount = $timeline->where('is_shared',1)->count();
        $prjCount = $timeline->count();
//        dd($shareCount,$prjCount,$feedbackCount);
        return $shareCount+$prjCount+$feedbackCount;
    }

    public function getLessonsByPoints()
    {
        return SLesson::where('s_subject_id',11)
            ->orderBy('created_at','DESC')->take(3)->get();
    }

    public function getMyLessonsByPoints()
    {
        return SLessonUser::where('status',9)->where('created_at','>',$this->getFirstOfLastMonth())
            ->where('user_id',$this->getMe()->uid)->get(['s_lesson_id']);
    }

    // todo getTimelineAjax - get more

    public function getTimeline()
    {
        if (!$this->timeline) {
            $this->timeline = PProject::with('sLesson')->where('user_id',$this->getMe()->uid)
                ->where('created_at','>',$this->getFirstOfLastMonth())->orderBy('created_at','desc')//->take(10)
                ->get(['id','s_lesson_id','name','feedback','is_shared','created_at','updated_at']);
        }
        return $this->timeline;
    }

    public function getFirstOfLastMonth()
    {
        return $this->firstOfLastMonth ? $this->firstOfLastMonth : $this->firstOfLastMonth = Carbon::now()->firstOfMonth();
    }

    public function getMyOrders()
    {
        return WUnifiedorder::whereHas('payaction',function($query){
            $query->where('trade_state', '<>', 'CLOSED');
        })->where('user_id',$this->getMe()->uid)->where('created_at','>',$this->getFirstOfLastMonth())->get();
    }

    public function getMe()
    {
        if (!$this->me) {
            $user = EbUser::first();
            $wechatUser = new SocialiteUser([
                'id' => Arr::get($user, 'openid'),
                'name' => Arr::get($user, 'nickname'),
                'nickname' => Arr::get($user, 'nickname'),
                'avatar' => Arr::get($user, 'headimgurl'),
                'email' => null,
                'original' => [],
                'provider' => 'WeChat',
            ]);
            session(['wechat.oauth_user.default' => $wechatUser]);
            $this->me = $user;
        }
        return $this->me;
    }

    public function setMe($user)
    {
        return $this->me = $user;
    }
}
