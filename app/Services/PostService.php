<?php

namespace App\Services;

use App\Helpers\ApiResponse;
use App\Http\Resources\PostDetailResource;
use App\Http\Resources\PostResource;
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
        return $this->postRepository->getAll($category);
    }
    public function getPost(int $id)
    {
        return $this->postRepository->find($id);
    }
    public function getSelectedTags(int $id): array
    {
        return $this->postRepository->find($id)?->tags->pluck('id')->toArray() ?? [];
    }
    public function getEditData(int $id): array
    {
        $post = $this->getPost($id);
        
        return [
            'post' => $post,
            'selectedTags' => $post ? $this->getSelectedTags($id) : [],
            'categories' => $this->categoryRepository->getAll(),
            'tags' => $this->tagRepository->getAll()
        ];
    }
    public function create(array $data)
    {
        try {
            $post = $this->postRepository->create($data);
            if (isset($data['tags'])) {
                $post->tags()->attach(explode(',', $data['tags']));
            }
            return $post;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw $th;
        }
    }
    public function update(int $id, array $data)
    {
        try {
            $post = $this->getPost($id);
            
            $this->postRepository->update($id, $data);
            if (isset($data['tags'])) {
                $post['data']->tags()->sync(explode(',', $data['tags']));
            }
            return true;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw $th;
        }
    }
    public function delete(int $id)
    {
        $this->commentRepository->deleteByPost($id);
        $this->postRepository->delete($id);
        
    }

    //API
    public function getPostsApi(?string $category= null)
    {
        try {
            $data = $this->postRepository->getAll( $category );

            return ApiResponse::success(PostResource::collection($data), 'Posts retrieved successfully', Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error( 'Ups! Posts Not Found', Response::HTTP_NOT_FOUND);
        }
    }

    public function getPostApi(int $id)
    {
        try {
            $post = $this->postRepository->find($id);
            return ApiResponse::success(PostDetailResource::make($post), 'Post retrieved successfully', Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error('Ups! Posts Not Found', Response::HTTP_NOT_FOUND);
        }
    }

    public function deletePostApi(int $id)
    {
        try {
            $post = $this->postRepository->find($id);
            if (!$post) {
                return ApiResponse::error('Ups! Post Not Found', Response::HTTP_NOT_FOUND);
            }

            $this->postRepository->delete($id);
            $this->commentRepository->deleteByPost($id);
            return ApiResponse::success(null, 'Post deleted successfully', Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error('Ups! Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createPostApi(array $data)
    {
        try {
            $post = $this->postRepository->create($data);
            return ApiResponse::success(PostResource::make($post), 'Post created successfully', Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error('Ups! Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updatePostApi(int $id, array $data)
    {
        try {
            $this->postRepository->update($id, $data);

            $post = $this->getPost($id);
            if (!$post){
                return ApiResponse::error('Ups! Post Not Found', Response::HTTP_NOT_FOUND);
            }
            if (isset($data['tags'])) {
                $post['data']->tags()->sync(explode(',', $data['tags']));
            }
            return ApiResponse::success(PostResource::make($post), 'Post updated successfully', Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error('Ups! Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
