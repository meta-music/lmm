<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Post;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;

class PostController extends AdminController
{

    public function index(Content $content)
    {
        return $content
            ->translation($this->translation())
            ->title($this->title())
            ->description('该页面用于demo的音乐日记的增删改查, 交互和样式后续修改, 刘术:也可用于API前后端调试')//$this->description()['index'] ?? trans('admin.list')
            ->body($this->grid());
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Post(), function (Grid $grid) {
            // $grid->column('id')->sortable();
            $grid->column('feeling');
            // $grid->column('mood');
            // $grid->column('music');
            // $grid->column('log');
            $grid->column('thought');
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
            $feeling = [
                1=>'Happiness',
                2=>'Sadness',
                3=>'Fear',
                4=>'Disgust',
                5=>'Anger',
                6=>'Surprise',
            ];
            $form->select('feeling')->options($feeling)->required()->help('表单不代表实际用户场景的交互逻辑, 仅用于demo和测试/讨论, 讨论: 情绪对应的音乐属性待确定, 例如音长/音高/评率等, 对应ABC模型');
            $form->textarea('mood')->help('首先, 我感觉（插入特定的情感）对应 C 长按情绪 普拉切克的情绪轮盘. 用于情绪的具体/比喻描述?可以考虑自动生成指导建议选项');
            $form->textarea('log')->help('其次，描述触发事件 - A 避免判断和意见，采用细节.');
            $form->textarea('thought')->help('再次，找到信念 - B 我认为（插入信念）<br>1. 这个时间此刻对我来说意味着什么<br>2. 我为什么会有这样的情绪或者那样的行为？<br>3. 在事件发生后，是什么导致了我出现这样的情绪或行为？<br>4. 我当时是怎么想的？<br>5. 反向检验：有了我所发现的信念，我还会期望感受到那种特定的结果吗？')->required();
            $form->textarea('challenge')->help('再次，挑战各种信念 - 你通过评估一个信念的有效性、质疑它，并找到一个更好的选择来挑战它。<br>1. 这种信念是否足够灵活以适应所有事件？<br>2. 这种信念是合乎逻辑的，还是基于错误逻辑的？<br>3. 这种信念是与事实和经验一致的，还是不一致的？<br>4. 这种信念对我追求目标有用吗？它能让我对自己和自己的生活感觉良好吗？');
            $form->textarea('behavior')->help('最后，写下好的替代信念, 我能想到哪种替代想法？哪一种思维方式是合乎逻辑的，基于现实的，灵活的，对我追求目标是有用的？');
            $form->select('change')->options($feeling)->help('最后之后, 当信仰的改变发生, 他会让你的情绪从原本的XXX变成什么?');
            $form->text('image')->help('用户可以选择上传一张图片');

            $form->text('music')->help('预留字段, 无需用户填写, 用于存储SongMaker的旋律和音乐配置,可json或chat格式');
            $form->text('ai_music')->help('预留字段, 无需用户填写, 用于存储AI生成的音乐文件路径, VIP(也许可以作为付费用户的卖点?)');
            $form->number('like')->help('预留字段, 用于缓存分享后收到的赞, 无需用户填写');
            $form->text('user_id')->help('关联用户的字段, 无需用户填写,');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}

