@php($post = $post ?? null)

<div class="space-y-5">
    <div>
        <x-input-label for="title" value="Judul" />
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $post?->title)" />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="body" value="Isi Artikel" />
        <textarea id="body" name="body" rows="10"
            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('body', $post?->body) }}</textarea>
        <x-input-error :messages="$errors->get('body')" class="mt-2" />
    </div>

    <label class="inline-flex items-center gap-2">
        <input type="checkbox" name="is_published" value="1"
            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
            @checked(old('is_published', $post?->is_published ?? true))>
        <span class="text-sm text-gray-700">Langsung publish</span>
    </label>
</div>
