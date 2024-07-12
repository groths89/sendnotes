<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Note;

new #[Layout('layouts.app')] class extends Component {
    public Note $note;

    public $noteTitle;
    public $noteBody;
    public $noteRecipient;
    public $noteSendDate;
    public $noteIsPublished;

    public function mount(Note $note): void
    {
        $this->authorize('update', $note);
        $this->fill($note);
        $this->noteTitle = $note->title;
        $this->noteBody = $note->body;
        $this->noteRecipient = $note->recipient;
        $this->noteSendDate = $note->send_date;
    }

    public function saveNote(): void
    {
        $this->validate([
            'noteTitle' => ['required','string', 'min:5'],
            'noteBody' => ['required','string', 'min:20'],
            'noteRecipient' => ['required','email'],
            'noteSendDate' => ['required','date'],
            'noteIsPublished' => ['boolean'],
        ]);

        $this->note->update([
            'title' => $this->noteTitle, 
            'body' => $this->noteBody, 
            'recipient' => $this->noteRecipient, 
            'send_date' => $this->noteSendDate,
            'is_published' => true
        ]);

        $this->dispatch('note-saved');
    }
}; ?>

<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Edit Note') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-2xl mx-auto space-y-4 sm:px-6 lg:px-8">
        <form wire:submit='saveNote' class="space-y-4">
            <x-wui-input wire:model="noteTitle" label="Note Title" placeholder="It's been a great day." />
            <x-wui-textarea wire:model="noteBody" label="Your Note" placeholder="Share all of your thoughts with your friend." />
            <x-wui-input icon="user" wire:model="noteRecipient" label="Recipient" placeholder="yourfriend@email.com" type="email" />
            <x-wui-input icon="calendar" wire:model="noteSendDate" type="date" label="Send Date" />
            <x-wui-checkbox wire:model="noteIsPublished" label="Note Published" />
            <div class="pt-4 flex justify-between">
                <x-wui-button type="submit" secondary label="Save Note" spinner="saveNote" />
                <x-wui-button href="{{route('notes.index')}}" flat negative label="Back to Notes" />
            </div>
            <x-action-message on="note-saved" />
            <x-wui-errors />
        </form>
    </div>
</div>
