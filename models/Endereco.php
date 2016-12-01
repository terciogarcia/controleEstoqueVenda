<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "endereco".
 *
 * @property integer $id
 * @property string $rua
 * @property string $bairro
 * @property string $cidade
 * @property string $estado
 * @property string $numero
 * @property string $cep
 * @property string $ponto_referencia
 * @property string $complemento
 *
 * @property Cliente[] $clientes
 * @property Fornecedor[] $fornecedors
 */
class Endereco extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'endereco';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'rua', 'bairro', 'cidade', 'estado', 'numero', 'cep', 'ponto_referencia', 'complemento'], 'required'],
            [['id'], 'integer'],
            [['rua', 'bairro', 'cidade', 'estado', 'ponto_referencia'], 'string', 'max' => 50],
            [['numero', 'cep'], 'string', 'max' => 10],
            [['complemento'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rua' => 'Rua',
            'bairro' => 'Bairro',
            'cidade' => 'Cidade',
            'estado' => 'Estado',
            'numero' => 'Numero',
            'cep' => 'Cep',
            'ponto_referencia' => 'Ponto Referencia',
            'complemento' => 'Complemento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientes()
    {
        return $this->hasMany(Cliente::className(), ['id_endereco' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFornecedors()
    {
        return $this->hasMany(Fornecedor::className(), ['endereco_id' => 'id']);
    }
}
