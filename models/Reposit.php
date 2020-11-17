<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reposit".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $like
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
            [['like'], 'integer'],
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
        ];
    }

    /**
     * Gets query for [[RepositLikes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRepositLikes()
    {
        return $this->hasMany(RepositLike::className(), ['reposit_id' => 'id']);
    }
}
