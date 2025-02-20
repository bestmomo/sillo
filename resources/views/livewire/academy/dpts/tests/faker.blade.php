<?php
use App\Models\AcademyUser;
use Livewire\Volt\Component;

new class extends Component {
    public $users;

    public function mount()
    {
        $this->users = $this->with();
    }

    public function with()
    {
        return AcademyUser::limit(7)->get('firstname');
    }
};
?>

<div>
    @dump($users)

    @forelse($users as $user)
        <p>{{ $user->firstname }}</p>
    @empty
        <p>No users found</p>
    @endforelse
</div>
