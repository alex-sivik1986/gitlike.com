<?php

namespace app\models;

use yii\base\Model;


class SignupForm extends Model
{
	public $username;
	public $password;
	
	public function rules()
	{
		return [
		[['username','password'], 'required'],
		[['username'], 'string'],
		[['username'], 'unique', 'targetClass' => 'app\models\User', 'targetAttribute' => 'username']
		];
	}
	
	public function signup()
	{
		if($this->validate())
		{
			$user = new User();
			$user->attributes = $this->attributes;
			return $user->create();			
		}
	}
	
	
}


?>