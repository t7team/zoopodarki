  <div class="space-y-2">
    <x-breadcrumbs :category="$category" :catalog="$catalog" />
    <div>
      <div class="space-y-6">
        <div class="flex items-center justify-start space-x-3 text-3xl ">
          <h1 class="font-bold first-letter">
            {{ $name }}
          </h1>
          <div class="text-3xl font-bold text-gray-700" title="Найдено товаров">{{ $products->total() }}

            {{ trans_choice('titles.count_products', substr($products->total(), -1)) }}</div>
        </div>

        @if ($tags->count() > 0)
          <div class="flex flex-wrap items-center justify-start lg:px-0">
            @foreach ($tags as $tagItem)
              <div class="p-1">
                <a title="{{ $tagItem->name }}"
                  href="{{ route('site.tag', ['catalogslug' => $catalog->slug, 'categoryslug' => $category->slug, 'tagslug' => $tagItem->slug]) }}"
                  class="block px-3 py-1 text-sm  border rounded-full lowercase hover:text-orange-600  {{ request()->is('pet/' . $catalog->slug . '/' . $category->slug . '/tag/' . $tagItem->slug) ? 'bg-blue-600 text-white border-blue-600' : 'bg-gray-100 text-gray-700 border-gray-200' }}">
                  {{ $tagItem->name }}
                </a>
              </div>
            @endforeach
          </div>
        @endif

        <div class="flex w-full">
          <div class="flex flex-col w-full space-y-4 lg:space-y-0 lg:space-x-4 lg:flex-row">
            <aside class="w-full lg:w-3/12">
              <div class="relative md:p-4 md:pb-6 md:bg-white lg:rounded-2xl">
                <!--googleoff: all-->
                <!--noindex-->
                @if (Agent::isMobile())
                  <x-mob-sidebar :minPrice="$minPrice" :maxPrice="$maxPrice" :attributesRanges="$attributesRanges"
                    :brands="$brands" :showPromoF="$showPromoF" />
                @else
                  <x-filters :minPrice="$minPrice" :maxPrice="$maxPrice" :attributesRanges="$attributesRanges"
                    :brands="$brands" :showPromoF="$showPromoF" />
                @endif
                <!--/noindex-->
                <!--googleon: all-->
              </div>
              @if (Agent::isDesktop())
                <div class="px-4 pt-4 lg:py-4">
                  <button
                    class="inline-block w-full px-3 py-2 text-gray-600 bg-gray-200 border border-gray-200 md:text-sm rounded-2xl hover:text-gray-900 hover:bg-gray-400"
                    wire:click.debounce.1000="resetFilters(), $render" wire:loading.attr="disabled">
                    Сбросить фильтры
                  </button>
                </div>
              @endif
            </aside>

            <article id="top" class="w-full">

              @if ($category->id === 44)
                <x-message44 />
              @endif

              <div class="relative w-full pb-6 md:px-4 md:bg-white lg:pt-2 lg:px-6 lg:rounded-2xl">
                <div class="relative ">
                  <div class="flex items-center justify-end py-3">
                    <x-dropdown>
                      <x-slot name="title">
                        {{ $sortSelectedName }}
                      </x-slot>
                      @foreach ($sortType as $type)
                        <div class="p-2 text-base cursor-pointer md:text-xs hover:bg-gray-200"
                          wire:click="sortIt('{{ $type['type'] }}', '{{ $type['sort'] }}', '{{ $type['name'] }}')">
                          {{ $type['name'] }}
                        </div>
                      @endforeach
                    </x-dropdown>
                  </div>

                  <x-loader />
                  <div itemscope itemtype="https://schema.org/ItemList">
                    @if ($products->total() !== 0)
                      <div class="grid grid-cols-1 gap-4 md:gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        @foreach ($products as $product)
                          <div itemprop="itemListElement" itemscope itemtype="https://schema.org/Product">
                            <livewire:site.card-products :product="$product" :catalog="$catalog->slug"
                              :category="$category->slug" :wire:key="'product-'.$product->id" />
                          </div>
                        @endforeach
                      </div>
                    @else
                      <p>По этому фильтру ничего не найдено</p>
                    @endif
                  </div>
                </div>
              </div>
              <div class="py-4">
                {{ $products->links() }}
              </div>
            </article>
          </div>
        </div>
      </div>
    </div>
  </div>
