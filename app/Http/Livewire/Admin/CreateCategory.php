<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

use Illuminate\Support\Str;

use Livewire\WithFileUploads;

class CreateCategory extends Component
{

    use WithFileUploads;

    public $brands, $categories, $category, $rand;

    protected $listeners = ['delete'];

    public $createForm = [
        
        'name' => null,
        'slug' => null,
        'brands' => [],
    ];

    public $editForm = [
        'open' => false,
        'name' => null,
        'slug' => null,
        'brands' => [],
    ];

    public $editImage;

    protected $rules = [
        'createForm.name' => 'required',
        'createForm.slug' => 'required|unique:categories,slug',
        'createForm.brands' => 'required',
    ];

    protected $validationAttributes = [
        'createForm.name' => 'nombre',
        'createForm.slug' => 'slug',
        'createForm.image' => 'imagen',
        'createForm.brands' => 'marcas',
        'editForm.name' => 'nombre',
        'editForm.slug' => 'slug',
        'editForm.brands' => 'marcas'
    ];

    public function mount(){
        $this->getBrands();
        $this->getCategories();
        $this->rand = rand();
    }

    public function updatedCreateFormName($value){
        $this->createForm['slug'] = Str::slug($value);
    }

    public function updatedEditFormName($value){
        $this->editForm['slug'] = Str::slug($value);
    }

    public function getBrands(){
        $this->brands = Brand::all();
    }

    public function getCategories(){
        $this->categories = Category::all();
    }

    public function save(){
        $this->validate();


        $category = Category::create([
            'name' => $this->createForm['name'],
            'slug' => $this->createForm['slug'],
        ]);

        $category->brands()->attach($this->createForm['brands']);

        $this->rand = rand();
        $this->reset('createForm');

        $this->getCategories();
        $this->emit('saved');
    }

    public function edit(Category $category){

        $this->resetValidation();

        $this->category = $category;

        $this->editForm['open'] = true;
        $this->editForm['name'] = $category->name;
        $this->editForm['slug'] = $category->slug;
        $this->editForm['brands'] = $category->brands->pluck('id');
    }

    public function update(){

        $rules = [
            'editForm.name' => 'required',
            'editForm.slug' => 'required|unique:categories,slug,' . $this->category->id,
            'editForm.brands' => 'required',
        ];

        $this->validate($rules);

        $this->category->update($this->editForm);

        $this->category->brands()->sync($this->editForm['brands']);

        $this->getCategories();

        $this->editForm['open'] = false;
    }

    public function delete(Category $category){
        $category->delete();
        $this->getCategories();
    }

    public function render()
    {
        return view('livewire.admin.create-category');
    }
}
