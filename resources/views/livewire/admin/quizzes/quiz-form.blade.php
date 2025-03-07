<x-card>
    <x-form wire:submit.prevent="save">
        <x-input type="text" wire:model="title" label="{{ __('Title') }}" placeholder="{{ __('Enter the title') }}" />
        <x-input type="text" wire:model="description" label="{{ __('Description') }}"
            placeholder="{{ __('Enter the description') }}" />
        <x-choices label="{{ __('Post') }}" wire:model="post_id" :options="$postsSearchable" option-label="title"
            hint="{{ __('Select a post or none, type to search') }}" debounce="300ms" min-chars="2"
            no-result-text="{{ __('No result found!') }}" single searchable />
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
                <x-checkbox wire:model="questions.{{ $qIndex }}.answers.{{ $aIndex }}.is_correct"
                    label="{{ __('Is Correct') }}" />
                @if ($aIndex > 2 && $aIndex == count($question['answers']) - 1)
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
