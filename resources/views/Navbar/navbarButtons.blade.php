<ul class="pl-6 flex flex-wrap text-sm font-medium text-center text-gray-500 dark:border-gray-700 dark:text-gray-400 sm:flex-column">
    <li class="mr-2">
        <a data-tab="categoriesTab" href="#" aria-current="page" class="active inline-block p-4" onclick="switchTab('categories')">Mes catégories de produits</a>
        @if(count($categories) > 0)
            <span class="px-3 py-1 text-xs text-blue-600 bg-purple-100 rounded-full dark:bg-gray-800 dark:text-gray-400">{{count($categories)}}</span>
        @endif
    </li>
    <li class="mr-2">
        <a data-tab="listsTab" href="#" class="inline-block p-4" onclick="switchTab('lists')">Mes listes créées</a>
        @if(count($categories) > 0)
            <span class="px-3 py-1 text-xs text-blue-600 bg-purple-100 rounded-full dark:bg-gray-800 dark:text-gray-400">{{count($lists)}}</span>
        @endif
    </li>
</ul>

<div class="mb-2">
    <a href="{{ route('category.create') }}" class="mr-2 text-white bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-medium rounded-full text-sm px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900"><i class="mr-2">+</i>Ajouter une catégorie de produits</a>
    <a href="{{ route('list.create') }}" class="mr-2 text-white bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-medium rounded-full text-sm px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900"><i class="mr-2">+</i>Ajouter une liste</a>
    @if(count($categories) > 0)
        <a href="{{ route('product.create') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-full text-sm px-5 py-2.5 mr-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 text-center"><i class="mr-2">+</i>Ajouter un produit</a>
    @endif
</div>
