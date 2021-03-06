<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Post;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Models\Role;

class PostController extends AdminController
{

    protected $feeling = [
        1=>'Happiness',
        2=>'Sadness',
        3=>'Fear',
        4=>'Disgust',
        5=>'Anger',
        6=>'Surprise',
    ];

    public function index(Content $content)
    {
        return $content
            ->translation($this->translation())
            ->title($this->title())
            ->description('该页面用于demo的音乐日记的增删改查, 交互和样式后续修改, ToDo: 权限/分享/SongMaker整合')//$this->description()['index'] ?? trans('admin.list')
            ->body($this->grid());
    }
    /**
     * Make a grid builder.
     * helpers/scaffold
     * @return Grid
     */
    protected function grid()
    {
        //
        return Grid::make(new Post(), function (Grid $grid) {
            // $grid->column('id')->sortable();
            $feeling = $this->feeling;
            $grid->column('feeling')->display(function ($val) use ($feeling) {
                return $feeling[$val]??'';
            })->label();
            // $grid->column('mood');
            // $grid->column('music');
            // $grid->column('log');
            $grid->column('thought')->display(function($val){
                return '<a href="'.admin_url('posts/'.$this->id.'/edit').'" >'.$val.'</a>';
            });
            // $grid->column('challenge');
            // $grid->column('behavior');
            // $grid->column('change');
            // $grid->column('image');
            // $grid->column('like');
            // $grid->column('ai_music');
            // $grid->column('user_id');
            // $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->disableActions();
            $grid->disableBatchActions();
            $grid->disableFilterButton();
            $grid->disableColumnSelector();
            // $grid->disableToolbar();
            $grid->disableRowSelector();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Post(), function (Show $show) {
            $show->html('作品详情页, 这里显示和播放音乐, 并用于展示情绪变化的图表和改变的过程<br><br>回顾历程:<br>1. 第一步：以“我感觉到（插入情感）”或“我做了（插入行为）”的形式写下结果<br>2. 第二步：以“（插入事件）发生了”和“情况是（插入情况和地点）”的形式写下触发事件<br>3. 第三步：通过在日记中询问和回答关于激活事件对你的意义的问题，并以“在那一刻，我认为（插入信念）”的形式来表达这种信念。<br>4. 第四步：挑战你的信念，问问自己有什么证据，问问这一信念是否有用<br>5. 第五步：形成一个替代信念。你可以写下很多种替代信念，然后检查它们是否有用、是否灵活、是否与现实相符、是否符合逻辑、是否对你有好处？');
            $show->field('id');
            $show->field('feeling');
            $show->field('mood');
            $show->field('music');
            $show->field('log');
            $show->field('thought');
            $show->field('challenge');
            $show->field('behavior');
            $show->field('change');
            $show->field('image');
            $show->field('like');
            $show->field('ai_music');
            $show->field('user_id');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Post(), function (Form $form) {
            // $form->display('id');
            // $form->action('/posts/step');
            $form->title('讨论:在完成第一步Feeling后进入SongMaker进行作曲创作, 完成后返回填写第二步Change.');
            $form->multipleSteps()
                ->remember()
                // ->width('350px')
                ->add('Feeling', function ($form) {
                    $form->select('feeling')->options($this->feeling)->required()->help('表单不代表实际用户场景的交互逻辑, 仅用于demo和测试/讨论, 讨论: 情绪对应的音乐属性待确定, 例如音长/音高/评率等, 对应ABC模型');
                    $form->textarea('mood')->help('首先, 我感觉（插入特定的情感）对应 C 长按情绪 普拉切克的情绪轮盘. 用于情绪的具体/比喻描述?可以考虑自动生成指导建议选项');
                    $form->textarea('log')->help('其次，描述触发事件 - A 避免判断和意见，采用细节.');
                    $form->textarea('thought')->help('再次，找到信念 - B 我认为（插入信念）<br>1. 这个时间此刻对我来说意味着什么<br>2. 我为什么会有这样的情绪或者那样的行为？<br>3. 在事件发生后，是什么导致了我出现这样的情绪或行为？<br>4. 我当时是怎么想的？<br>5. 反向检验：有了我所发现的信念，我还会期望感受到那种特定的结果吗？')->required();
                    $form->html('<a href="https://meta-music.github.io/songmaker/" class="btn btn-success btn-lg" style="justify-content: space-between!important;">来SongMaker弹出你的情绪!</a>');
                })->add('Change', function ($form) {
                    $form->textarea('challenge')->help('再次，挑战各种信念 - 你通过评估一个信念的有效性、质疑它，并找到一个更好的选择来挑战它。<br>1. 这种信念是否足够灵活以适应所有事件？<br>2. 这种信念是合乎逻辑的，还是基于错误逻辑的？<br>3. 这种信念是与事实和经验一致的，还是不一致的？<br>4. 这种信念对我追求目标有用吗？它能让我对自己和自己的生活感觉良好吗？');
                    $form->textarea('behavior')->help('最后，写下好的替代信念, 我能想到哪种替代想法？哪一种思维方式是合乎逻辑的，基于现实的，灵活的，对我追求目标是有用的？');
                    $form->select('change')->options($this->feeling)->help('完成了音乐制作后, 当信仰的改变发生, 他会让你的情绪从原本的XXX变成什么?');
                    $form->text('image')->help('用户可以选择上传一张图片');
                })->done(function () use ($form) {
                    $data = [
                        'title'       => '完成制作',
                        'description' => '恭喜您创建了新的作品!',
                        'createUrl'   => admin_url('posts/create'),
                        'backUrl'     => admin_url('posts'),
                    ];
                    return view('dcat-admin.form-step::completion-page', $data);
                });

            // $form->text('music')->help('预留字段, 无需用户填写, 用于存储SongMaker的旋律和音乐配置,可json或chat格式');
            // $form->text('ai_music')->help('预留字段, 无需用户填写, 用于存储AI生成的音乐文件路径, VIP(也许可以作为付费用户的卖点?)');
            // $form->number('like')->help('预留字段, 用于缓存分享后收到的赞, 无需用户填写');
            // $form->text('user_id')->help('关联用户的字段, 无需用户填写,');

            // $form->display('created_at');
            // $form->display('updated_at');
            // $form->disableViewButton();
        });
    }
}

