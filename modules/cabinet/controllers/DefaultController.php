<?php

namespace app\modules\cabinet\controllers;

use yii\web\Controller;

/**
 * Default controller for the `cabinet` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
		$client = new \Github\Client();
		$activity = $client->api('sivik1986')->starring()->configure('star')->all();
$repos = $client->api('alex-sivik1986')->repositories();

var_dump($activity); die;

        return $this->render('index');
    }
}
