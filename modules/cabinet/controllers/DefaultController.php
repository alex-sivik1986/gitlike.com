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
		$like = 0;
		$dislike = 0;
		
		if(Yii::$app->request->isAjax) 
		{
			$value = Yii::$app->request->post(); 
			$repository = Reposit::findOne( ["name" => $value['name'], 'id_list' => $value['id']]); 
			
			if($value['act'] == 'like'){

				if (!isset($repository->like)) 
				{  // если впервые лайкают этот репозиторий
					$repository = new Reposit();
					$repository->name = $value['name'];
					$repository->id_list = $value['id'];
					$repository->dislike = 0; 
					$repository->like = 1;   
				} else {
					$repository->like +=1;
				}
					$like = 1;	
		
			} elseif($value['act'] == 'dislike') {
				if (!isset($repository->dislike)) 
				{  // если впервые дизлайкают этот репозиторий
					$repository = new Reposit();
					$repository->name = $value['name'];
					$repository->id_list = $value['id'];
					$repository->like = 0; 
					$repository->dislike = 1;
				} else {
					$repository->dislike +=1;
				}	
					$dislike = 1;				
			}
			
			if($repository->save())
			{
				$rest = $model->findOne( ["reposit_id" => $repository->id, 'user_id' => Yii::$app->user->id]); 

				if(!empty($rest)) {
                    $rest->delete();
				}
					$model->reposit_id = $repository->id;
					$model->like = $like;
					$model->dislike = $dislike;
					$model->user_id = Yii::$app->user->id;
					$model->save();
				
			}
				
		}
		
	}
}
