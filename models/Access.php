<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clndr_access".
 *
 * @property integer $id
 * @property integer $user_owner
 * @property integer $user_guest
 * @property string $create_at_date
 *
 * @property User $userGuest
 * @property User $userOwner
 */
class Access extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clndr_access';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_guest'], 'required'],
            [['user_guest'], 'integer'],
            //[['create_at_date'], 'safe'],
            [['user_guest'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_guest' => 'id']],
            //[['user_owner'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_owner' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_owner' => Yii::t('app', 'Владелец'),
            'user_guest' => Yii::t('app', 'Получатель'),
            'create_at_date' => Yii::t('app', 'Время передачи'),
        ];
    }

    public function beforeSave ($insert)
    {
        if (parent::beforeSave($insert))
        {
            if ($this->getIsNewRecord())
            {
                $this->user_owner = Yii::$app->user->identity->id;
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
    public function getUserGuest()
    {
        return $this->hasOne(User::className(), ['id' => 'user_guest']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'user_owner']);
    }
}
