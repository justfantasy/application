<?php

namespace common\base;

use yii\base\InvalidCallException;
use yii\db\ActiveRecord;
use yii\db\Exception;

class Model extends ActiveRecord
{
    /**
     * 重构fields，默认返回查询出来的关联关系表
     */
    public function fields()
    {
        $relatedFields = array_keys($this->getRelatedRecords());

        return array_merge(
            parent::fields(),
            array_combine($relatedFields, $relatedFields)
        );
    }

    /**
     * 多对多关联中间表，注意该方法只适用于最简单的中间表ID关联
     * @return void
     * @throws Exception
     */
    public function simpleLinkVia($name, $linkIds, $insert)
    {
        if ($insert && !$linkIds) {
            return;
        }

        if ($this->getIsNewRecord()) {
            throw new InvalidCallException('Unable to link models: the models being linked cannot be newly created.');
        }

        if (!$insert) {
            $this->unlinkAll($name, true);
        }

        $relation = $this->getRelation($name);

        if (count($relation->link) > 1 || count($relation->via->link) > 1) {
            throw new InvalidCallException('该方法仅适用于最简单的ID中间表关联，请检查！');
        }

        $idName = array_keys($relation->link)[0];
        $linkName = array_values($relation->link)[0];
        $viaName = array_keys($relation->via->link)[0];
        $viaTable = reset($relation->via->from);
        $columnNames = [$viaName, $linkName];
        $columnValues = [];
        foreach ($linkIds as $id) {
            $columnValues[] = [$this->$idName, $id];
        }

        static::getDb()->createCommand()->batchInsert($viaTable, $columnNames, $columnValues)->execute();
    }
}
