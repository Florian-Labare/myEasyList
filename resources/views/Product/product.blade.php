@extends('main')
@include('header')
@section('content')

<!-- component -->
<section class="container px-4 mx-auto mt-6">

    @if (session('success'))
        <div id="success-create-product" class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('success') }}.
        </div>
    @elseif(session('error'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h3 class="text-4xl leading-none tracking-tight text-center text-gray-500 md:text-5xl lg:text-6xl dark:text-white mb-6">{{$category->name}}</h3>
                <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400">{{ count($products) }}</span>
            </div>
        </div>
    </div>
    <div class="mt-6 md:flex md:items-center md:justify-between">
        <div>
            <div class="inline-flex overflow-hidden bg-white border divide-x rounded-lg dark:bg-gray-900 rtl:flex-row-reverse dark:border-gray-700 dark:divide-gray-700">
                <a href="{{ route('category.product.not.ok', ['categoryId' => $category->id]) }}" class="px-5 py-2 text-xs font-semibold text-white transition-colors duration-200 bg-orange-500/60 sm:text-sm hover:bg-purple-800 dark:bg-gray-800 dark:text-gray-300">
                   Produits à ajouter dans une de vos listes
                </a>
            </div>
        </div>
        <a href="{{ route('product.category.create', ['categoryId' => $category->id]) }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-sm px-5 py-2.5 mr-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 text-center"><i class="mr-2">+</i>Ajouter un produit</a>
    </div>
    <div id="output-message-delete" class="hidden p-4 mb-4 mt-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert"></div>
    @if(count($products) == 0)
        <div id="alert-4" class="alert-empty-products flex p-4 mb-4 mt-6 text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
            <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
            <div class="ml-3 text-sm font-medium">
                Aucun produit n'est pour l'instant créé
            </div>
        </div>
    @else
    <div class="flex flex-col mt-6">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-2 lg:-mx-8">
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

                            <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">Ajout de jours de consommation</th>
                            <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">Jours restants</th>

                            <th scope="col" class="relative py-3.5 px-4">
                                <span class="sr-only">Modifier</span>
                            </th>
                        </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                            @foreach($products as $product)
                                <tr id="product-line_{{$product->id}}">
                                    <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                                        <div>
                                            <h2 class="font-medium text-gray-800 dark:text-white "><strong>{{ $product->name }}</strong></h2>
                                        </div>
                                    </td>
                                    <td class="px-12 py-4 text-sm font-medium whitespace-nowrap">
                                        <div class="inline px-3 py-1 text-sm font-normal rounded-full gap-x-2
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
                                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                                        <form action="{{ route('product.category.add.days', ['categoryId' => $product->category_id,'productId' => $product->id]) }}" method="POST">
                                            @csrf
                                            <div class="flex">
                                                <input type="hidden" class="incrementDays" id={{$product->id}}>
                                                <div class="mt-10 mr-5 flex flex-1">
                                                    <label for="default-range" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"></label>
                                                    <input data-product={{$product->id}} name="addDays" type="range" value="{{$product->count_day}}" min="1" max="100" class="mt-1 w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700" id="add_days_{{$product->id}}">
                                                </div>
                                                <span class="mt-9 pb-1 rounded-full mr-4 w-6 items-center font-bold" id="increment_{{$product->id}}"></span>
                                                <div class="flex-1">
                                                    <button type="submit" class="mt-5 text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-purple-400 dark:text-purple-400 dark:hover:text-white dark:hover:bg-purple-500 dark:focus:ring-purple-900">
                                                        <i>
                                                            <svg class="h-8 w-8" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z"/>
                                                                <path d="M5 12l5 5l10 -10" />
                                                            </svg>
                                                        </i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                                        <input class="categoryProductUrl" type="hidden" data-url="{{route('category-product-progress', ['categoryId' => $category->id, 'productId' => $product->id])}}">
                                        <div class="flex">
                                            @if($product->getRemainingDays() <= -1)
                                                <div class="ml-4 flex-1">{{$product->getRemainingDays()}}</div>
                                            @else
                                                <div class="w-full bg-gray-100 rounded-full">
                                                    <div class="progression rounded-full py-0.5 text-xs text-center text-white
                                                        @if($product->getStatus() == \App\Enum\ProductStatus::STATUS_OK)
                                                            bg-emerald-500/60
                                                        @elseif($product->getStatus() == \App\Enum\ProductStatus::STATUS_WARNING)
                                                            bg-orange-500/60
                                                        @else
                                                            bg-red-500/60
                                                        @endif"
                                                         data-percent="{{$product->getPercent()}}">{{$product->getPercent()}}%
                                                    </div>
                                                </div>
                                                <div class="ml-4 flex-1">{{$product->getRemainingDays()}}</div>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                                            <a href="#" class="mt-2 cursor-pointer" data-productid="{{$product->id}}" data-urldelete="{{route('product.destroy',  ['categoryId' => $category->id, 'productId' => $product->id])}}" >
                                                <svg class="h-6 w-6 text-grey-600"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">
                                                    <polyline points="3 6 5 6 21 6" />
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                    <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" />
                                                </svg>
                                            </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div id="pagination" class="flex justify-between p-6">
                        @for($i = 1; $i <= $products->lastPage(); $i++)
                            @if($i == 1)
                                <a href="{{route('products.category', ['categoryId' => $category->id]).'?page='.$i}}">
                                    <i>
                                        <svg class="h-8 w-8"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z"/>
                                            <polyline points="15 6 9 12 15 18" />
                                        </svg>
                                    </i>
                                </a>
                            @else
                                <a href="{{route('products.category', ['categoryId' => $category->id]).'?page='.$i}}">
                                    <i>
                                        <svg class="h-8 w-8"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">
                                            <polyline points="9 18 15 12 9 6" />
                                        </svg>
                                    </i>
                                </a>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
</section>
<script>
    setTimeout(() => {
        document.getElementById("success-create-product").classList.add('hidden')
    }, 3000);
</script>
@endsection

