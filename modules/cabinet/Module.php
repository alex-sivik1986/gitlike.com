<?php

namespace app\modules\cabinet;

use Yii;
use yii\filters\AccessControl;
/**
 * cabinet module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
	public $cabinet = '/cabinet';
    public $controllerNamespace = 'app\modules\cabinet\controllers';

    /**
     * {@inheritdoc}
     */
	
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['login', 'logout', 'signup'],
				'rules' => [
					[
						'allow' => true,
						'actions' => ['login', 'signup'],
						'roles' => ['?'],
					],
					[
						'allow' => true,
						'actions' => ['logout'],
						'roles' => ['@'],
					],
				],
			],
		];
	}	
	
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
