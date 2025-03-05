<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Interfaces\CategoryInterface;
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
            return [
                'status' => 'success',
                'statusCode' => Response::HTTP_OK,
                'message' => 'Categories retrieved successfully',
                'data' => $data,
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [
                'status' => 'error',
                'statusCode' => Response::HTTP_NOT_FOUND,
                'message' => 'Categories Not Found',
                'data' => [],
            ];
        }
    }

    public function create(array $data)
    {
        try {
            $data = $this->categoryRepository->create($data);
            return [
                'status' => 'success',
                'statusCode' => Response::HTTP_CREATED,
                'message' => 'Category created successfully',
                'data' => $data,
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [
                'status' => 'error',
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Something went wrong',
                'data' => [],
            ];
        }
    }

}