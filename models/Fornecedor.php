<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fornecedor".
 *
 * @property integer $id
 * @property string $nome
 * @property string $cnpj
 * @property integer $endereco_id
 * @property string $email
 *
 * @property Endereco $endereco
 * @property ProdutoFornecedor[] $produtoFornecedors
 * @property Produto[] $produtos
 */
class Fornecedor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fornecedor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nome', 'cnpj', 'endereco_id', 'email'], 'required'],
            [['id', 'endereco_id'], 'integer'],
            [['nome', 'email'], 'string', 'max' => 100],
            [['cnpj'], 'string', 'max' => 20],
            [['endereco_id'], 'exist', 'skipOnError' => true, 'targetClass' => Endereco::className(), 'targetAttribute' => ['endereco_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'cnpj' => 'Cnpj',
            'endereco_id' => 'Endereco ID',
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEndereco()
    {
        return $this->hasOne(Endereco::className(), ['id' => 'endereco_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProdutoFornecedors()
    {
        return $this->hasMany(ProdutoFornecedor::className(), ['fornecedor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produto::className(), ['id' => 'produto_id'])->viaTable('produto_fornecedor', ['fornecedor_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return FornecedorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FornecedorQuery(get_called_class());
    }
}
