<?php

namespace abdualiym\text\controllers;

use abdualiym\block\entities\Meta;
use abdualiym\block\entities\Text;
use abdualiym\block\entities\TextMetaFields;
use abdualiym\block\forms\PhotosForm;
use abdualiym\block\forms\TextForm;
use abdualiym\block\forms\TextMetaFieldForm;
use abdualiym\block\forms\TextMetaFiledSearch;
use abdualiym\block\forms\BlockSearch;
use abdualiym\block\services\TextManageService;
use abdualiym\block\services\TextMetaFieldManageService;
use Yii;
use yii\base\ViewContextInterface;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class TextController extends Controller implements ViewContextInterface
{
    private $service;
    private $metaService;

    public function __construct($id, $module, TextManageService $service, TextMetaFieldManageService $metaService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->metaService = $metaService;
    }


    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'activate' => ['POST'],
                    'draft' => ['POST'],
                    'delete-photo' => ['POST'],
                    'move-photo-up' => ['POST'],
                    'move-photo-down' => ['POST'],
                ],
            ],
        ];
    }


    public function getViewPath()
    {
        return Yii::getAlias('@vendor/abdualiym/yii2-text/views/text');
    }


    public function actionIndex($page = false)
    {
        $searchModel = new BlockSearch($page);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'page' => $page
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $page = false)
    {
        $searchMetaFieldsModel = new TextMetaFiledSearch($id);
        $metaFieldProvider = $searchMetaFieldsModel->search(Yii::$app->request->queryParams);

        $text = $this->findModel($id);

        $photosForm = new PhotosForm();
        if ($photosForm->load(Yii::$app->request->post()) && $photosForm->validate()) {
            try {
                $this->service->addPhotos($text->id, $photosForm);
                return $this->redirect(['view', 'id' => $text->id, 'page' => $page]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('view', [
            'text' => $text,
            'page' => $page,
            'meta' => new TextMetaFieldForm(),
            'searchMetaFieldModel' => $searchMetaFieldsModel,
            'metaFieldProvider' => $metaFieldProvider,
            'photosForm' => $photosForm,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionCreate($page = false)
    {
        $form = new TextForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $text = $this->service->create($form);
                return $this->redirect(['view', 'id' => $text->id, 'page' => $page]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
            'page' => $page,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $page = false)
    {
        $text = $this->findModel($id);
        $form = new TextForm($text);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {

            try {
                $this->service->edit($text->id, $form);
                return $this->redirect(['view', 'id' => $text->id, 'page' => $page]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'text' => $text,
            'page' => $page,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * @param integer $idText
     * @return mixed
     */
    public function actionActivate($id)
    {
        try {
            $this->service->activate($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDraft($id)
    {
        try {
            $this->service->draft($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    ########################## Text Photos #################

    /**
     * @param integer $id
     * @param $photo_id
     * @return mixed
     */
    public function actionDeletePhoto($id, $photo_id, $page = false)
    {
        try {
            $this->service->removePhoto($id, $photo_id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'page' => $page, 'id' => $id, '#' => 'photos']);
    }

    /**
     * @param integer $id
     * @param $photo_id
     * @return mixed
     */
    public function actionMovePhotoUp($id, $photo_id, $page = false)
    {
        $this->service->movePhotoUp($id, $photo_id);
        return $this->redirect(['view', 'page' => $page, 'id' => $id, '#' => 'photos']);
    }

    /**
     * @param integer $id
     * @param $photo_id
     * @return mixed
     */
    public function actionMovePhotoDown($id, $photo_id, $page = false)
    {
        $this->service->movePhotoDown($id, $photo_id);
        return $this->redirect(['view', 'page' => $page, 'id' => $id, '#' => 'photos']);
    }


    ########################## Text Meta Fields #################

    /**
     * @return mixed
     */
    public function actionMetaCreate($id, $page = false)
    {
        $form = new TextMetaFieldForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $meta = $this->metaService->create($form);
//                return $this->redirect(['view', 'id' => $meta->text_id, 'page' => $page]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->redirect(['view', 'id' => $id, 'page' => $page]);
//        return $this->render('create', [
//            'model' => $form,
//            'page' => $page,
//        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionMetaUpdate($id, $page = true)
    {
        $meta = $this->findMetaModel($id);
        $form = new TextMetaFieldForm($meta);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->metaService->edit($id, $form);
                return $this->redirect(['view', 'id' => $meta->text_id, 'page' => $page]);
            } catch
            (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('meta-update', [
            'model' => $form,
            'meta' => $meta,
            'page' => $page,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionMetaDelete($id, $text_id, $page = true)
    {
        try {
            $this->metaService->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $text_id, 'page' => $page]);
    }


    /**
     * @param integer $id
     * @return Text the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Text
    {
        if (($model = Text::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested text does not exist.');
    }

    protected function findMetaModel($id): TextMetaFields
    {
        if (($model = TextMetaFields::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested text meta field does not exist.');
    }
}
