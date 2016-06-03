<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    const MAX_STRING_NAME = 45;
    const MIN_STRING_NAME = 3;
    const MAX_STRING_USERNAME = 128;
    const MIN_STRING_USERNAME = 3;
    const MAX_STRING_PASS = 20;
    const MIN_STRING_PASS = 6;


    public function rules()
    {
        return [
            [['username', 'name', 'surname', 'password'], 'required'],
            [['password'], 'string', 'min' => self::MIN_STRING_PASS],
            [['username', 'access_token'], 'unique']
        ];
    }

    public static function tableName ()
    {
        return 'clndr_user';
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
                //echo $this->salt;
            }
            if (!empty($this->password))
            {
                $this->password = $this->passWithSalt($this->password, $this->salt);
                //echo $this->password . " - pass"; 
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
        if($accessToken)
            return $accessToken;
        
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
        echo $this->password === $this->passWithSalt($password, $this->salt) . " - validatePassword";
         return $this->password === $this->passWithSalt($password, $this->salt);
    }

    public function setPassword($password)
    {
        $this->password = $this->passWithSalt($password, $this->generateSalt());
        echo $this->password . " - setPassword";
    }   

    public function generateSalt()
    {
       return hash("sha512", uniqid('salt_', true));
    }

    public function passWithSalt ($password, $salt)
    {
        return hash("sha512", $password . $salt);
    }

    public function generateAuthKey()
    {
        $this->access_token = Yii::$app->getSecurity()->generateRandomString();
    }
}
