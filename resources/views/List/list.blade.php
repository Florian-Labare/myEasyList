@extends('main')
@include('header')
@section('content')

    <!-- component -->
    <section class="container px-4 mx-auto mt-6">

        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                {{ session('success') }}.
            </div>
        @elseif(session('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <h3 class="text-4xl leading-none tracking-tight text-gray-500 md:text-5xl lg:text-6xl dark:text-white mb-6 pb-6">{{$list->title}}</h3>
        <div id="success-output" class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert"></div>
        @foreach($triProductsByCategory as $item)
            <div class="flex flex-col mt-10">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-2 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                        <h1 class="font-bold text-purple-700 p-6">{{$item['category_name']}}</h1>
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mb-6">
                            <thead class="bg-purple-50 dark:bg-gray-800">
                                <tr>
                                    <th scope="col" class="py-3.5 px-4 text-sm font-normal text-center rtl:text-right text-gray-500 dark:text-gray-400">
                                        <div class="flex items-center gap-x-3 focus:outline-none">
                                            <span>Produits</span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-12 py-3.5 text-sm font-normal text-center rtl:text-right text-gray-500 dark:text-gray-400">
                                        Status
                                    </th>

                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-center rtl:text-right text-gray-500 dark:text-gray-400">Ajout de jours de validité de référence</th>
                                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-center rtl:text-right text-gray-500 dark:text-gray-400">Jours restants</th>
                                </tr>
                            </thead>
                            @foreach($item['products'] as $product)
                                <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                                    <tr>
                                        <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                                            <div>
                                                <h2 class="font-medium text-gray-800 dark:text-white "><strong>{{ $product->name }}</strong></h2>
                                            </div>
                                        </td>
                                        <td class="px-12 py-4 text-sm font-medium whitespace-nowrap text-center ">
                                            <div id="output-status-change_{{$product->id}}" class="statuses inline px-3 py-1 text-sm font-normal rounded-full gap-x-2
                                                 @if($product->getStatus() == \App\Enum\ProductStatus::STATUS_CRITICAL)
                                                bg-red-300/60 dark:bg-gray-800
                                                 @elseif($product->getStatus() == \App\Enum\ProductStatus::STATUS_OK)
                                                bg-emerald-300/60 dark:bg-gray-800
                                                 @else
                                                bg-orange-300/60 dark:bg-gray-800
                                                 @endif">
                                                {{ $product->getStatus() }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-sm whitespace-nowrap text-center">
                                            <div class="flex">
                                                <div class="flex-1 p-4">
                                                    <a href="#" id="addReferenceDays_{{$product->id}}"
                                                       data-url="{{route('add-references-days', ['productId' => $product->id])}}"
                                                       data-name="{{$product->name}}"
                                                       data-product ="{{$product->id}}"
                                                       data-status ="{{$product->getStatus()}}"
                                                       class="
                                                    addreferenceValidityDays mt-5 text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4
                                                    focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-purple-400
                                                    dark:text-purple-400 dark:hover:text-white dark:hover:bg-purple-500 dark:focus:ring-purple-900">
                                                      Ajouter {{$product->count_day}} jours
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-sm font-medium whitespace-nowrap text-center">
                                            <div class="font-medium text-gray-800 dark:text-white ">
                                                <strong id="output-remaining-day-change_{{$product->id}}">{{$product->getRemainingDays()}}</strong>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </section>
@endsection


