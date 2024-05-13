<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @forelse ($categories as $category)
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 style="font-size: 50px;">{{ $category->name }}</h2>
                        <div style="display: flex; flex-wrap: wrap;">
                            @php
                                $x = 1
                            @endphp
                            @foreach ($products as $product)
                                @if ($product->category_id != $category->id)
                                    @continue
                                @endif
                                <div class="col-xs-18 col-sm-6 col-md-4" style="margin-top: 30px;">
                                    @php($x++)
                                    <div class="img_thumbnail productlist" style="padding: 25px;">
                                        <img src="{{asset('/storage'.'/'.$category->name.'/'.$product->image)}}" alt="{{ $product->image }}" style="width: auto; height: 200px; align-items: center; margin: auto;">
                                        <div class="caption mt-2">
                                            <h4>{{ ucfirst($product->name) }}</h4>
                                            <p style="margin: 0px"><strong>Price: </strong> Rp. {{ $product->price }}</p>
                                            <p><strong>Stock: </strong>{{ $product->stock }}</p>
                                        </div>
                                        <div style="display: flex;">
                                            @if(Auth::user()->isAdmin != 1)
                                                @if ($product->stock != 0) 
                                                    <x-primary-button style="margin: 10px 10px 10px 0px; background-color:#3CB043;">
                                                        <a href="{{ route('add_to_cart', $product->id) }}" style="color: white">ADD TO CART</a>
                                                    </x-primary-button>
                                                @else
                                                    <p style="color: red;">{{ 'Out of stock, please wait until the item is restocked.' }}</p>
                                                @endif
                                            @endif
                                        </div>
                                        <div style="display: flex; font-size: 18px;">
                                            @if (Auth::user()->isAdmin == 1)
                                            <br>
                                                <x-primary-button style="margin: 10px 10px 10px 0px; background-color:blue;">
                                                    <a style="color: white" href="{{route('edit.product', $product->id)}}">EDIT</a>
                                                </x-primary-button>
                                                <form action="{{route('delete.product', $product->id)}}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <x-primary-button style="margin: 10px 10px 10px 0px; background-color: red;">
                                                        <p style="margin: 0px;" data-feather="trash-2">DELETE</p>
                                                    </x-primary-button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if ($x == 1)
                                <p>{{ 'No products have been added yet.' }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <p>{{ 'No categories have been added yet.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endforelse
</x-app-layout>
