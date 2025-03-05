<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Articles') }}
        </h2>
    </x-slot>


    <div class="h-full w-full bg-gray-900 -mt-5">
        <section class="flex flex-col justify-center max-w-7xl px-4 py-10 mx-auto sm:px-6">

            <div class="flex items-center justify-between mb-5">

                <a href="{{ route('posts.create') }}"
                    class="inline-block px-7 py-1.5 overflow-hidden text-sm font-semibold transition-transform rounded-full group text-white  bg-gray-600 hover:bg-blue-600/70 hover:text-white hover:shadow-lg">
                    <span before="Create Post"
                        class="relative py-1.5 transition-transform inline-block before:content-[attr(before)] before:py-1.5 before:absolute before:top-full group-hover:-translate-y-full">Create
                        Post</span>
                </a>

                <x-dropdown>
                    <x-slot name="trigger">
                        <button
                            class="inline-block px-7 py-1.5 overflow-hidden text-sm font-semibold transition-transform rounded-full group text-white  bg-gray-600 hover:bg-blue-600/70 hover:text-white hover:shadow-lg">
                            <span before="Filter"
                                class="relative py-1.5 transition-transform inline-block before:content-[attr(before)] before:py-1.5 before:absolute before:top-full group-hover:-translate-y-full">Filter</span>
                        </button>
                    </x-slot>

                    <x-slot name="content" class="py-1 bg-white dark:bg-gray-700">
                        <a href="{{ route('posts.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                            All
                        </a>
                        @foreach ($categories as $category)
                            <form action="{{ route('posts.index') }}" method="GET" >
                                <input type="hidden" name="category" value="{{ $category->id }}">
                                <button type="submit"
                                    class="block px-4 w-full text-start py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    {{ $category->name }}
                                </button>
                            </form>
                        @endforeach

                    </x-slot>
                </x-dropdown>

            </div>

            @if ($posts->isEmpty())
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                {{ __('There are no posts!') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <x-succes-notification>
                {{ session('success') }}
            </x-succes-notification>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 px-1">
                @foreach ($posts as $post)
                    <div
                        class="p-4 flex flex-col justify-between gap-2 border rounded-lg shadow-md bg-white dark:bg-gray-700 dark:border-gray-400/40">
                        <div class="flex justify-between">
                            <a class="text-xl font-semibold text-blue-700 hover:underline two-lines dark:text-blue-100"
                                href="{{ route('posts.show', $post->id) }}">
                                {{ $post->title }}
                            </a>
                            <p class="text-gray-500 dark:text-gray-300 text-sm">by <em>{{ $post->user->name }}</em></p>
                        </div>
                        <div class="flex flex-wrap gap-2 text-xs text-gray-600 dark:text-gray-300">
                            @foreach ($post->tags as $tag)
                                <span class="px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-600">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>

                        <p class="text-gray-800 line-clamp-2 two-lines dark:text-gray-300 bg-gray-800 p-4 rounded-sm">
                            {{ Str::limit($post->content, 100, '...') }}
                        </p>

                        <div class="flex items-center justify-between text-sm">
                            <button class="text-gray-500 dark:text-gray-300">
                                {{ $post->category->name }}
                            </button>

                            <a href="{{ route('posts.show', $post->id) }}"
                                class="text-blue-700 hover:underline dark:text-white">
                                Read more
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</x-app-layout>
