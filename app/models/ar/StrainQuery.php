<?php

namespace app\models\ar;

/**
 * This is the ActiveQuery class for [[Strain]].
 *
 * @see Strain
 */
class StrainQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Strain[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Strain|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
