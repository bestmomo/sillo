<x-card>
    <x-form wire:submit.prevent="save">
        <x-input type="text" wire:model="title" label="{{ __('Title') }}"
            placeholder="{{ __('Enter the title') }}" />
        <x-input type="text" wire:model="description" label="{{ __('Description') }}"
            placeholder="{{ __('Enter the description') }}" />
        <x-checkbox label="{{ __('Published') }}" wire:model="active" />
        @foreach ($questions as $qIndex => $question)
            <hr>
            <div class="flex flex-row justify-between">
                <x-badge value="Question {{ $qIndex + 1 }}" class="p-4 badge-accent" />
                @if ($qIndex > 1)
                    <x-button label="{{ __('Remove Question') }}"
                        wire:click.prevent="removeQuestion({{ $qIndex }})" class="btn-warning" />
                @endif
            </div>
            <x-input type="text" wire:model="questions.{{ $qIndex }}.question_text"
                label="{{ __('Question') }}" placeholder="{{ __('Enter the question text') }}" />
            <hr>

            @foreach ($question['answers'] as $aIndex => $answer)
                <x-input type="text"
                    wire:model="questions.{{ $qIndex }}.answers.{{ $aIndex }}.answer_text"
                    label="{{ __('Answer ') }} {{ $aIndex + 1 }}"
                    placeholder="{{ __('Enter the answer text') }}" />
                @if ($aIndex > 1)
                    <x-button label="{{ __('Remove Answer') }} {{ $aIndex + 1 }}"
                        wire:click.prevent="removeAnswer({{ $qIndex }}, {{ $aIndex }})"
                        class="btn-warning" />
                @else
                    <hr>
                @endif
            @endforeach

            <x-button label="{{ __('Add Answer') }}" wire:click.prevent="addAnswer({{ $qIndex }})"
                class="btn-primary" />
        @endforeach

        <x-button label="{{ __('Add Question') }}" wire:click.prevent="addQuestion" class="btn-info" />

        <x-slot:actions>
            <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                class="btn-primary" />
        </x-slot:actions>
    </x-form>
</x-card>    
