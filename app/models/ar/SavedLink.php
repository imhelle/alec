<?php

namespace app\models\ar;

use Yii;

/**
 * This is the model class for table "alec_saved_link".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $link
 * @property string|null $url
 * @property string|null $chart
 * @property string|null $timestamp
 */
class SavedLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alec_saved_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['chart'], 'string'],
            [['link', 'url', 'timestamp'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'link' => Yii::t('app', 'Link'),
            'url' => Yii::t('app', 'Url'),
            'chart' => Yii::t('app', 'Chart'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return SavedLinkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SavedLinkQuery(get_called_class());
    }
}
