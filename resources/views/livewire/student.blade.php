<?php
use App\Models\Student;
use Livewire\WithPagination;
use Livewire\Volt\Component;
 
new class extends Component {
    use WithPagination;
    public $adding = false;
    public $name, $email;
 
    
    public function with(): array
    {
        return [
            'students' => Student::orderBy('created_at', 'desc')->paginate(10),
        ];
    }

    public function add() {
        $this->adding = true;
    }

    public function addaStudent() {
        Student::create([
            'name' => $this->name,
            'email' => $this->email
        ]);

        $this->adding = false;
        $this->resetPage();
    }

    public function deleteStudent($id) {
        $student = Student::find($id);

        $student->delete();
    }
} ?>

<div>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Students') }}
            </h2>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (!$adding)
                    <div class="w-16 p-1 pl-4 ml-auto text-sm text-white rounded-lg bg-slate-800">
                        <button wire:click="add()">
                            ADD
                        </button>
                    </div>
                    @endif
                    @if ($adding)
                        <div class="px-4">
                            <form wire:submit.prevent="addaStudent">
                                <div>
                                    <x-input-label for="name" :value="__('Name')" />
                                    <x-text-input wire:model="name" id="name" name="name" type="text" class="block w-full mt-1" required autofocus autocomplete="name" />
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                </div>
                                <div class="mt-4">
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input wire:model="email" id="email" name="email" type="email" class="block w-full mt-1" required autofocus autocomplete="name" />
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                </div>

                                <div class="mt-4">
                                    <x-primary-button>
                                        {{ __('Add') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm bg-white divide-y-2 divide-gray-200">
                          <thead class="ltr:text-left rtl:text-right">
                            <tr>
                              <th class="px-4 py-2 font-semibold text-left text-gray-900 whitespace-nowrap">Name</th>
                              <th class="px-4 py-2 font-semibold text-left text-gray-900 whitespace-nowrap">Email</th>
                              <th class="px-4 py-2 font-semibold text-left text-gray-900 whitespace-nowrap">Create At</th>
                              <th class="px-4 py-2 font-semibold text-left text-gray-900 whitespace-nowrap">Action/s</th>
                            </tr>
                          </thead>
                      
                          <tbody class="divide-y divide-gray-200">
                            @foreach ($students as $student)
                            <tr>
                                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">{{$student->name}}</td>
                                <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{$student->email}}</td>
                                <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{$student->created_at}}</td>
                                <td class="px-4 py-2 text-gray-700 whitespace-nowrap">
                                    <button wire:click="deleteStudent({{$student->id}})" class="px-2 py-1 text-xs text-white bg-red-700 rounded-lg">
                                        DELETE
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-2 mt-2">
                        {{ $students->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div> 
</div>


