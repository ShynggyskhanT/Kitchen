<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Dishes\Dish;
use app\models\DishesIngredients\service\DishesIngredientsProcessing;
use app\models\Ingredients\dto\IngredientDto;
use app\models\Ingredients\form\IngredientForm;
use app\models\Ingredients\service\IngredientSearch;
use app\models\Ingredients\service\IngredientService;
use app\models\UserRoleEnum;
use app\shared\exception\FormValidationException;
use app\shared\exception\ModelSaveException;
use app\shared\exception\NotFoundException;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

final class IngredientsController extends Controller
{
    private DishesIngredientsProcessing $processing;
    private IngredientSearch $search;
    private IngredientService $service;

    public function __construct(
        string $id,
        Module $module,
        DishesIngredientsProcessing $processing,
        IngredientSearch $search,
        IngredientService $service
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
            'authenticator' => [
                'class' => HttpBearerAuth::class,
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'delete', 'view', 'create', 'update'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['disable', 'enable'],
                        'allow' => true,
                        'roles' => [UserRoleEnum::ADMIN]
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

    /**
     * @return Dish[]
     */
    public function actionIndex(): array
    {
        /** @todo: array of dtos | Collection */
        return $this->search->getAll()->getModels();
    }

    /**
     * @return IngredientDto
     * @throws FormValidationException
     * @throws ServerErrorHttpException
     */
    public function actionCreate(): IngredientDto
    {
        $form = new IngredientForm();
        $form->setAttributes($this->request->post());
        if ($form->validate() === false) {
            throw new FormValidationException($form);
        }

        try {
            $this->response->setStatusCode(201);
            return $this->service->create($form->toDto());
        } catch (ModelSaveException $e) {
            throw new ServerErrorHttpException($e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    /**
     * @param int $id
     * @return IngredientDto
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): IngredientDto
    {
        try {
            return $this->search->getById($id);
        } catch (NotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param int $id
     * @return IngredientDto
     * @throws FormValidationException
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionUpdate(int $id): IngredientDto
    {
        $form = new IngredientForm();
        $form->setAttributes($this->request->post());
        if ($form->validate() === false) {
            throw new FormValidationException($form);
        }

        try {
            return $this->service->update($id, $form->toDto());
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
        $this->processing->deleteIngredient($id);
        $this->response->setStatusCode(204);
    }

    /**
     * @param int $id
     * @return IngredientDto
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionDisable(int $id): IngredientDto
    {
        try {
            return $this->service->disable($id);
        } catch (NotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage(), $e->getCode(), $e);
        } catch (ModelSaveException $e) {
            throw new ServerErrorHttpException($e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    /**
     * @param int $id
     * @return IngredientDto
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionEnable(int $id): IngredientDto
    {
        try {
            return $this->service->enable($id);
        } catch (NotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage(), $e->getCode(), $e);
        } catch (ModelSaveException $e) {
            throw new ServerErrorHttpException($e->getMessage(), (int)$e->getCode(), $e);
        }
    }
}
