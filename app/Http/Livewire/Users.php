<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class Users extends Component
{
    public $name, $username, $email, $phone,  $cid, $role;
    public $code = "+234";

    // public User $users;

    public $update = false;
    public $form = false;

    public $selectedRole = null;
    public ?array $checked = [];
    public $perPage = 25;
    public $sortField = 'id';
    public $sortAsc = true;
    public $search = '';
    public $selectPage = false;

    use WithPagination;

    protected $listeners = [
        'deleteConfirm' => 'delete',
        'deleteMutipleConfirm' => 'buckDelete'
    ];
    // sorting column
    public function sortBy($field)
    {
        if ($this->sortField == $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    function refreshInputs()
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->role = '';
        $this->phone = '';
        $this->email = '';
        $this->code = "+234";
    }

    // protected $rules = [
    //     'first_name' => 'required',
    //     'last_name' => 'required',
    //     'email' => 'required|email|unique:users',
    //     'phone' => 'required|unique:users|numeric|digits_between:10,11',
    //     'role' => ['required', 'not_in:select,nurse,Nurse']
    // ];

    public function resetFilters()
    {
        $this->reset(['search', 'perPage', 'selected', 'checked']);
    }

    function save()
    {
        $data = $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users|numeric|digits_between:10,11',
            'role' => ['required', Rule::notIn(['nurse', 'Nurse']),]
        ]);

        $this->phone = trimPhone($this->code, $this->phone); //function from helpers,


        $user = User::create($data);
        $saved = $user->attachRole($this->role);

        try {

            if ($saved) {
                // welcome email to the users
                $user->notify(new WelcomeMessage($user));
                // send notifications to users(admins)
                // sendNotifyToAdmin($user);

                $this->form = false;
                session()->flash('success', $this->first_name . ' has been added to user');
                $this->refreshInputs();
            }
        } catch (\Throwable $e) {
            dd($e->getMessage());
        }



        return redirect()->back();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
    function add()
    {
        $this->update = false;
    }

    function showForm()
    {
        $this->form = true;
    }

    // colored each seleted rows
    function isChecked($id)
    {
        return in_array($id, $this->checked);
    }

    function updatedSelectPage($value)
    {
        if ($value) {
            $this->checked = $this->users->pluck('id')->toArray();
        } else {
            $this->checked = [];
        }
    }

    //
    function updatedChecked()
    {
        $this->selectPage = false;
    }


    public function confirmDelete($id)
    {

        $user = User::findOrFail($id);

        $this->delete = $id;
        $this->dispatchBrowserEvent('swal:confirm');
    }

    public function delete()
    {

        $user = User::with('roles')->findOrFail($this->delete);
        $true = $user->delete();

        if ($true) {
            session()->flash('success', $user->first_name . ' has been removed as user');
        }
        $this->resetPage();
        $this->checked = [];
        $this->update = false;
        $this->search = '';

        // return redirect()->route('user');
    }
    // confirmation of multiple delete
    function deleteMutiple()
    {
        // $checked = $this->checked;
        $this->dispatchBrowserEvent('swal:multiple');
    }

    // buck delete
    function buckDelete()
    {
        $users = User::findMany($this->checked);
        $true = $users->each->delete();

        if ($true) {
            session()->flash('success', count($this->checked) . ' user  deleted successfully');
        }
        $this->resetPage();
        $this->checked = [];
        $this->update = false;
        $this->search = '';

        return redirect()->route('user');
    }

    public function render()
    {
        $term = "%$this->search%";
        $users = User::with(['profile', 'roles'])
            ->where('name', 'LIKE', $term)
            ->orWhere('username', 'LIKE', $term)
            ->orWhere('email', 'LIKE', $term)
            ->orWhereHas('roles', function (Builder $query) {
                $term = "%$this->search%";
                $query->where('name', strtolower($term));
            })
            ->orWhereHas('profile', function (Builder $query) {
                $term = "%$this->search%";
                $query->where('country', 'LIKE', $term)
                    ->orWhere('wallet_type', 'LIKE', $term)
                    ->orWhere('state', 'LIKE', $term);
            })
            ->paginate($this->perPage);
        return view('livewire.users', compact(['users']));
    }
}