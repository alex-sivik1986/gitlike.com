<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\SignupForm;

class AuthController extends  Controller 
{
	/**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->response->redirect(['cabinet']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
	
	public function actionSignUp()
	{   
		$model = new SignupForm();
		if(Yii::$app->request->isPost)
		{
			$model->load(Yii::$app->request->post());
			if($model->signup())
			{
				return $this->redirect(['auth/login']);
			}
					
		}
			
		
		return $this->render('sign-up',
		[
			'model' => $model,
		]);
	}

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
	
	
}

?>