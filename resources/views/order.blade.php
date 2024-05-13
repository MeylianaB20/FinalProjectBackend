<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900" style="text-align: center;">
                    <h3 style="font-size: 30px; font-weight: bold;">Congratulations!</h3>
                    <br>
                    <h5 style="color: green; font-weight: bold;">Order Placed</h5>
                    <h5 style="color: green; font-weight: bold;">Successfully!</h5>
                    <i style="width: 35%; height: 35%; color: green; font-size: 100px;" class="fa fa-check"></i>
                </div>
                <div class="text-right" style="margin-right: 3%;">
                    <a href="{{ url('/') }}" class="btn btn-danger"> <i class="fa fa-arrow-left"></i> Continue Shopping</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
