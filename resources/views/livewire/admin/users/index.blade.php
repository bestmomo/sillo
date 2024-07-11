<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

new #[Title('Users'), Layout('components.layouts.admin')] class extends Component {
    use Toast;
    use WithPagination;

    public string $search = '';
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];
    public string $role = 'all';
    public array $roles = [];

    // Supprimer un utilisateur.
    public function deleteUser(User $user): void
    {
        $user->delete();
        $this->success("{$user->name} deleted");
    }

    // Définir les en-têtes de table.
    public function headers(): array
    {
        $headers = [['key' => 'name', 'label' => __('Name')], ['key' => 'email', 'label' => 'E-mail'], ['key' => 'role', 'label' => __('Role')], ['key' => 'isStudent', 'label' => __('Student')], ['key' => 'valid', 'label' => __('Valid')]];

        if ('user' !== $this->role) {
            $headers = array_merge($headers, [['key' => 'posts_count', 'label' => __('Posts')]]);
        }

        return array_merge($headers, [['key' => 'comments_count', 'label' => __('Comments')], ['key' => 'created_at', 'label' => __('Registration')]]);
    }

    // Récupérer la liste des utilisateurs avec les filtres et tri appliqués.
    public function users(): LengthAwarePaginator
    {
        // Récupération des utilisateurs paginés
        $users = User::query()
            ->when($this->search, function (Builder $query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->when('all' !== $this->role, function (Builder $query) {
                $query->where('role', $this->role);
            })
            ->withCount('posts', 'comments')
            ->orderBy(...array_values($this->sortBy))
            ->paginate(10);

        // Récupération du nombre d'utilisateurs par rôle
        $userCountsByRole = User::select('role', DB::raw('count(*) as total'))->groupBy('role')->pluck('total', 'role');

        // Calculer le nombre total d'utilisateurs à partir des comptes par rôle
        $totalUsers = $userCountsByRole->sum();

        // Création des rôles pour le choix avec 'all' inclus
        $roles = collect([
            'all' => __('All') . " ({$totalUsers})",
        ])
            ->merge(
                collect([
                    'admin' => __('Administrators'),
                    'redac' => __('Redactors'),
                    'user' => __('Users'),
                ])->map(function ($roleName, $roleId) use ($userCountsByRole) {
                    $count = $userCountsByRole->get($roleId, 0); // 0 si le rôle n'est pas trouvé

                    return "{$roleName} ({$count})";
                }),
            )
            ->map(function ($roleName, $roleId) {
                return ['name' => $roleName, 'id' => $roleId];
            })
            ->values()
            ->all();

        $this->roles = $roles;

        // Retourner les utilisateurs paginés
        return $users;
    }

    // Fournir les données nécessaires à la vue.
    public function with(): array
    {
        return [
            'users' => $this->users(),
            'rolesCount' => $this->users()['userCountsByRole'],
            'headers' => $this->headers(),
        ];
    }
}; ?>

<div>
    <x-header separator progress-indicator>
        <x-slot:title>
            <a href="/admin/dashboard" title="{{ __('Back to Dashboard') }}">
                {{ __('Users') }}
            </a>
        </x-slot:title>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="{{ __('Search...') }}" wire:model.live.debounce="search" clearable
                icon="o-magnifying-glass" />
        </x-slot:middle>
    </x-header>


    <x-radio inline :options="$roles" wire:model="role" wire:change="$refresh" />
    <br>

    <x-card>
        <x-table striped :headers="$headers" :rows="$users" :sort-by="$sortBy" link="/admin/users/{id}/edit"
            with-pagination>
            @scope('cell_name', $user)
                <x-avatar :image="Gravatar::get($user->email)">
                    <x-slot:title>
                        {{ $user->name }}
                    </x-slot:title>
                </x-avatar>
            @endscope
            @scope('cell_valid', $user)
                @if ($user->valid)
                    <x-icon name="o-check-circle" />
                @endif
            @endscope
            @scope('cell_role', $user)
                @if ($user->role === 'admin')
                    <x-badge value="{{ __('Administrator') }}" class="badge-error" />
                @elseif($user->role === 'redac')
                    <x-badge value="{{ __('Redactor') }}" class="badge-warning" />
                @elseif($user->role === 'user')
                    {{ __('User') }}
                @endif
            @endscope
            @scope('cell_isStudent', $user)
                @if ($user->isStudent)
                    <x-icon name="o-academic-cap" class="w-7 h-7 text-cyan-500" />
                @endif
            @endscope
            @scope('cell_posts_count', $user)
                @if ($user->posts_count > 0)
                    <x-badge value="{{ $user->posts_count }}" class="badge-primary" />
                @endif
            @endscope
            @scope('cell_comments_count', $user)
                @if ($user->comments_count > 0)
                    <x-badge value="{{ $user->comments_count }}" class="badge-success" />
                @endif
            @endscope
            @scope('cell_created_at', $user)
                {{ $user->created_at->isoFormat('LL') }}
            @endscope
            @scope('actions', $user)
                <div class="flex">
                    <x-popover>
                        <x-slot:trigger>
                            <x-button icon="o-envelope" link="mailto:{{ $user->email }}" no-wire-navigate spinner
                                class="text-blue-500 btn-ghost btn-sm" />
                        </x-slot:trigger>
                        <x-slot:content class="pop-small">
                            @lang('Send an email')
                        </x-slot:content>
                    </x-popover>
                    <x-popover>
                        <x-slot:trigger>
                            <x-button icon="o-trash" wire:click="deleteUser({{ $user->id }})"
                                wire:confirm="{{ __('Are you sure to delete this user?') }}" confirm-text="Are you sure?"
                                spinner class="text-red-500 btn-ghost btn-sm" />
                        </x-slot:trigger>
                        <x-slot:content class="pop-small">
                            @lang('Delete')
                        </x-slot:content>
                    </x-popover>
                </div>
            @endscope
        </x-table>
    </x-card>
</div>
