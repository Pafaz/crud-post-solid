<?php

namespace App\Services;

use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Log;
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
        try {
            $data = $this->categoryRepository->getAll();
            return $data;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function create(array $data)
    {
        try {
            $data = $this->categoryRepository->create($data);
            return $data;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    //API
    public function getCategoriesApi()
    {
        try {
            $data = $this->categoryRepository->getAll();
            return ApiResponse::success(CategoryResource::collection($data), 'Categories retrieved successfully', Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error('Ups! Categories Not Found', Response::HTTP_NOT_FOUND);
        }
    }

    public function createCategoryApi(array $data)
    {
        try {
            $category = $this->categoryRepository->create($data);
            return ApiResponse::success(CategoryResource::make($category), 'Category created successfully', Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error('Ups! Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}