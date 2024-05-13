<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('add.invoice') }}" method="POST">
                        @csrf
                        <h6 class="font-bold" style="line-height: 1">Shipping Address</h6>
                        <p style="color: grey; font-size: 15px; line-height: 1;">Enter your destination to get a shipping estimate.</p>
                        <div class="" style="border: solid; border-width: thin; border-color: rgb(217, 215, 215)">
                            <div class="" style="padding: 20px">
        
                                <!-- Address -->
                                <div>
                                    <label class="form-label" style="font-size: 14px">Address</label> 
                                    @error('address')
                                        <span class="text-error block" style="color: red;">{{ $message }}</span>
                                    @enderror
                                    <input  style="width: 50%" type="text" class="form-control" name='address' value="{{ old('address') }}">
                                </div>
        
                                <br> 

                                <!-- Postal Code -->
                                <div>
                                    <label class="form-label" style="font-size: 14px">Postal Code</label> 
                                    <br>
                                    @error('postal_code')
                                        <span class="text-error block" style="color: red;">{{ $message }}</span>
                                    @enderror
                                    <input  style="width: 50%" type="number" class="form-control" name='postal_code' value="{{ old('postal_code') }}">
                                </div>  

                            </div>
                        </div>
                        <br>
                        <br>
                        <table id="cart" class="table table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th style="width:40%">Product</th>
                                    <th style="width:10%">Category</th>
                                    <th style="width:10%">Price</th>
                                    <th style="width:10%">Quantity</th>
                                    <th style="width:10%" class="text-center">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                    $total = 0;
                                @endphp

                                @if(session('cart'))
                                    @foreach(session('cart') as $id => $details)
                                        @if ($details['user_id'] != Auth::user()->id)
                                            @continue
                                        @endif
                                        @php 
                                            $total += $details['product_price'] * $details['quantity'] 
                                        @endphp
                                        <tr data-id="{{ $id }}">
                                            <td data-th="Product">
                                                <div class="row">
                                                    <div class="col-sm-3 hidden-xs"><img src="{{asset('/storage'.'/'.$details['category'].'/'.$details['product_image'])}}"  alt="{{ $details['product_image'] }}" style="width: auto; height: 100px; align-items: center; margin: auto;" class="img-responsive"/></div>
                                                    <div class="col-sm-9">
                                                        <h4 class="nomargin">{{ ucfirst($details['product_name']) }}</h4>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-th="Price">{{ $details['category'] }}</td>
                                            <td data-th="Price">Rp. {{ $details['product_price'] }}</td>
                                            <td data-th="Quantity">{{ $details['quantity'] }} </td>
                                            <td data-th="Subtotal" class="text-center">Rp. {{ $details['product_price'] * $details['quantity'] }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">{{ 'Your shopping cart is empty.' }}</td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right"><h3><strong>Total: Rp. {{ $total }}</strong></h3></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">
                                        <a href="{{ route('cart') }}" class="btn btn-danger"> <i class="fa fa-arrow-left"></i> Back to Shopping Cart</a>
                                        <button class="btn btn-success" type="submit" value="submit" id="checkout-live-button">Create Invoice</button>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
