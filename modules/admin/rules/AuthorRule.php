<?php


namespace app\modules\admin\rules;
use app\modules\admin\models\Category;
use yii\rbac\Rule;

//rbac的规则类（用来判断当前删除资源管理员是不是创建该资源的管理员）
class AuthorRule extends Rule{

    //需要定义name属性值对应表auth_rule的name字段
    public $name='isAuthor';

    public function execute($user, $item, $params)
    {
        //管理员只能删除自己自己添加的分类
        $controller=\Yii::$app->controller->id;
        //处理以下seek-password这种类型的方法名
        $action=$this->handleAction();
        if('category/delete'==$controller.'/'.$action) {
            $cates = Category::find()->where(['status' => 1, 'id' => \Yii::$app->request->get('id')])->one();
            if ($cates->adminid != \Yii::$app->admin->id) {
                return false;
            }
        }
        return true;
    }

    protected  function handleAction(){
        $action=\Yii::$app->controller->action->id;
        $action=explode('-',$action);
        return strtolower(implode('',$action));
    }
}