<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{


    public function rules()
    {
        return [
            [['username','access_token'], 'required'],
            ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['username', 'unique'],
            ['username', 'string', 'min' => 3, 'max' => 128],

            ['name', 'required'],
            ['name', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['name', 'string', 'min' => 3, 'max' => 45],

            ['surname', 'required'],
            ['surname', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['surname', 'string', 'min' => 3, 'max' => 45],

            ['password', 'required'],
            ['password', 'string', 'min' => 6, 'max' => 255],

        ];
    }

    public static function tableName ()
    {
        return 'evrnt_user';
    }

    public function attributeLabels ()
    {
        return [
            'id' => _('ID'),
            'username' => _('Логин'),
            'name' => _('Имя'),
            'surname' => _('Фамилия'),
            'password' => _('Пароль'),
            'salt' => _('Соль'),
            'access_token' => _('Ключ авторизации'),
        ];
    }

    public function beforeSave ($insert)
    {
        if (parent::beforeSave($insert))
        {
            if ($this->getIsNewRecord() && !empty($this->password))
            {
                $this->salt = $this->generateSalt();
            }
            if (!empty($this->password))
            {
                $this->password = $this->passWithSalt($this->password, $this->salt);
            }
            else
            {
                unset($this->password);
            }
            return true;
        }
        else
        {
            return false;
        }
    }
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $accessToken = static::findOne(['access_token' => $token]);
        if($token)
            return $token;
        
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = static::findOne(['username' => $username]);
        if($user)
            return $user;
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->access_token;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
         return $this->password === $this->passWithSalt($password, $this->salt);
    }

    public function setPassword($password)
    {
        $this->password = $this->passWithSalt($password, $this->generateSalt());
    }

    public function generateSalt()
    {
          return  Yii::$app->getSecurity()->hkdf('sha512', Yii::$app->security->generateRandomString());
    }

    public function passWithSalt($password,$salt)
    {
        return  Yii::$app->getSecurity()->hkdf('sha512', $password, $salt);
    }

    public function generateAuthKey()
    {
        $this->access_token = Yii::$app->getSecurity()->generateRandomString();
    }
}
