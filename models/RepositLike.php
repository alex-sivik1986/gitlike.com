<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reposit_like".
 *
 * @property int $id
 * @property int|null $reposit_id
 * @property int|null $user_id
 * @property int|null $like
 * @property int|null $dislike
 *
 * @property Reposit $reposit
 * @property User $user
 */
class RepositLike extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reposit_like';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reposit_id', 'user_id', 'like', 'dislike'], 'integer'],
            [['reposit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reposit::className(), 'targetAttribute' => ['reposit_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reposit_id' => 'Reposit ID',
            'user_id' => 'User ID',
            'like' => 'Like',
            'dislike' => 'Dislike',
        ];
    }

    /**
     * Gets query for [[Reposit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReposit()
    {
        return $this->hasOne(Reposit::className(), ['id' => 'reposit_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
