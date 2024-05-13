<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('update.product', ['id' => $product->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div>
                            <label class="form-label">Category</label>
                            @error('category_id')
                                <span class="text-error block" style="color: red;">{{ $message }}</span>
                            @enderror
                            <br>
                            <select class="form-select" aria-label="Default select example" name="category_id">
                                <option>{{ $category_product->name }}</option>
                                @foreach ($categories as $category)
                                    @if($category_product->id == $category->id) @continue @endif
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <br> 
                            <label class="form-label">Name</label> 
                            <br>
                            @error('name')
                                <span class="text-error block" style="color: red;">{{ $message }}</span>
                            @enderror
                            <input style="width: 20%" type="text" class="form-control border border-dark" name='name' value="{{ $product->name }}">
                        </div>

                        <div>
                            <br> 
                            <label class="form-label">Price</label> 
                            <br>
                            @error('price')
                                <span class="text-error block" style="color: red;">{{ $message }}</span>
                            @enderror
                            <input style="width: 20%" type="number" class="form-control border border-dark" name='price' value="{{ $product->price }}">
                        </div>

                        <div>
                            <br> 
                            <label class="form-label">Stock</label> 
                            <br>
                            @error('stock')
                                <span class="text-error block" style="color: red;">{{ $message }}</span>
                            @enderror
                            <input style="width: 20%" type="number" class="form-control border border-dark" name='stock' value="{{ $product->stock }}">
                        </div>

                        <div class="mb-3">
                            <br>
                            @error('image')
                                <span class="text-error block" style="color: red;">{{ $message }}</span>
                            @enderror
                            <label class="form-label">Image</label>
                            <br>
                            <input style="width: 20%" type="file" class="form-control border border-dark" name='image' value="{{$product->image}}">
                        </div>

                        <div>
                            <br>
                            <x-primary-button class="mt-2">
                                <input type="submit" value="Submit">
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
