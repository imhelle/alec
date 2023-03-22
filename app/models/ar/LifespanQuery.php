<?php

namespace app\models\ar;

/**
 * This is the ActiveQuery class for [[Lifespan]].
 *
 * @see Lifespan
 */
class LifespanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Lifespan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Lifespan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
