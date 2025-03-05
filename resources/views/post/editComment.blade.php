<x-app-layout class="min-h-max">
    <x-slot name="header">
        <div class="flex items-center justify-between">

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Detail Post {{ $post->title }}
            </h2>

            <a href="{{ route('posts.index') }}"
                class="inline-block px-7 py-1.5 overflow-hidden text-sm font-semibold transition-transform rounded-full group text-white  bg-gray-600 hover:bg-blue-600/70 hover:text-white hover:shadow-lg">
                <span before="Back to Posts"
                    class="relative py-1.5 transition-transform inline-block before:content-[attr(before)] before:py-1.5 before:absolute before:top-full group-hover:-translate-y-full">Back
                    to Posts</span>
            </a>
        </div>
    </x-slot>

    <x-succes-notification>
        {{ session('success') }}
    </x-succes-notification>

    {{-- article --}}
    <div
        class="p-4 ml-16 my-7 max-w-3xl flex flex-col justify-between gap-2 border rounded-lg shadow-md bg-white dark:bg-gray-700 dark:border-gray-400/40">
        <div class="flex justify-between">
            <div>
            <h2 class="text-xl font-semibold text-blue-700 hover:underline two-lines dark:text-blue-100">
                {{ $post->title }}
            </h2>
            <p class="text-gray-500 dark:text-gray-300 text-sm">by <em>{{ $post->user->name }}</em></p>
            </div>
            <button class="text-gray-500 dark:text-gray-300">
                {{ $post->category->name }}
            </button>
        </div>

        <div class="flex flex-wrap gap-2 text-xs text-gray-600 dark:text-gray-300">
            @foreach ($post->tags as $tag)
                <span class="px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-600">
                    {{ $tag->name }}
                </span>
            @endforeach

        </div>

        <p class="text-gray-800 two-lines dark:text-gray-300 bg-gray-900 rounded-md p-5 mt-4">
            {{ $post->content }}
        </p>

        <div class="flex items-center justify-between text-sm">
            <p class="text-gray-500 dark:text-gray-300 text-xs">
                {{ $post->updated_at != $post->created_at
                    ? 'Updated on ' . $post->updated_at->setTimezone('Asia/Jakarta')->format('d F, Y H:i')
                    : 'Published on ' . $post->created_at->setTimezone('Asia/Jakarta')->format('d F, Y H:i') }}
            </p>

            <div class="flex gap-2">
                <a href="{{ route('posts.edit', $post->id) }}" class="text-blue-700 hover:underline dark:text-white">
                    Edit
                </a>

                <form action="{{ route('posts.destroy', $post->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-blue-700 hover:underline dark:text-white">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- comments --}}
    @foreach ($post->comments as $comment)
    <div
        class="p-4 ml-16 my-7 max-w-3xl h-min flex flex-col justify-between gap-2 border rounded-lg shadow-md bg-white dark:bg-gray-700 dark:border-gray-400/40">
        <div class="flex justify-between">
            <div class="flex items-center gap-2">
                <img class="w-8 h-8 rounded-full" src="{{ asset('/assets/image/profile.png' ) }}" alt="profile">
                <h2 class="text-sm font-semibold text-blue-700 hover:underline two-lines dark:text-blue-100">
                    {{ $comment->user->name }}
                </h2>
            </div>

            <p class="text-gray-500 dark:text-gray-300 text-xs">
                {{ $comment->updated_at != $comment->created_at
                    ? 'Updated on ' . $comment->updated_at->setTimezone('Asia/Jakarta')->format('d F, Y H:i')
                    : 'Published on ' . $comment->created_at->setTimezone('Asia/Jakarta')->format('d F, Y H:i') }}
            </p>
        </div>
        

        <p id="comment-{{ $comment->id }}" class="text-gray-800 two-lines h-full dark:text-gray-300 ">
            {{ $comment->content }}
        </p>

        <div class="flex items-center justify-end text-sm -mt-5">
            <div class="flex gap-2">
                <a href="{{ route('comments.edit', $comment->id) }}" class="text-blue-700 hover:underline dark:text-white">
                    Edit
                </a>

                <form action="{{ route('comments.destroy', $comment->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-blue-700 hover:underline dark:text-white">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    {{-- form add comment --}}
    <div>
        <form action="{{ route('comments.update') }}" method="post" id="form-comment">
            @csrf
            @method('PUT')
            <div class="w-3/6 fixed bottom-1 left-0 right-0 mx-auto p-4 bg-white dark:bg-gray-700 dark:border-gray-400/40 border rounded-lg h-40">
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <input type="hidden" name="content" id="hidden-input">
                <textarea id="content" cols="30" rows="10"
                class="w-full h-full resize-none p-2 border rounded-md dark:bg-gray-900 dark:text-gray-300" placeholder="Add Comment">{{ $comment->content }}</textarea>
                <button type="submit" class="absolute bottom-5 right-5 px-4 py-2 text-white bg-gray-600 rounded-lg hover:bg-gray-700">Send</button>
            </div>
        </form>
    </div>
</x-app-layout>

<script>
    const textarea = document.getElementById('content');
    const hiddenInput = document.getElementById('hidden-input');
    const form =document.getElementById('form-comment');

    textarea.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            if (e.shiftKey) {
                // Jika Shift + Enter ditekan, buat baris baru
                e.preventDefault();
                const cursorPos = textarea.selectionStart;
                const textBefore = textarea.value.substring(0, cursorPos);
                const textAfter = textarea.value.substring(cursorPos);
                textarea.value = textBefore + "\n" + textAfter;
                textarea.selectionStart = textarea.selectionEnd = cursorPos + 1; // Pindah cursor ke baris baru
            } else {
                // Jika hanya Enter, submit form
                e.preventDefault();
                hiddenInput.value = textarea.value; // Copy teks ke hidden input
                form.submit(); // Submit form
            }
        }
    });
</script>