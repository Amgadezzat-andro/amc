<div class="space-y-4 p-1">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <div>
            <p class="text-gray-500">{{ __('Name') }}</p>
            <p class="font-medium">{{ $record->name }} {{ $record->surname }}</p>
        </div>
        <div>
            <p class="text-gray-500">{{ __('Position') }}</p>
            <p class="font-medium">{{ $record->job?->title ?: '-' }}</p>
        </div>
        <div>
            <p class="text-gray-500">{{ __('Email') }}</p>
            <p class="font-medium">{{ $record->email }}</p>
        </div>
        <div>
            <p class="text-gray-500">{{ __('Phone') }}</p>
            <p class="font-medium">{{ $record->phone }}</p>
        </div>
    </div>

    <div>
        <p class="text-gray-500 text-sm">{{ __('Message') }}</p>
        <p class="font-medium whitespace-pre-line">{{ $record->message ?: '-' }}</p>
    </div>

    <div class="pt-2 border-t">
        <p class="text-gray-500 text-sm mb-2">{{ __('Attachments') }}</p>
        <div class="flex flex-wrap gap-2">
            @if($record->cv)
                <a href="{{ asset('storage/' . $record->cv) }}" target="_blank" class="inline-flex items-center rounded-md px-3 py-2 text-xs font-medium bg-primary-600 text-white">
                    {{ __('Open CV') }}
                </a>
            @endif

            @if($record->cover_letter)
                <a href="{{ asset('storage/' . $record->cover_letter) }}" target="_blank" class="inline-flex items-center rounded-md px-3 py-2 text-xs font-medium bg-gray-700 text-white">
                    {{ __('Open Cover Letter') }}
                </a>
            @endif
        </div>
    </div>
</div>
