<?php

namespace abdualiym\block\controllers;

use abdualiym\block\entities\Categories;
use abdualiym\block\entities\Blocks;
use abdualiym\block\forms\BlocksSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BlocksController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Blocks models.
     * @return mixed
     */
    public function actionIndex($slug)
    {
        $searchModel = new BlocksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $slug);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'category' => Categories::findOne(['slug' => $slug])
        ]);
    }

    /**
     * Displays a single Blocks model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $slug)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'category' => Categories::findOne(['slug' => $slug])
        ]);
    }

    /**
     * Finds the Blocks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blocks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blocks::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('block', 'The requested page does not exist.'));
    }

    /**
     * Creates a new Blocks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($slug)
    {
        $model = new Blocks();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'slug' => $slug]);
        }

        return $this->render('create', [
            'model' => $model,
            'category' => Categories::findOne(['slug' => $slug])
        ]);
    }

    /**
     * Updates an existing Blocks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $slug)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'slug' => $slug]);
        }

        return $this->render('update', [
            'model' => $model,
            'category' => Categories::findOne(['slug' => $slug])
        ]);
    }

    /**
     * Deletes an existing Blocks model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $slug)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'slug' => $slug]);
    }
}
