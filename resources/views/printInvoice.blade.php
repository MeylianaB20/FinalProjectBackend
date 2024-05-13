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
                    <table id="cart" class="table table-hover table-condensed">
                        <thead>                         
                            <tr>
                                <div class="text-xxl font-bold">Invoice #{{ $invoices->invoice_number }}</div>
                                <br>
                                <div> 
                                    <span class="font-bold text-lg">Billed To</span> <br>
                                    <span>{{ $user_name }}</span> <br>
                                    <span>{{ $invoices->address }}</span> <br>
                                    <span>{{ $invoices->postal_code }}</span>
                                </div>
                                <br>
                            </tr>

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
                                $x = 0;
                            @endphp   
                            @foreach($carts as $cart)
                                @if ($cart['user_id'] != Auth::user()->id)
                                    @continue
                                @endif
                                @php 
                                    $total += $cart['product_price'] * $cart['quantity'];
                                    $x++;
                                @endphp
                                <tr>
                                    <td data-th="Product">
                                        <div class="row">
                                            <div class="col-sm-3 hidden-xs"><img src="{{asset('/storage'.'/'.$cart['category'].'/'.$cart['product_image'])}}" alt="{{ $cart['product_image'] }}" style="width: auto; height: 100px; align-items: center; margin: auto;" class="img-responsive"/></div>
                                            <div class="col-sm-9">
                                                <h4 class="nomargin">{{ ucfirst($cart['product_name']) }}</h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-th="Category">{{ $cart['category'] }}</td>
                                    <td data-th="Price">Rp. {{ $cart['product_price'] }}</td>
                                    <td data-th="Quantity">{{ $cart['quantity'] }}</td>
                                    <td data-th="Subtotal" class="text-center">Rp. {{ $cart['product_price'] * $cart['quantity'] }}</td>
                                </tr>
                            @endforeach

                            @if ($x == 0)
                                <p>{{ 'Your shopping invoice is empty.' }}</p>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-right"><h3><strong>Total: Rp. {{ $total }}</strong></h3></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right">
                                    <a href="{{ route('print.invoice', ['id' => Auth::user()->id] ) }}" class="btn btn-success"> <i class="fa fa-money cart_checkout"></i> Checkout</a>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
