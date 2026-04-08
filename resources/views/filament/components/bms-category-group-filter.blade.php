<div x-data="{ activeTab: 'HomePage' }" class="rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
    <!-- Tab Navigation -->
    <div class="flex flex-wrap border-b border-gray-200 dark:border-gray-700">
        @foreach($getGroups() as $groupName => $categories)
            <button
                @click="activeTab = '{{ $loop->index }}'"
                :class="{
                    'border-b-2 border-primary-600 text-primary-600': activeTab === '{{ $loop->index }}',
                    'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== '{{ $loop->index }}'
                }"
                class="flex-1 px-4 py-3 text-sm font-medium transition-colors duration-200"
            >
                {{ $groupName }}
            </button>
        @endforeach
    </div>

    <!-- Tab Content -->
    <div class="p-4">
        @foreach($getGroups() as $index => $categories)
            <div x-show="activeTab === '{{ $index }}'" class="space-y-2">
                @foreach($categories as $value => $label)
                    <label class="flex cursor-pointer items-center space-x-3 rounded px-3 py-2 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <input
                            type="radio"
                            name="{{ $getName() }}"
                            value="{{ $value }}"
                            {{ $getState() === $value ? 'checked' : '' }}
                            wire:model.live="{{ $getName() }}"
                            class="h-4 w-4 border-gray-300 text-primary-600 focus:ring-primary-500"
                        >
                        <span class="text-sm text-gray-700 dark:text-gray-300">
                            {{ $label }}
                        </span>
                    </label>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
