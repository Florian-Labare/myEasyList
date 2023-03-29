@extends('main')
@section('content')
    <div class="max-w-screen-lg px-8 sm:px-16 lg:px-24 content-center">
        @if(isset($errors))
            @if(count($errors) >0 )
                @foreach($errors->all() as $error)
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-3" role="alert">
                        {{$error}}
                    </div>
                @endforeach
            @endif
        @endif
        <form method="POST" action="{{route('category.update', [$category->id, 'categoryId'])}}">
            @csrf
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Editer une catégorie</label>
            <input type="text" id="category" name="name" value="{{ old('name', $category->name) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nom de la catégorie">
            <button type="submit" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded mt-3">
                Valider
            </button>
        </form>
    </div>
@endsection



