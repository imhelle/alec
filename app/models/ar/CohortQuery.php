<?php

namespace app\models\ar;

/**
 * This is the ActiveQuery class for [[Cohort]].
 *
 * @see Cohort
 */
class CohortQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Cohort[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Cohort|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
