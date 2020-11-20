<?php

namespace app\modules\cabinet\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use app\models\RepositLike;
use app\models\Reposit;
use app\models\User;
use yii\helpers\ArrayHelper;
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
		$model = new RepositLike();
		$client = new \Github\Client();
		$file = $client->api('repo')->all();
		$ar = $model->find()->where(['user_id' => Yii::$app->user->id])->asArray()->with('reposit')->all();
		$new = $file;
		
	if(!empty($ar)) {
		$new = array();
			foreach ($file as $git) { 	// формируем массив на основе лайков и дизлайков	
				foreach($ar as $likes) { 
					if($likes['reposit']['name']===$git['name'] && $likes['reposit']['id_list']==$git['id'])
					{   
						$git['like'] = $likes['like'];
						$git['dislike'] = $likes['dislike'];
					}
				}
				$new[] = $git;
			}
	}
		$provider = new ArrayDataProvider([
							'allModels' => $new,
							'pagination' => [
								'pageSize' => 50,
							],
							'sort' => [
								'attributes' => ['id', 'name'],
							],
						]);

        return $this->render('index', 
			[
				'repositories' => $provider,
			]);
    }
	
	public function actionSearch($reposit)
	{
		$model = new RepositLike();
		$client = new \Github\Client();
		$file = $client->api('search')->repositories($reposit, $sort = 'updated', $order = 'desc'); 
		
		$ar = $model->find()->where(['user_id' => Yii::$app->user->id])->asArray()->with('reposit')->all();
		$new = $file['items'];
		
	if(!empty($ar)) {
		$new = array();
			foreach ($file['items'] as $git) { 	// формируем массив на основе лайков и дизлайков	
				foreach($ar as $likes) { 
					if($likes['reposit']['name']===$git['name'] && $likes['reposit']['id_list']==$git['id'])
					{   
						$git['like'] = $likes['like'];
						$git['dislike'] = $likes['dislike'];
					}
				}
				$new[] = $git;
			}
	} 
		$provider = new ArrayDataProvider([
							'allModels' => $new,
							'pagination' => [
								'pageSize' => 50,
							],
							'sort' => [
								'attributes' => ['id', 'name'],
							],
						]);

        return $this->render('index', 
			[
				'repositories' => $provider,
			]);
		
		
	}
	
	public function actionReposit($name,$id)
	{  
		$model = new Reposit();
		$value = Yii::$app->request->get();
		$client = new \Github\Client();
		$file = $client->api('repo')->showById($value['id']); 
		$count = $model->find()->where(['id_list' => $value['id'], 'name' => $value['name']])->asArray()->one();
		$likes = RepositLike::find()->where(['reposit_id' => $count['id'], 'user_id' => Yii::$app->user->id])->one();


		return $this->render('repository',
			[
				'model' => $file,
				'count' => $count,
				'likes' => $likes
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
			
		$call = new RepositLike();
		$client = new \Github\Client();
		$file = $client->api('repo')->all();
		$ar = $call->find()->where(['user_id' => Yii::$app->user->id])->asArray()->with('reposit')->all();
	if(!empty($ar)) {
			foreach ($file as $git) { 		
				foreach($ar as $likes) { 
					if($likes['reposit']['name']===$git['name'] && $likes['reposit']['id_list']==$git['id'])
					{   
						$git['like'] = $likes['like'];
						$git['dislike'] = $likes['dislike'];
					}
				}
				$new[] = $git;
			}
	}
		$provider = new ArrayDataProvider([
							'allModels' => $new,
							'pagination' => [
								'pageSize' => 50,
							],
							'sort' => [
								'attributes' => ['id', 'name'],
							],
						]);
			
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
         return ['success' => true];
				
		}
		
	}
}
