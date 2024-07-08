<?php

use Livewire\Volt\Component;

new class extends Component {
    public $noteTitle;
    public $noteBody;
    public $noteRecipient;
    public $noteSendDate;

    public function submit(): void
    {
        $validated = $this->validate([
            'noteTitle' => ['required','string', 'min:5'],
            'noteBody' => ['required','string', 'min:20'],
            'noteRecipient' => ['required','email'],
            'noteSendDate' => ['required','date'],
        ]);

        auth()->user()->notes()->create([
            'title' => $this->noteTitle,
            'body' => $this->noteBody,
            'recipient' => $this->noteRecipient,
            'send_date' => $this->noteSendDate,
            'is_published' => false,
            'heart_count' => 0,
        ]);
        
        redirect(route('notes.index'));

        //$this->emit('refreshNotes');

        //$this->emit('closeModal');
    }
}; ?>

<div>
    <form wire:submit='submit' class="space-y-4">
        <x-wui-input wire:model="noteTitle" label="Note Title" placeholder="It's been a great day." />
        <x-wui-textarea wire:model="noteBody" label="Your Note" placeholder="Share all of your thoughts with your friend." />
        <x-wui-input icon="user" wire:model="noteRecipient" label="Recipient" placeholder="yourfriend@email.com" type="email" />
        <x-wui-input icon="calendar" wire:model="noteSendDate" type="date" label="Send Date" />
        <div class="pt-4">
            <x-wui-button wire:click="submit" primary right-icon="calendar" label="Schedule Note" spinner />
        </div>
        <x-wui-errors />
    </form>
</div>
