<section>
    <livewire:admin.resource-detail
        resourceName="attachment"
        :resourceClass="$attachment"
    />

    <x-admin-card title="" class="mt-2">
        <div class="post-details">
            <x-resource-detail
                property="id"
                :value="$this->attachment()->getKey()"
            />
            <x-resource-detail
                property="user"
                :value="$this->getUser()"
                isLink="true"
                :to="route('admin.users.show', ['user' => $this->getUser()])"
            />

            <x-resource-detail
                property="content"
                :value="__('Show attachment')"
                isLink="true"
                :to="$this->attachment()->getPublicUrl()"
            />
            <x-resource-detail
                property="original name"
                :value="$this->attachment()->getOriginalName()"
            />
            <x-resource-detail
                property="filename"
                :value="$this->attachment()->getFileName()"
            />
            <x-resource-detail
                property="checksum"
                :value="$this->attachment()->getChecksum()"
            />
            <x-resource-detail
                property="mimetype"
                :value="$this->attachment()->getMimeType()"
            />
            <x-resource-detail
                property="size"
                :value="$this->fileSize($this->attachment()->getSize())"
            />
            <x-resource-detail
                property="location"
                :value="$this->attachment()->getLocation()"
            />
            <x-resource-detail
                property="created at"
                :value="$this->attachment()->created_at"
            />
            <x-resource-detail
                property="deleted at"
                :value="$this->attachment()->deleted_at"
            />
        </div>
    </x-admin-card>

    <section class="relations">
        <x-resource-relation title="posts">
            <x-slot:actions>
                <x-button class="text-sm">Add post</x-button>
            </x-slot:actions>

            <x-slot name="tableHead">
                <th scope="col" class="py-3 text-xs md:text-md text-left">#</th>
                <th scope="col" class="py-3 text-xs md:text-md text-left">
                    Title
                </th>
                <th scope="col" class="py-3 text-xs md:text-md text-left">
                    Slug
                </th>
                <th scope="col" class="py-3 text-xs md:text-md text-left">
                    Type
                </th>
                <th scope="col" class="py-3 text-xs md:text-md text-left">
                    Status
                </th>
                <th scope="col" class="py-3 text-xs md:text-md text-left">
                    Action
                </th>
            </x-slot>

            @forelse ($this->getPosts() as $post)
            <tr
                class="text-left text-sm resource-tr"
                wire:key="{{ $post->getKey() }}"
            >
                <td class="py-3 text-xs md:text-base">{{ $post->getKey() }}</td>
                <td class="py-3 text-xs md:text-base">
                    {{ $post->getTitle() }}
                </td>
                <td class="py-3 text-xs md:text-base">{{ $post->toSlug() }}</td>
                <td class="py-3 text-xs md:text-base">
                    {{ $post->getType() }}
                </td>
                <td class="py-3 text-xs md:text-base">
                    {{ $post->getStatus() }}
                </td>
                <td class="py-3 text-xs md:text-base">
                    <x-iconed-link
                        :link="route('admin.posts.show', ['post' => $post])"
                        icon="visibility"
                    />
                </td>
            </tr>
            @empty @endforelse
        </x-resource-relation>
    </section>
</section>
