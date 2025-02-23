<?php
use App\Models\AcademyUser;
use Livewire\Volt\Component;

new class extends Component {
    public $test;

    public $roleCounts = [];
    public $studentCounts;
    public $studentsCount;
    public $usersCount;

    public function mount()
    {
        $this->test = ucfirst($this->test);
        $this->usersStat();
    }

    protected function usersStat()
    {
        $result = AcademyUser::query()->selectRaw('role, COUNT(*) as count, SUM(CASE WHEN academyAccess = true THEN 1 ELSE 0 END) as academy_users')->groupBy('role')->get();

        $this->roleCounts = $result->pluck('count', 'role');
        $this->studentCounts = $result->pluck('academy_users', 'role');
        $this->usersCount = $result->sum('count');
        $this->studentsCount = $result->sum('academy_users');
    }
};
?>

<div>
    {{-- Ne pas supprimer ce fichier tant que pas mis dans un dossier adapté --}}
    {{-- //2do (Tableau de cumuls d'users - Role/Student/Total - en 1 seule requête) → Lui trouver sa place dans academy ! --}}
    <p class="text-right">Nom du test : <b>{{ $test ?? 'no' }}</b></p>

    <p class="my-3 font-bold text-xl">Users (1 DB request) :</p>

    <table class="w-full max-w-52 mx-auto">
        <thead>
            <th class="rounded-tl-lg">Role</th>
            <th>Student</th>
            <th class="rounded-tr-lg">Total</th>
        </thead>
        <tbody>
            @foreach ($roleCounts as $role => $count)
                <tr class="!border-0">
                    <td class="border-b-gray-500 pl-3">{{ ucfirst($role) }}</td>
                    <td class="text-right border-b-gray-500 pr-7">{{ $studentCounts[$role] ?? 0 }}</td>
                    <td class="text-right border-b-gray-500 pr-7">{{ $count }}</td>
                </tr>
            @endforeach
            <tr>
                <td class="border-0 font-bold"></td>
                <td class="text-right font-bold border-0 pr-7">{{ $studentsCount }}</td>
                <td class="text-right font-bold border-0 pr-7">{{ $usersCount }}</td>
            </tr>
        </tbody>
    </table>

    {{-- {{ $users->pluck('name', 'role')->join(', ') }}
    --}}
</div>
