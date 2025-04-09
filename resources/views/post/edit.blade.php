<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Post') }}
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

    @if ($errors->any())
    <div class="bg-red-500 text-white p-4 rounded-lg">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


    {{-- {{dd(($tags))}} --}}
    <div class="flex justify-evenly">
        <div class="max-w-xl flex w-full flex-col border rounded-lg bg-gray-800 p-8 mt-16">
            <form action="{{ route('posts.update', $post->id) }}" method="POST">
                @csrf
                @method('PUT')
                <h2 class="title-font mb-1 text-lg font-medium text-white">Edit Your Post Here</h2>
                <div class="mb-4">
                    <label for="title" class="text-base leading-7 text-white">Title</label>
                    <input type="title" placeholder="Your Title" id="title" name="title" value="{{ $post->title }}"
                        class="w-full rounded border border-white bg-gray-100 py-1 px-3 text-base leading-8 text-gray-700 outline-none transition-colors duration-200 ease-in-out focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" />
                </div>
                <div class="mb-4">
                    <label for="content" class="text-base leading-7 text-white">Content</label>
                    <textarea id="content" placeholder="Your Content" name="content"
                        class="h-32 w-full resize-none rounded border border-gray-300 bg-white py-1 px-3 text-base leading-6 text-gray-700 outline-none transition-colors duration-200 ease-in-out focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">{{ $post->content }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="category" class="text-base leading-7 text-white">Category</label>
                    <select id="category" name="category"
                        class="w-full rounded border border-gray-300 bg-white py-1 px-3 text-base leading-8 text-gray-700 outline-none transition-colors duration-200 ease-in-out focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                    </select>
                    <button type="button" onclick="showCategoryModal()" class="text-sm leading-7 text-blue-400">Create
                        new Category</button>
                </div>

                <div class="mb-4 flex flex-col">
                    <label class="text-base leading-7 text-white">Tag</label>
                    <div class="flex flex-wrap gap-2 ">
                        <div id="selected-tags" class="flex gap-2 mt-2"></div>
                    </div>
                    <input type="hidden" name="tags" id="hidden-tags" value="">
                </div>

                {{-- <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
        @foreach ($tags as $tag)
          <label class="inline-flex items-center">
            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="form-checkbox">
            <span class="ml-2 text-white">{{ $tag->name }}</span>
          </label>
        @endforeach
      </div> --}}

                {{-- <button type="button" onclick="showModal()" class="text-sm leading-7 text-blue-400">Create new Tag</button> --}}

                <button type="submit"
                    class="mt-4 inline-block w-full px-7 py-1.5 overflow-hidden text-sm font-semibold transition-transform rounded-full group text-white  bg-gray-600 hover:bg-blue-600/70 hover:text-white hover:shadow-lg">
                    <span before="Send Post"
                        class="relative py-1.5 transition-transform inline-block before:content-[attr(before)] before:py-1.5 before:absolute before:top-full group-hover:-translate-y-full">Send
                        Post</span>
                </button>
            </form>
        </div>

        {{-- Tag List --}}
        <div class="max-w-md max-h p-8 border rounded-lg bg-gray-800 overflow-hidden mt-16">
            <div class="px-4 py-2">
                <h2 class="text-white font-bold text-lg">Tag List</h2>
            </div>
            <form class="w-full max-w-sm mx-auto px-4 py-2" action="{{ route('tags.store') }}" method="POST">
                @csrf
                <div class="flex items-center border-b-2 border-blue-500 py-2">
                    <input name="tagName"
                        class="appearance-none bg-transparent border-none w-full text-white mr-3 py-1 px-2 leading-tight focus:outline-none"
                        type="text" placeholder="Create new Tag">
                    <button
                        class="flex-shrink-0 bg-blue-500 hover:bg-blue-700 border-blue-500 hover:border-blue-700 text-sm border-4 text-white py-1 px-2 rounded"
                        type="submit">
                        Add
                    </button>
                </div>
            </form>
            <ul class="divide-y divide-gray-200 px-4">
                @foreach ($tags as $tag)
                    <div class="flex items-center">
                        <input id="tag-{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}" type="checkbox" {{ in_array($tag->id, old('tags', $selectedTags ?? [])) ? 'checked' : '' }} 
                            class="h-4 w-4 text-blue-400 focus:ring-blue-500 border-gray-300 rounded form-checkbox"
                            onchange="updateTags({{ $tag->id }}, '{{ $tag->name }}')">
                        <label for="tag-{{ $tag->id }}" class="ml-3 block text-white">
                            <span class="text-sm font-medium">{{ $tag->name }}</span>
                        </label>
                        {{-- <button class="text-blue-400 hover:text-blue-600 ml-auto mt-2" type="button">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 32 32" stroke-width="1"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
    </button> --}}
                        <form class=" ml-auto mt-2" action="{{ route('tags.destroy', $tag->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-400 hover:text-red-600" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 32 32"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </form>

                    </div>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Create Category Modal --}}
    <dialog id="CategoryModal" class="p-6 bg-white rounded-lg shadow-lg w-[400px]">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Create New Category</h2> <!-- Diperbaiki -->
            <button onclick="closeCategoryModal()" class="text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
        </div>
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div>
                <label for="categoryName" class="block text-sm font-medium text-gray-700">Category Name</label>
                <input type="text" id="categoryName" name="categoryName"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                    required>
                    
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <!-- Diperbaiki -->
                <textarea id="description" name="description"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                    required></textarea>
                    
            </div>
            <div class="mt-4">
                <button type="submit"
                    class="inline-block w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">Create
                    Category</button> <!-- Diperbaiki -->
            </div>
        </form>
    </dialog>

</x-app-layout>

<script>
    function updateTags(tagId, tagName) {
        const hiddenInput = document.getElementById('hidden-tags');
        const selectedTagsContainer = document.getElementById('selected-tags');
        const checkbox = document.getElementById(`tag-${tagId}`);

        let selectedTags = hiddenInput.value ? hiddenInput.value.split(',') : [];
        if (checkbox.checked) {
            // Tambahkan nilai ke input hidden jika dicentang
            selectedTags.push(tagId);

            // Buat elemen span untuk menampilkan tag
            const tagSpan = document.createElement('span');
            tagSpan.textContent = tagName;
            tagSpan.setAttribute('id', `selected-tag-${tagId}`);
            tagSpan.classList.add('text-sm', 'text-white', 'bg-gray-500', 'p-1', 'rounded-lg');
            selectedTagsContainer.appendChild(tagSpan);
        } else {
            // Hapus nilai dari input hidden jika tidak dicentang
            selectedTags = selectedTags.filter(id => id != tagId);

            // Hapus elemen span dari tampilan
            const tagSpan = document.getElementById(`selected-tag-${tagId}`);
            if (tagSpan) {
                tagSpan.remove();
            }
        }

        // Perbarui input hidden dengan nilai terbaru
        hiddenInput.value = selectedTags;
    }


    function showCategoryModal() {
        document.getElementById("CategoryModal").showModal();
    }

    function closeCategoryModal() {
        document.getElementById("CategoryModal").close();
    }
</script>