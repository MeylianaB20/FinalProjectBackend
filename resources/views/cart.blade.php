<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table id="cart" class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th style="width:40%">Product</th>
                                <th style="width:10%">Category</th>
                                <th style="width:10%">Price</th>
                                <th style="width:10%">Quantity</th>
                                <th style="width:10%" class="text-center">Subtotal</th>
                                <th style="width:10%"></th>
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
                                        <td data-th="Category">{{ $details['category'] }}</td>
                                        <td data-th="Price">Rp. {{ $details['product_price'] }}</td>
                                        <td data-th="Quantity">
                                            <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity cart_update" min="1" />
                                        </td>
                                        <td data-th="Subtotal" class="text-center">Rp. {{ $details['product_price'] * $details['quantity'] }}</td>
                                        <td class="actions" data-th="">
                                            <button class="btn btn-danger btn-sm cart_remove"><i class="fa fa-trash-o"></i> Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">{{ 'Your shopping cart is empty.' }}</td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" class="text-right"><h3><strong>Total: Rp. {{ $total }}</strong></h3></td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-right">
                                    <a href="{{ url('/') }}" class="btn btn-danger"> <i class="fa fa-arrow-left"></i> Continue Shopping</a>
                                    <a href="{{ route('invoice') }}" class="btn btn-success"> Create address to checkout</a>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <script type="text/javascript">
   
                        $(".cart_update").change(function (e) {
                            e.preventDefault();
                       
                            var ele = $(this);
                            var cartId = ele.closest("tr").data("id");
                            var updateCartRoute = '{{ route('update_cart', ':cartId') }}'
                            updateCartRoute = updateCartRoute.replace(':cartId', cartId);

                            $.ajax({
                                url: updateCartRoute,
                                method: "patch",
                                data: {
                                    _token: '{{ csrf_token() }}', 
                                    id: cartId, 
                                    quantity: ele.parents("tr").find(".quantity").val()
                                },
                                success: function (response) {
                                   window.location.reload();
                                }
                            });
                        });
                       
                        $(".cart_remove").click(function (e) {
                            e.preventDefault();
                       
                            var ele = $(this);
                            var cartId = ele.closest("tr").data("id");
                            var removeCartRoute = '{{ route('remove_from_cart', ['id' => ':cartId']) }}';
                            removeCartRoute = removeCartRoute.replace(':cartId', cartId);

                            if(confirm("Do you really want to remove?")) {
                                $.ajax({
                                    url: removeCartRoute,
                                    method: "DELETE",
                                    data: {
                                        _token: '{{ csrf_token() }}', 
                                        id: ele.parents("tr").attr("data-id")
                                    },
                                    success: function (response) {
                                        window.location.reload();
                                    }
                                });
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
