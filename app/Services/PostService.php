<?php

namespace App\Services;

use App\Helpers\Api;
use App\Interfaces\TagInterface;
use App\Interfaces\PostInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PostResource;
use App\Interfaces\CommentInterface;
use App\Interfaces\CategoryInterface;
use App\Http\Resources\PostDetailResource;
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
        $post = $this->postRepository->create($data);
        isset($data['tags']) && $post->tags()->sync(explode(',', $data['tags']));
        return $post;
    }
    public function update(int $id, array $data)
    {
        $post = $this->postRepository->find($id);
        $this->postRepository->update($id, $data);
        $post->refresh();
        isset($data['tags']) && $post->tags()->sync(explode(',', $data['tags']));
        return $post;
    }
    public function delete(int $id)
    {
        $this->commentRepository->deleteByPost($id);
        $this->postRepository->delete($id);
    }

    //API
    public function getPostsApi(?string $category= null)
    {
        $data = $this->postRepository->getAll($category);
        return Api::response(
            PostResource::collection($data), 
            'Posts retrieved successfully', 
        );
    }

    public function getPostApi(int $id)
    {
        $post = $this->postRepository->find($id);
        return Api::response(
            PostDetailResource::make($post), 
            'Post retrieved successfully', 
        );
    }

    public function deletePostApi(int $id)
    {
        DB::transaction(function () use ($id) {
            $this->postRepository->find($id)->delete(); 
            $this->commentRepository->deleteByPost($id);
        });
        return Api::response(
            null, 
            'Post deleted successfully', 
        );
    }

    public function createPostApi(array $data)
    {
        $post = $this->postRepository->create($data);
        return Api::response(
            PostResource::make($post), 
            'Post created successfully', 
            Response::HTTP_CREATED,
        );
    }

    public function updatePostApi(int $id, array $data)
    {
        $post = $this->postRepository->find($id);
        $this->postRepository->update($id, $data);
        $post->refresh();
        isset($data['tags']) && $post->tags()->sync(explode(',', $data['tags']));
        return Api::response(
            PostResource::make($post), 
            'Post updated successfully', 
        );
    }
}
