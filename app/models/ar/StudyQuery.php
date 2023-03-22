<?php

namespace app\models\ar;

/**
 * This is the ActiveQuery class for [[Study]].
 *
 * @see Study
 */
class StudyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Study[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Study|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
