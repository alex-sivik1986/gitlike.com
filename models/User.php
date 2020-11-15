<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $password
 *
 * @property RepositLike[] $repositLikes
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username'], 'string', 'max' => 64],
            [['password'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
        ];
    }

    /**
     * Gets query for [[RepositLikes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRepositLikes()
    {
        return $this->hasMany(RepositLike::className(), ['user_id' => 'id']);
    }
	
	public static function findIdentity($id)
	{
		return User::findOne($id);
	}
	
	public function getAuthKey()
	{
		
	}
	
	public function validateAuthKey($authKey)
	{
		
	}
	
	public static function findIdentityByAccessToken($token, $type = null)
    {
 
    }
	
	public static function findByUsername($username)
	{
		return User::find()->where(['username' => $username])->one();
	}
	
	public function validatePassword($password)
	{
		return ($this->password == $password) ? true : false;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function create()
	{
		return $this->save(false);
	}
}
