<?php

namespace app\models\ar;

/**
 * This is the ActiveQuery class for [[\app\models\TreatmentTimeUnit]].
 *
 * @see \app\models\ExperimentOld
 */
class ExperimentOldQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\ExperimentOld[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\ExperimentOld|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
