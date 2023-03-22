<?php

namespace app\models\ar;

/**
 * This is the ActiveQuery class for [[DwellingType]].
 *
 * @see DwellingType
 */
class DwellingTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return DwellingType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return DwellingType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
