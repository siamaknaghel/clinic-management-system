<!-- resources/views/filament/components/infolists/file-list.blade.php -->

<div>
    @if(is_array($files) && count($files) > 0)
        <ul class="space-y-1">
            @foreach($files as $path)
                @if($path)
                    <li>
                        <a href="{{ asset('storage/' . $path) }}"
                           target="_blank"
                           class="text-primary-600 hover:underline flex items-center gap-1 text-sm font-medium">
                            <x-heroicon-o-document-text class="w-4 h-4" />
                            <span>{{ basename($path) }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    @else
        <span class="text-gray-500 text-sm">No files attached.</span>
    @endif
</div>
