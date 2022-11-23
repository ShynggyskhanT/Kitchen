<?php

declare(strict_types=1);

namespace app\models\DishesIngredients\service;

use app\models\Dishes\dto\DishDto;
use app\models\Dishes\dto\DishFormDto;
use app\models\Dishes\service\DishService;
use app\models\DishesIngredients\dto\DishesIngredientsDto;
use app\models\Ingredients\service\IngredientService;

final class DishesIngredientsProcessing
{
    private DishIngredientService $service;
    private DishService $dishService;
    private IngredientService $ingredientService;

    public function __construct(
        DishIngredientService $service,
        DishService $dishService,
        IngredientService $ingredientService
    ) {
        $this->service = $service;
        $this->dishService = $dishService;
        $this->ingredientService = $ingredientService;
    }

    public function deleteDish(int $dishId): void
    {
        $this->service->deleteByDish($dishId);
        $this->dishService->delete($dishId);
    }

    public function deleteIngredient(int $ingredientId): void
    {
        $this->service->deleteByIngredient($ingredientId);
        $this->ingredientService->delete($ingredientId);
    }

    public function createDish(DishFormDto $formDto, array $ingredients): DishDto
    {
        $dishDto = $this->dishService->create($formDto);

        foreach ($ingredients as $ingredientId) {
            $this->service->create(
                new DishesIngredientsDto(
                    ['dish_id' => $dishDto->id, 'ingredient_id' => $ingredientId]
                )
            );
        }

        return $dishDto;
    }

    public function updateDish(int $dishId, DishFormDto $formDto, array $ingredients): DishDto
    {
        $dishDto = $this->dishService->update($dishId, $formDto);
        $this->service->deleteByDish($dishId);

        foreach ($ingredients as $ingredientId) {
            $this->service->create(
                new DishesIngredientsDto(
                    ['dish_id' => $dishDto->id, 'ingredient_id' => $ingredientId]
                )
            );
        }

        return $dishDto;
    }
}