<?php

use App\Models\User;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\WithPagination; 
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;

new 
#[Layout('components.layouts.admin')]
class extends Component {

    use Toast, WithPagination;

    public string $search = '';
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];
    public string $role = 'all';

    // Supprimer un utilisateur.
    public function deleteUser(User $user): void
    {
        $user->delete();
        $this->success("$user->name deleted");
    }

    // Définir les en-têtes de table.
    public function headers(): array
    {
        return [
            ['key' => 'name', 'label' => __('Name')],
            ['key' => 'email', 'label' => 'E-mail'],
            ['key' => 'role', 'label' => __('Role')],
            ['key' => 'valid', 'label' => __('Valid')],
            ['key' => 'posts_count', 'label' => __('Posts')],
            ['key' => 'created_at', 'label' => __("Registration")],
        ];
    }

    // Récupérer la liste des utilisateurs avec les filtres et tri appliqués.
    public function users(): LengthAwarePaginator
    {
        return User::query()
            ->when($this->search, fn(Builder $q) => $q->where('name', 'like', "%$this->search%"))
            ->when($this->role !== 'all', fn(Builder $q) => $q->where('role', $this->role))
            ->withCount('posts')
            ->orderBy(...array_values($this->sortBy))
            ->paginate(10);
    }

    // Fournir les données nécessaires à la vue.
    public function with(): array
    {
        return [
            'users' => $this->users(),
            'headers' => $this->headers(),
            'roles' => [
                ['name' => __('All'),'id' => 'all'],
                ['name' => __('Administrators'),'id' => 'admin'],
                ['name' => __('Redactors'),'id' => 'redac'],
                ['name' => __('Users'),'id' => 'user'],                
            ]
        ];
    }
}; ?>

<div>
    <x-header title="{{__('Users')}}" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="{{__('Search...')}}"  wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
    </x-header>

    <x-radio inline :options="$roles" wire:model="role" wire:change="$refresh" />
    <br>

    <x-card>
        <x-table striped :headers="$headers" :rows="$users" :sort-by="$sortBy" link="/admin/users/{id}/edit" with-pagination>
            @scope('cell_name', $user)
                <x-avatar :image="Gravatar::get($user->email)" >
                    <x-slot:title>
                        {{ $user->name }}
                    </x-slot:title>
                </x-avatar>
            @endscope
            @scope('cell_valid', $user)
                @if($user->valid)
                    <x-icon name="o-check-circle" />
                @endif
            @endscope
            @scope('cell_posts_count', $user)
                @if($user->posts_count > 0)
                    <x-badge value="{{ $user->posts_count }}" class="badge-primary" />
                @endif             
            @endscope
            @scope('cell_created_at', $user)      
                {{ $user->created_at->isoFormat('LL') }}
            @endscope            
            @scope('actions', $user)
                <div class="flex">
                    <x-button icon="o-envelope" link="mailto:{{ $user->email }}" tooltip-left="{{ __('Send an email') }}" no-wire-navigate spinner class="btn-ghost btn-sm text-blue-500" />           
                    <x-button icon="o-trash" wire:click="deleteUser({{ $user->id }})" wire:confirm="{{__('Are you sure to delete this user?')}}" confirm-text="Are you sure?" tooltip-left="{{ __('Delete') }}" spinner class="btn-ghost btn-sm text-red-500" />
                </div>
            @endscope
        </x-table>
    </x-card>
</div>
