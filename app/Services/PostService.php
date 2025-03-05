<?php

namespace App\Services;

use App\Interfaces\TagInterface;
use App\Interfaces\PostInterface;
use Illuminate\Support\Facades\Log;
use App\Interfaces\CommentInterface;
use App\Interfaces\CategoryInterface;
use Symfony\Component\HttpFoundation\Response;

class PostService
{
    protected PostInterface $postRepository;
    protected CommentInterface $commentRepository;
    protected CategoryInterface $categoryRepository;
    protected TagInterface $tagRepository;
    public function __construct(
        PostInterface $postRepository, 
        CommentInterface $commentRepository,
        CategoryInterface $categoryRepository,
        TagInterface $tagRepository
    ) {
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
    }

    public function getPosts(?string $category= null)
    {
        try {
            $data = $this->postRepository->getAll( $category );

            return [
                'status' => 'success',
                'statusCode' => Response::HTTP_OK,
                'message' => 'Posts retrieved successfully',
                'data' => $data,
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [
                'status' => 'error',
                'statusCode' => Response::HTTP_NOT_FOUND,
                'message' => 'Posts Not Found',
                'data' => [],
            ];
        }
    }
    public function getPost(int $id)
    {
        try {
            $post = $this->postRepository->find($id);
            return [
                'status' => 'success',
                'statusCode' => Response::HTTP_OK,
                'message' => 'Post retrieved successfully',
                'data' => $post,
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [
                'status' => 'error',
                'statusCode' => Response::HTTP_NOT_FOUND,
                'message' => 'Ups! Post Not Found',
                'data' => [],
            ];
        }
    }
    public function getSelectedTags(int $id): array
    {
        return $this->postRepository->find($id)?->tags->pluck('id')->toArray() ?? [];
    }
    public function getEditData(int $id): array
    {
        $post = $this->getPost($id);
        
        return [
            'post' => $post['data'],
            'selectedTags' => $post ? $this->getSelectedTags($id) : [],
            'categories' => $this->categoryRepository->getAll()['data'],
            'tags' => $this->tagRepository->getAll()['data']
        ];
    }
    public function create(array $data)
    {
        try {
            $post = $this->postRepository->create($data);
            if (isset($data['tags'])) {
                $post->tags()->attach(explode(',', $data['tags']));
            }
            return [
                'status' => 'success',
                'statusCode' => Response::HTTP_CREATED,
                'message' => 'Post created successfully',
                'data' => $post,
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [
                'status' => 'error',
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Post Not Created',
                'data' => [],
            ];
        }
    }
    public function update(int $id, array $data)
    {
        try {
            $post = $this->getPost($id)['data'];
    
            $this->postRepository->update($id, $data);
            if (isset($data['tags'])) {
                $post['data']->tags()->sync(explode(',', $data['tags']));
            }
            return [
                'status' => 'success',
                'statusCode' => Response::HTTP_OK,
                'message' => 'Post updated successfully',
                'data' => $post,
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [
                'status' => 'error',
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Post Not Updated',
                'data' => [],
            ];
        }
    }
    public function delete(int $id)
    {
        try {
            $this->commentRepository->deleteByPost($id);
            $this->postRepository->delete($id);

            return [
                'status' => 'success',
                'statusCode' => Response::HTTP_OK,
                'message' => 'Post deleted successfully',
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [
                'status' => 'error',
                'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Post Not Deleted',
            ];
        }
    }
}
