<?php

namespace abdualiym\block\controllers;

use abdualiym\block\entities\Block;
use abdualiym\block\forms\BlockSearch;
use abdualiym\block\services\BlockManageService;
use Yii;
use yii\base\ViewContextInterface;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BlockController extends Controller implements ViewContextInterface
{
    private $service;

    public function __construct($id, $module, BlockManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }


    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'drop' => ['POST'],
                ],
            ],
        ];
    }


    public function getViewPath()
    {
        return Yii::getAlias('@vendor/abdualiym/yii2-block/views/block');
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $show = false)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                $model->save(false);
                return $this->redirect([$show ? 'show' : 'view', 'id' => $model->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param integer $id
     * @return Text the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Block
    {
        if (($model = Block::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested block does not exist.');
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }


    ######################################################################

    public function actionIndex()
    {
        $searchModel = new BlockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                $model->save(false);
                return $this->redirect(['show', 'id' => $model->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionAdd()
    {
        $model = new Block();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                $model->save(false);
                return $this->redirect(['show', 'id' => $model->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('add', [
            'model' => $model,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionShow($id)
    {
        return $this->render('show', [
            'model' => $this->findModel($id),
        ]);
    }



    #############################################################################

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDrop($id)
    {
        try {
            $this->findModel($id)->delete();
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['index']);
    }

}
