<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Dishes\service\DishSearch;
use app\models\Dishes\service\DishService;
use app\models\Dishes\dto\DishDto;
use app\models\Dishes\form\DishForm;
use app\models\DishesIngredients\service\DishesIngredientsProcessing;
use app\shared\exception\FormValidationException;
use app\shared\exception\ModelSaveException;
use app\shared\exception\NotFoundException;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

final class DishesController extends Controller
{
    private DishesIngredientsProcessing $processing;
    private DishSearch $search;
    private DishService $service;

    public function __construct(
        string $id,
        Module $module,
        DishesIngredientsProcessing $processing,
        DishSearch $search,
        DishService $service
    ) {
        $this->processing = $processing;
        $this->search = $search;
        $this->service = $service;
        /** @todo: fix */
        $this->enableCsrfValidation = false;
        parent::__construct($id, $module, []);
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'delete', 'view', 'create', 'update'],
                        'allow' => true,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['GET'],
                    'delete' => ['DELETE'],
                    'view' => ['GET'],
                    'update' => ['PUT'],
                    '*' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex(): void
    {
//        return $this->search->getAll()->getModels();
    }

    /**
     * @return DishDto
     * @throws FormValidationException
     * @throws ServerErrorHttpException
     */
    public function actionCreate(): DishDto
    {
        $form = new DishForm();
        $form->setAttributes($this->request->post());
        if ($form->validate() === false) {
            throw new FormValidationException($form);
        }

        try {
            $this->response->setStatusCode(201);
            return $this->processing->createDish($form->toDto(), $form->getIngredients());
        } catch (ModelSaveException $e) {
            throw new ServerErrorHttpException($e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    /**
     * @param int $id
     * @return DishDto
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): DishDto
    {
        try {
            return $this->search->getById($id);
        } catch (NotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param int $id
     * @return DishDto
     * @throws FormValidationException
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionUpdate(int $id): DishDto
    {
        $form = new DishForm();
        $form->setAttributes($this->request->post());
        if ($form->validate() === false) {
            throw new FormValidationException($form);
        }

        try {
            return $this->processing->updateDish($id, $form->toDto(), $form->getIngredients());
        } catch (NotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage(), $e->getCode(), $e);
        } catch (ModelSaveException $e) {
            throw new ServerErrorHttpException($e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    /**
     * @param int $id
     * @return void
     */
    public function actionDelete(int $id): void
    {
        $this->processing->deleteDish($id);
        $this->response->setStatusCode(204);
    }
}
