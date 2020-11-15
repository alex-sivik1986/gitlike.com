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

		$token = '3851253c80a907f50bca5fcaf8f4d93856e890f4'; # https://help.github.com/en/articles/creating-a-personal-access-token-for-the-command-line
		$client = new \Github\Client();
		$client->authenticate($token,null,\Github\Client::AUTH_HTTP_TOKEN);

		$file = $client->api('user')->repositories('anotherjesse', $type = 'owner', $sort = 'full_name', $direction = 'asc', $visibility = 'all', $affiliation = 'owner,collaborator,organization_member');

		var_dump($file);
 die;

        return $this->render('index');
    }
}
