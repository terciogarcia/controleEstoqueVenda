<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Fornecedor */

$this->title = 'Create Fornecedor';
$this->params['breadcrumbs'][] = ['label' => 'Fornecedors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fornecedor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
