<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Experiment]].
 *
 * @see ExperimentOld
 */
class ExperimentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ExperimentOld[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ExperimentOld|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
