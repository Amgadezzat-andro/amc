<div class="space-y-4 p-1">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <div>
            <p class="text-gray-500">{{ __('First Name') }}</p>
            <p class="font-medium">{{ $record->first_name }}</p>
        </div>
        <div>
            <p class="text-gray-500">{{ __('Last Name') }}</p>
            <p class="font-medium">{{ $record->last_name }}</p>
        </div>
        <div>
            <p class="text-gray-500">{{ __('Company') }}</p>
            <p class="font-medium">{{ $record->company ?: '-' }}</p>
        </div>
        <div>
            <p class="text-gray-500">{{ __('Position') }}</p>
            <p class="font-medium">{{ $record->position ?: '-' }}</p>
        </div>
        <div>
            <p class="text-gray-500">{{ __('Email') }}</p>
            <p class="font-medium">{{ $record->email }}</p>
        </div>
        <div>
            <p class="text-gray-500">{{ __('Phone') }}</p>
            <p class="font-medium">{{ $record->phone }}</p>
        </div>
        <div>
            <p class="text-gray-500">{{ __('Location') }}</p>
            <p class="font-medium">{{ $record->location }}</p>
        </div>
    </div>

    <div>
        <p class="text-gray-500 text-sm">{{ __('Message') }}</p>
        <p class="font-medium whitespace-pre-line">{{ $record->message ?: '-' }}</p>
    </div>
</div>
