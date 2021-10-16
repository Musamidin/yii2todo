<?php

namespace app\models;

use Yii;
use yii\behaviors\OptimisticLockBehavior;
use yii\db\StaleObjectException;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $title
 * @property int|null $priority
 * @property int|null $done
 * @property int|null $version
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'version'], 'required'],
            [['priority', 'done', 'version'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [
            OptimisticLockBehavior::class,
        ];
    }

    public function optimisticLock()
    {
        return 'version';
    }

    public function delete()
    {
        $result = false;
        if ($this->beforeDelete()) {
            $condition = $this->getOldPrimaryKey(true);
            $lock = $this->optimisticLock();
//            if ($lock !== null) {
//                $condition[$lock] = $this->owner->$lock;
//            }
            $result = $this->deleteAll($condition);
            if ($lock !== null && !$result) {
                throw new StaleObjectException('The object being deleted is outdated.');
            }
            $this->afterDelete();
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'priority' => 'Priority',
            'done' => 'Done',
            'version' => 'Version',
        ];
    }
}
