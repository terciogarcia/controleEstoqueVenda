<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Fornecedor]].
 *
 * @see Fornecedor
 */
class FornecedorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Fornecedor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Fornecedor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
