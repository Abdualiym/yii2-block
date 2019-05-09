<?php

namespace abdualiym\block\controllers;

use Yii;
use abdualiym\block\entities\ContentHistory;
use abdualiym\block\entities\ContentHistorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\ViewContextInterface;

/**
 * ActionsController implements the CRUD actions for Actions model.
 */
class ContentHistoryController extends Controller implements ViewContextInterface
{

    public function getViewPath()
    {
        return Yii::getAlias('@vendor/abdualiym/yii2-text/views/content-history');
    }


    public function actionIndex()
    {
        $searchModel = new ContentHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
