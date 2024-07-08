<?php

use Livewire\Volt\Component;
use App\Models\Note;

new class extends Component {
    public function delete($noteId)
    {
        $note = Note::where('id', $noteId)->first();
        $this->authorize('delete', $note);
        $note->delete();
    }

    public function with(): array
    {
        return [
            'notes' => Auth::user()->notes()->orderBy('send_date', 'asc')->get(),
        ];
    }
}; ?>

<div>
    <div class="space-y-2">
    @if ($notes->isEmpty())
        <div class="text-center">
            <p class="text-xl font-bold">No notes yet</p>
            <p class="mt-2 text-sm text-gray-500">Let's create your first note to send.</p>
            <x-wui-button primary right-icon="plus" class="p-4 mt-6" href="{{route('notes.create')}}" wire:navigate>Create note</x-wui-button>
        </div>
    @else
        <x-wui-button primary right-icon="plus" class="p-4 mt-6 mb-12" href="{{route('notes.create')}}" wire:navigate>Create note</x-wui-button>
        <div class="grid grid-cols-3 gap-4 mt-12">
        @foreach ($notes as $note)
            <x-wui-card wire:key='{{ $note->id }}' class="mt-12">
                <div class="flex justify-between">
                    <div>
                        <a href="{{ route('notes.edit', $note) }}" wire:navigate class="text-xl font-bold hover:underline hover:text-blue-500">
                            {{ $note->title }}
                        </a>
                        <p class="text-xs mt-2">{{ Str::limit($note->body, 50) }}</p>
                    </div>
                    <div class="text-2xs text-gray-500">
                        {{ \Carbon\Carbon::parse($note->send_date)->format('M-d-Y') }}
                    </div>
                </div>
                <div class="flex items-end justify-between mt-4 space-x-1">
                    <p class="text-sm text-gray-500">
                        Recipient: <span class="font-semi-bold">{{ $note->recipient }}</span>
                    </p>
                    <div>
                        <x-wui-mini-button rounded outline secondary icon="eye" />
                        <x-wui-mini-button rounded outline secondary icon="trash" wire:click="delete('{{ $note->id }}')" />
                    </div>
                </div>
            </x-wui-card>
        @endforeach
        </div>    
    @endif
    </div>
</div>
