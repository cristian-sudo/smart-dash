<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;

class Products extends Component
{
    use WithPagination;

    #[Rule('required|string|max:255')]
    public $name = '';

    #[Rule('required|numeric|min:0')]
    public $price = '';

    #[Rule('required|integer|min:0')]
    public $stock = 0;

    #[Rule('nullable|string|max:50')]
    public $sku = '';

    #[Rule('nullable|string')]
    public $description = '';

    public $editingId = null;
    public $showModal = false;
    public $notificationMessage = '';
    public $show = false;

    public function mount()
    {
        $this->price = 0;
        $this->stock = 0;
    }

    public function create()
    {
        $this->reset(['name', 'price', 'stock', 'sku', 'description', 'editingId']);
        $this->showModal = true;
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $this->editingId = $id;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->sku = $product->sku;
        $this->description = $product->description;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['name', 'price', 'stock', 'sku', 'description', 'editingId']);
    }

    public function save()
    {
        $this->validate();

        $data = [
            'user_id' => auth()->id(),
            'name' => $this->name,
            'price' => $this->price,
            'stock' => $this->stock,
            'sku' => $this->sku,
            'description' => $this->description,
        ];

        if ($this->editingId) {
            Product::find($this->editingId)->update($data);
            $this->notificationMessage = 'Product updated successfully.';
        } else {
            Product::create($data);
            $this->notificationMessage = 'Product created successfully.';
        }

        $this->show = true;
        $this->closeModal();
    }

    public function delete($id)
    {
        Product::find($id)->delete();
        $this->notificationMessage = 'Product deleted successfully.';
        $this->show = true;
    }

    public function render()
    {
        $products = Product::where('user_id', Auth::id())
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.products', [
            'products' => $products,
        ]);
    }
} 