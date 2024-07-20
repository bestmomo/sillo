<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Models\Survey;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

new #[Title('Quizzes'), Layout('components.layouts.admin')] class extends Component {
    use Toast, WithPagination;

    public array $sortBy = ['column' => 'title', 'direction' => 'asc'];
    public string $search = '';

    // Définir les en-têtes de la table
    public function headers(): array
    {
        return [['key' => 'title', 'label' => __('Title')], ['key' => 'description', 'label' => __('Description')], ['key' => 'user_name', 'label' => __('Creator')],  ['key' => 'participants_count', 'label' => __('Participations')]];
    }

    // Supprimer un sondage
    public function deleteSurvey(Survey $survey): void
    {
        $survey->delete();
        $this->success(__('Survey deleted'));
    }

    // Fournir les données nécessaires à la vue
    public function with(): array
    {
        return [
            'surveys' => Survey::select('id', 'title', 'description')
                ->orderBy(...array_values($this->sortBy))
                ->when(!Auth::user()->isAdmin(), fn(Builder $q) => $q->where('user_id', Auth::id()))
                ->when($this->search, fn(Builder $q) => $q->where('title', 'like', "%{$this->search}%"))
                ->withAggregate('user', 'name')
                ->withCount(['participants' => function (Builder $query) {
                        $query->select(DB::raw('count(distinct user_id)'));
                    }
                ])
                ->paginate(10),
            'headers' => $this->headers(),
        ];
    }
}; ?>

<div>
    <x-header title="{{ __('Surveys') }}" separator progress-indicator>
        <x-slot:actions>
            <x-input placeholder="{{ __('Search...') }}" wire:model.live.debounce="search" clearable
            icon="o-magnifying-glass" />
            <x-button label="{{ __('Add a survey') }}" class="btn-outline lg:hidden" link="{{ route('surveys.create') }}" />
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>

    <x-card>
        <x-table :headers="$headers" :rows="$surveys" :sort-by="$sortBy" link="/admin/surveys/{id}/edit" with-pagination>
            @scope('cell_participants_count', $surveys)
                @if ($surveys->participants_count > 0)
                    <x-badge value="{{ $surveys->participants_count }}" class="badge-primary" />
                @endif
            @endscope
            @scope('actions', $survey)
                <x-popover>
                    <x-slot:trigger>
                        <x-button icon="o-trash" wire:click="deleteSurvey({{ $survey->id }})"
                            wire:confirm="{{ __('Are you sure to delete this survey?') }}" spinner
                            class="text-red-500 btn-ghost btn-sm" />
                    </x-slot:trigger>
                    <x-slot:content class="pop-small">
                        @lang('Delete')
                    </x-slot:content>
                </x-popover>
            @endscope
        </x-table>
    </x-card>
</div>
