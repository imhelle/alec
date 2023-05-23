<?php

namespace app\models\ar;

/**
 * This is the ActiveQuery class for [[SavedLink]].
 *
 * @see SavedLink
 */
class SavedLinkQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SavedLink[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SavedLink|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
