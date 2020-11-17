<?php

namespace app\modules\cabinet\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use app\models\RepositLike;
use app\models\Reposit;
use app\models\User;
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
	
	public function actionLiked()
	{	
		$model = new RepositLike();
		if(Yii::$app->request->isAjax) 
		{
			$value = Yii::$app->request->post(); 
			if($value['act'] == 'like'){
				$repository = Reposit::find( "name = :repository",array(':repository'=>$value['name']) )->one(); 
				
				if ($repository->like == null) 
				{  
					$repository = new Reposit();
					$repository->name = $value['name'];
					$repository->like = 1;   
				} else {
					$repository->like +=1;
				}
					$repository->save();
					
					
		
			} else {
					$repository = new Reposit();
					$repository->name = $value['name'];
					$repository->like = 0; 	
                    $repository->save();
					
					
			}
			
			
			
		}
		
	}
}
