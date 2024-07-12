<?php

use Livewire\Volt\Component;
use App\Models\Note;

new class extends Component {
    public Note $note;
    public $heartCount;

    public function mount(Note $note)
    {
        $this->note = $note;
        $this->heartCount = $note->heart_count;
    }

    public function increaseHeartCount()
    {
        $this->heartCount++;
        $this->note->increment('heart_count');
    }
}; ?>

<div>
    <x-wui-button xs wire:click="increaseHeartCount" rose icon="heart" spinner>{{ $heartCount }}</x-wui-button>
</div>
