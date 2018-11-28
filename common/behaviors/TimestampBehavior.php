<?php

namespace app\common\behaviors;
use yii\db\BaseActiveRecord;
use yii\behaviors\AttributeBehavior;
class TimestampBehavior extends AttributeBehavior{
    //创建时要更新的字段(填写不存在的字段也无碍)
    public $onCreate = [];
    //更新时需要更新的字段
    public $onUpdate = [];
    public $value;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->onCreate = (array) $this->onCreate;
        $this->onUpdate = (array) $this->onUpdate;
        if (empty($this->attributes)) {
            //合并，去重复
            $this->attributes = [
                //创建时要更新的字段，需要去重复
                BaseActiveRecord::EVENT_BEFORE_INSERT => array_unique(array_merge($this->onCreate, $this->onUpdate)),
                //更新时要更新的字段
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->onUpdate,
            ];
        }
    }

    // 关键就在这里——剔除不存在的字段
    public function evaluateAttributes($event)
    {
        if (!empty($this->attributes[$event->name])) {
            //删掉不存在的字段
            $this->attributes[$event->name] = array_intersect($this->owner->attributes(), $this->attributes[$event->name]);
        }
        parent::evaluateAttributes($event);
    }

    // 这里没做改变
    protected function getValue($event)
    {
        if ($this->value === null) {
            return time();
        }

        return parent::getValue($event);
    }


    // 这里也没做改变
    public function touch($attribute)
    {
        $this->owner->updateAttributes(array_fill_keys((array) $attribute, $this->getValue(null)));
    }
}