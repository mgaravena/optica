<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class LiveUserTable extends Component
{
    use WithPagination;

    public $search="";
    public $perPage=5;
    public $camp=null;
    public $order=null;
    public $icon= '-circle';
    

    protected $queryString = ['search' => ['except' => ''],
                              'camp' => ['except' => null],
                              'order' => ['except' => null],
    ];

    public function render()
    {
        $users = User::where('name','like',"%{$this->search}%")
                     ->orWhere('email','like',"%{$this->search}%");

        if ($this->camp && $this->order){
            $users = $users->orderBy($this->camp,$this->order);
        } else {
            $this->camp = null;
            $this->order = null;
        }
                     
        $users = $users->paginate($this->perPage);

        return view('livewire.live-user-table',[
            'users'=> $users
            
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function clear(){
        // reset lleva todas las variables publicas a su estado original
        $this->reset();
    }

    public function mount(){
        $this->icon = $this->iconDirection($this->order);
    }

    public function sortable($camp){

        if($camp !== $this->camp){
            $this->order = null;
        }
        switch($this->order){
             case null:
                $this->order='asc';
                $this->icon= '-arrow-circle-up';
                break;
             case 'asc':
                $this->order='desc';
                $this->icon= '-arrow-circle-down';
                break;
             case 'desc':
                $this->order=null;
                $this->icon= '-circle';
                break;  
        }
        $this->icon = $this->iconDirection($this->order);
        $this->camp = $camp;
    }

    public function iconDirection($sort):string {

        if (!$sort){
              return '-circle';   
        }

        return $sort === 'asc' ? '-arrow-circle-up' : '-arrow-circle-down';
    }

    public function showModal(User $user){
        
        $this->emit('showModal',$user);
    }
}
