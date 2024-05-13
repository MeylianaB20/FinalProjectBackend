<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('add.category') }}" method="POST">
                        @csrf
                        <div>
                            <label for="" class="form-label">Category</label> <br>
                            @error('name')
                                <span class="text-error block" style="color: red;">{{ $message }}</span>
                            @enderror
                            <input style="width: 20%;" type="text" class="form-control border border-dark" id="" name='name' value="{{ old('name') }}">
                        </div>
                        <br>
                        <div>
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
