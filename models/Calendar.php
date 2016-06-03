<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clndr_calendar".
 *
 * @property integer $id
 * @property string $text
 * @property integer $creator
 * @property string $create_at_date
 *
 * @property User $creator0
 */
class Calendar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clndr_calendar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'create_at_date'], 'required'],
            //[['creator'], 'integer'],
            [['create_at_date'], 'safe'],
            [['text'], 'string', 'max' => 255],
            //[['creator'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'text' => Yii::t('app', 'Название'),
            'creator' => Yii::t('app', 'Создатель'),
            'create_at_date' => Yii::t('app', 'Дата исполнения'),
        ];
    }


    public function beforeSave ($insert)
    {
        if (parent::beforeSave($insert))
        {
            if ($this->getIsNewRecord())
            {
                $this->creator = Yii::$app->user->identity->id;
            }
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator0()
    {
        return $this->hasOne(User::className(), ['id' => 'creator']);
    }
}
