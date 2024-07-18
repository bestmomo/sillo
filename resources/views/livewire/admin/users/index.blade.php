<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

new #[Title('Users'), Layout('components.layouts.admin')] class extends Component {
    use Toast;
    use WithPagination;

    public string $search = '';
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];
    public string $role = 'all';
    public $isStudent = false;
    public array $rolesCount = [];
    protected $queryString = [
        'search' => ['except' => ''],
    ];

    // Fetch all users with filters and sorting.
    public function fetchUsers(): LengthAwarePaginator
    {
        $users = User::query()
            ->when($this->search, function (Builder $query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->when('all' !== $this->role, function (Builder $query) {
                $query->where('role', $this->role);
            })
            ->when($this->isStudent, function ($query) {
                $query->where('isStudent', true);
            })
            ->withCount('posts', 'comments')
            ->orderBy(...array_values($this->sortBy))
            ->paginate(10);

        // Récupération des statistiques globales
        $result = User::query()->selectRaw('role, COUNT(*) as count, SUM(CASE WHEN isStudent = true THEN 1 ELSE 0 END) as student_count')->groupBy('role')->get();

        $roleCounts = $result->pluck('count', 'role');
        $studentCounts = $result->pluck('student_count', 'role');
        $nbrUsers = $result->sum('count');
        $nbrStudents = $result->sum('student_count');

        // Préparation des rôles pour l'affichage
        $rolesCount = collect([
            'all' => __('All') . " ({$nbrUsers})",
        ])
            ->merge(
                collect([
                    'admin' => __('Administrators'),
                    'redac' => __('Redactors'),
                    'user' => __('Users'),
                ])->map(function ($roleName, $roleId) use ($roleCounts, $studentCounts) {
                    $count = $roleCounts->get($roleId, 0);
                    $studentCount = $studentCounts->get($roleId, 0);
                    $plur = $studentCount > 1 ? 's' : '';
                    $with = __('with');
                    $student = __('student');

                    return "{$roleName} ({$count}), {$with} {$studentCount} {$student}{$plur}";
                }),
            )
            ->map(function ($roleName, $roleId) {
                return ['name' => $roleName, 'id' => $roleId];
            })
            ->values()
            ->all();

        $this->rolesCount = $rolesCount;

        // Ajout des statistiques à chaque utilisateur
        $users->getCollection()->transform(function ($user) use ($roleCounts, $studentCounts) {
            $user->userCountsByRole = $roleCounts;
            $user->studentCountsByRole = $studentCounts;

            return $user;
        });

        // Stockage des statistiques globales
        $this->roleCounts = $roleCounts;
        $this->studentCounts = $studentCounts;
        $this->nbrUsers = $nbrUsers;
        $this->nbrStudents = $nbrStudents;

        $this->setPage(1);

        return $users;
    }

    // Supprimer un utilisateur.
    public function deleteUser(User $user): void
    {
        $user->delete();
        $this->success("{$user->name} " . __('deleted'));
    }

    // Fetch the necessary data for the view.
    public function with(): array
    {
        $roles = [
            'admin' => 'Administrator',
            'redac' => 'Redactor',
            'user' => 'User',
        ];

        return [
            'users' => $this->fetchUsers(),
            'headers' => $this->headers(),
            'roles' => $roles,
        ];
    }

    // Define table headers.
    public function headers(): array
    {
        $headers = [['key' => 'id', 'label' => '#'], ['key' => 'name', 'label' => __('Name')], ['key' => 'role', 'label' => __('Role')], ['key' => 'isStudent', 'label' => __('Status')], ['key' => 'valid', 'label' => __('Valid')]];

        if ('user' !== $this->role) {
            $headers = array_merge($headers, [['key' => 'posts_count', 'label' => __('Posts')]]);
        }

        return array_merge($headers, [['key' => 'comments_count', 'label' => __('Comments')], ['key' => 'created_at', 'label' => __('Registration')]]);
    }
}; ?>

<div>
    <x-header title="{{ __('Users') }}" separator progress-indicator>
        <x-slot:actions>
            <x-input placeholder="{{ __('Search...') }}" wire:model.live.debounce="search" clearable
                icon="o-magnifying-glass" />
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>

    <div class="my-1 mr-1 text-sm text-right">
        @if ($users->lastPage() > 1)
            Page {{ $users->currentPage() }} / {{ $users->lastPage() }}
        @else
            &nbsp;
        @endif
    </div>

    <x-radio inline :options="$rolesCount" wire:model="role" wire:change="$refresh" />

    <br>

    <x-card>

        @if (count($users))

            <x-table striped :headers="$headers" :rows="$users" :sort-by="$sortBy" link="/admin/users/{id}/edit"
                with-pagination>

                @scope('cell_id', $user)
                    <div class="!text-right">
                        {{ $user->id }}
                    </div>
                @endscope

                @scope('cell_name', $user)
                    <x-avatar :image="Gravatar::get($user->email)">
                        <x-slot:title>
                            <span class="font-bold">
                                {{ $user->name }} {{ $user->firstname }}
                            </span><br>
                            {{ $user->email }}
                        </x-slot:title>
                    </x-avatar>
                @endscope

                @scope('cell_valid', $user)
                    @if ($user->valid)
                        <x-icon-check />
                    @else
                        <x-icon-novalid />
                    @endif
                @endscope

                @scope('cell_role', $user)
                    @switch($user->role)
                        @case('admin')
                            <x-badge value="{{ __('Administrator') }}" class="p-3 badge-error" />
                        @break

                        @case('redac')
                            <x-badge value="{{ __('Redactor') }}" class="p-3 badge-warning" />
                        @break

                        @default
                            {{ __('User') }}
                    @endswitch
                @endscope

                @scope('cell_isStudent', $user, $roles)
                    @if ($user->isStudent)
                        <span
                            title="{{ trans_choice(':n is registered with the Academy', 'n', ['n' => $user->name]) }}
                            @if (!$user->valid) {{ __('But invalid status') }} @endif">

                            <x-icon name="o-academic-cap" :class="$user->valid ? 'text-cyan-500' : 'text-red-500'" style="width: 28px; height: 28px;" />
                        </span>
                    @else
                        <span
                            title="{{ trans_choice(':n is a :r not student', ['n', 'm'], ['n' => $user->name, 'r' => strtolower(__($roles[$user->role]))]) }}
                            {{ __('Not registered with the Academy') }}">
                            <x-icon name="o-user" class="text-gray-400 w-7 h-7" />
                        </span>
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
                                    wire:confirm="{{ __('Are you sure to delete this user?') }}"
                                    confirm-text="Are you sure?" spinner class="text-red-500 btn-ghost btn-sm" />
                            </x-slot:trigger>
                            <x-slot:content class="pop-small">
                                @lang('Delete')
                            </x-slot:content>
                        </x-popover>
                    </div>
                @endscope

            </x-table>
        @else
            <p>@lang('No users with these criteria.')</p>
        @endif
    </x-card>
</div>
