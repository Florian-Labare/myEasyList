@extends('main')
@include('header')
@section('content')
    <!-- component -->
    <div class="p-6 bg-white-100 flex items-center justify-center">
        <div class="container max-w-screen-lg mx-auto">
            <div>
                <h1 class="font-semibold text-xl text-gray-600 mb-6">Ajouter un produit</h1>
                <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
                    @if(isset($errors))
                        @if(count($errors) >0 )
                            @foreach($errors->all() as $error)
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-3" role="alert">
                                    {{$error}}
                                </div>
                            @endforeach
                        @endif
                    @endif
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-2">
                        <div class="lg:col-span-2">
                            <form method="POST" action="@if(\Illuminate\Support\Facades\Route::currentRouteName() == 'product.category.create'){{ route('product.category.store', ['categoryId' => $category->id]) }} @else {{ route('product.store') }} @endif ">
                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                    @csrf
                                    <div class="md:col-span-5">
                                        <label for="name">Nom du produit</label>
                                        <input type="text" name="name" id="name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" />
                                    </div>
                                    @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'product.create')
                                        <div class="md:col-span-5">
                                            <label for="category">Associer une catégorie</label>
                                            <select name="category" id="category" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50">
                                                <option value="">--</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    <div class="md:col-span-5 text-right mt-3">
                                        <div class="inline-flex items-end">
                                            <button type="submit" class="mr-2 text-white bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-medium rounded-full text-sm px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">Valider</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


