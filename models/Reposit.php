<?php

namespace app\models;

use Yii;
use app\models\RepositLike;
/**
 * This is the model class for table "reposit".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $like
 * @property int|null $dislike
 * @property int|null $id_list
 *
 * @property RepositLike[] $repositLikes
 */
class Reposit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reposit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['like', 'dislike', 'id_list'], 'integer'],
            [['name'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'like' => 'Like',
            'dislike' => 'Dislike',
            'id_list' => 'Id List',
        ];
    }

    /**
     * Gets query for [[RepositLikes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRepositLikes()
    {
        return $this->hasMany(RepositLike::className(), ['id' => 'reposit_id']);
    }
	
}
