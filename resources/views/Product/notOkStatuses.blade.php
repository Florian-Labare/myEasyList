@extends('main')
@include('header')
@if (session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        {{ session('success') }}.
    </div>
@elseif(session('error'))
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        {{ session('error') }}
    </div>
@endif
@section('content')
    <!-- component -->
    <section class="container px-4 mx-auto">
        <div class="flex justify-between mt-6">
            <h1 class="font-semibold text-xl text-left text-gray-600 mb-6">Ici vous pouvez ajouter les produits dans une de vos listes créées</h1>
            <div>
                <a href="#_" class="px-5 py-2.5 relative rounded group overflow-hidden font-medium bg-purple-50 text-purple-600 inline-block ml-4" id="selectAll">
                    <span class="absolute top-0 left-0 flex w-full h-0 mb-0 transition-all duration-200 ease-out transform translate-y-0 bg-purple-600 group-hover:h-full opacity-90 ml-2"></span>
                    <span class="relative group-hover:text-white">Tout sélectionner</span>
                </a>
                <a href="#_" class="px-5 py-2.5 relative rounded group overflow-hidden font-medium bg-purple-50 text-purple-600 inline-block" id="deselectAll">
                    <span class="absolute top-0 left-0 flex w-full h-0 mb-0 transition-all duration-200 ease-out transform translate-y-0 bg-purple-600 group-hover:h-full opacity-90"></span>
                    <span class="relative group-hover:text-white">Tout desélectionner</span>
                </a>
            </div>
        </div>
        <form enctype="multipart/form-data" method="post" name="sendProducts">
            <div class="flex">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-2 lg:-mx-8 flex-1">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">

                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <div class="flex items-center gap-x-3 focus:outline-none">
                                            <span>Produits</span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Status
                                    </th>

                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">Jours restants</th>

                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400 flex justify-center">Séléctionner les produits à ajouter</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                                @foreach($products as $product)
                                    <tr>
                                        <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                                            <div>
                                                <h2 class="font-medium text-gray-800 dark:text-white "><strong>{{ $product->name }}</strong></h2>
                                            </div>
                                        </td>
                                        <td class="px-12 py-4 text-sm font-medium whitespace-nowrap">
                                            <div class="inline px-3 py-1 text-sm font-normal rounded-full gap-x-2
                                            @if($product->getStatus() == \App\Enum\ProductStatus::STATUS_CRITICAL)
                                                bg-red-300/60 dark:bg-gray-800
                                            @else
                                                bg-orange-300/60 dark:bg-gray-800
                                            @endif">
                                                {{ $product->getStatus() }}
                                            </div>
                                        </td>

                                        <td class="px-12 py-4 text-sm font-medium whitespace-nowrap">
                                            <div>
                                                {{ $product->getRemainingDays() }}
                                            </div>
                                        </td>

                                        <td class="px-4 py-4 text-sm font-medium whitespace-nowrap flex justify-center">
                                            <label for="product_{{$product->name}}" class="hover:bg-gray-100 cursor-pointer"><br></label>
                                            <input class="mr-4" type="checkbox" name="products[]" id="product_{{$product->name}}" value="{{$product->name}}">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex">
                <div class="mt-4 items-end">
                    <label for="selectLists" class="mt-4 block mb-2 text-sm font-bold text-purple-600 dark:text-white">Ajouter les produits séléctionnés à une des listes suivantes</label>
                    <select @if(count($products) == 0) disabled @endif name="list" id="selectLists" class="w-96 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option class="optionLists" value="">--</option>
                        @foreach($lists as $list)
                            <option class="optionLists" id="lists" value="{{$list->id}}"
                                 data-url="@if(empty($list->products_data)){{route('add-product-list', ['listId' => $list->id])}}@else{{route('merge-product-list', ['listId' => $list->id])}}@endif">
                                {{$list->title}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex justify-between ">
                <a class="mt-10 text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-sm px-5 py-2.5 mr-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 text-center" href="{{route('products.category', ['categoryId' => $categoryId])}}">
                    <svg class="h-8 w-8"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="5" y1="12" x2="19" y2="12" />  <line x1="5" y1="12" x2="11" y2="18" />
                        <line x1="5" y1="12" x2="11" y2="6" />
                    </svg>
                </a>
                <button @if(count($products) == 0) disabled @endif type="submit" class="mt-10 w-36 text-white bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-medium rounded-full text-sm px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">Valider</button>
            </div>
            <div class="hidden w-96 p-4 mb-4 text-sm rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert" id="output"></div>
        </form>
    </section>
@endsection
