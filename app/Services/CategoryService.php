<?php

namespace App\Services;

use App\Helpers\Api;
use App\Interfaces\CategoryInterface;
use App\Http\Resources\CategoryResource;
use Symfony\Component\HttpFoundation\Response;

class CategoryService 
{
    private CategoryInterface $categoryRepository;

    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategories()
    {
        return $this->categoryRepository->getAll();
    }

    public function create(array $data)
    {
        return $this->categoryRepository->create($data);
    }

    //API
    public function getCategoriesApi()
    {
        $data = $this->categoryRepository->getAll();
        return Api::response(
            CategoryResource::collection($data),
            'Categories retrieved successfully', 
        );
    }

    public function createCategoryApi(array $data)
    {
        $category = $this->categoryRepository->create($data);
        return Api::response(
            CategoryResource::make($category),
            'Category created successfully',
            Response::HTTP_CREATED
        );
    }

}