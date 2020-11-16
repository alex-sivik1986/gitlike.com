<?php

namespace app\modules\cabinet\controllers;

use yii\web\Controller;
use yii\data\ArrayDataProvider;
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
		$file = $client->api('repo')->all();
        $provider = new ArrayDataProvider([
							'allModels' => $file,
							'pagination' => [
								'pageSize' => 50,
							],
							'sort' => [
								'attributes' => ['id', 'name'],
							],
						]);

        return $this->render('index', 
			[
				'repositories' => $provider
			]);
    }
}
