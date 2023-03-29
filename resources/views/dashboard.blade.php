<div id="categories" class="w3-container tab">
    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('success') }}.
        </div>
    @endif
    <h2 class="mt-10 mb-4 text-4xl leading-none tracking-tight text-center text-gray-500 md:text-5xl lg:text-6xl dark:text-white p-6">Vos catégories de produits</h2>
    <div class="p-6 pl-6 bg-white-100 flex items-center justify-center">
        <div class="grid xl:grid-cols-4 lg:grid-cols-2 md:grid-cols-1 sm:grid-cols-1 gap-4 md:justify-items-center">
            @foreach($categories as $category)
                <a href="{{ route('products.category', ['categoryId' => $category->id]) }}" class="sm:grid-cols-1 flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 p-4 mr-3 mb-3 w-96 justify-between">
                    <div class="flex flex-col justify-between p-4 leading-normal">
                        <h5 class="mb-2 text-2xl tracking-tight text-gray-900 dark:text-white">{{$category->name}}</h5>
                    </div>
                    <form action="{{route('category.destroy', ['categoryId' => $category->id])}}" method="POST">
                        @csrf
                        <button type="submit" class="mt-2">
                            <i>
                                <svg class="h-6 w-6 text-grey-600"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6" />  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />  <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" />
                                </svg>
                            </i>
                        </button>
                    </form>
                </a>
            @endforeach
        </div>
    </div>
</div>

<div id="lists" class="w3-container tab" style="display:none">
    <h2 class="mt-10 mb-4 text-4xl leading-none tracking-tight text-center text-gray-500 md:text-5xl lg:text-6xl dark:text-white p-6">Vos listes</h2>
    <div class="p-6 pl-6 bg-white-100 flex items-center justify-center">
        <div class="grid xl:grid-cols-4 lg:grid-cols-2 md:grid-cols-1 sm:grid-cols-1 gap-4 md:justify-items-center">
            @foreach($lists as $list)
                <a href="@if(empty($list->products_data)) # @else{{ route('list.show', ['listId' => $list->id]) }} @endif" class="sm:grid-cols-1 flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 p-4 mr-3 mb-3 w-96 justify-between">
                    <div class="flex flex-col justify-between p-4 leading-normal">
                        <h5 class="mb-2 text-2xl tracking-tight text-gray-900 dark:text-white">{{$list->title}}</h5>
                    </div>
                    <div class="flex">
                        <form action="{{ route('list.edit', ['listId' => $list->id]) }}" method="GET">
                            @csrf
                            <button type="submit" class="mt-4">
                                <i>
                                    <svg class="h-8 w-8 text-grey-600"  viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                                        <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />  <line x1="16" y1="5" x2="19" y2="8" />
                                    </svg>
                                </i>
                            </button>
                        </form>
                        <form action="{{ route('list.destroy', ['listId' => $list->id]) }}" method="POST" class="mt-1 ml-2">
                            <button type="submit" class="mt-4">
                                <i>
                                    <svg class="h-6 w-6 text-grey-600"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                        <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" />
                                    </svg>
                                </i>
                            </button>
                        </form>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
<script>
    function switchTab(tabName) {
        console.log(tabName);
        var i;
        var tabs = document.getElementsByClassName("tab");

        for (i = 0; i < tabs.length; i++) {
            console.log(tabs[i]);
            tabs[i].style.display = "none";
        }
        document.getElementById(tabName).style.display = "block";
    }
</script>
