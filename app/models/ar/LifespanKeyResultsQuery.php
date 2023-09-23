<?php

namespace app\models\ar;

/**
 * This is the ActiveQuery class for [[LifespanKeyResults]].
 *
 * @see LifespanKeyResults
 */
class LifespanKeyResultsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return LifespanKeyResults[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return LifespanKeyResults|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
