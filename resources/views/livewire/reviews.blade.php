 <div class="xl:w-[85%]">
     @if ($errors->any())
         <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
             <ul class="list-disc list-inside">
                 @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                 @endforeach
             </ul>
         </div>
     @endif
     <form wire:submit="save">
         <div class="space-y-2">
             <x-mary-rating wire:model="rating" class="bg-warning" total="5" />
             <x-mary-textarea wire:model="comment" placeholder="Here ..." hint="Max 1000 chars" rows="5" />
         </div>
         <div class="flex justify-end">
             <button wire:loading.attr="disabled" type="submit"
                 class="py-1 px-4 bg-black disabled:bg-gray-300 text-white hover:bg-white hover:text-black border-2 border-black duration-150 transition-all ease-in text-sm sm:text-base">posting</button>
         </div>
     </form>
     <div>
         <div>
            <div class="flex items-center space-x-1">
                <h1 class="text-xl sm:text-2xl md:text-3xl font-semibold">Reviews</h1>
                <div class="text-xl sm:text-2xl md:text-3xl font-semibold">{{ $avgRating }}</div>
            </div>
         </div>
         <div class="space-y-8 mt-7">
             @foreach ($reviews as $review)
                 <div class="space-y-3">
                     <div class="flex justify-start items-start space-x-4" x-data="{
                         name: @js($review->name ?? ''),
                         colors: ['bg-red-500', 'bg-blue-500', 'bg-green-500', 'bg-yellow-500', 'bg-purple-500', 'bg-pink-500'],
                         initial: '',
                         randomColor: '',
                         init() {
                             this.initial = this.name ? this.name.charAt(0).toUpperCase() : '?'
                             this.randomColor = this.colors[Math.floor(Math.random() * this.colors.length)]
                         }
                     }">

                         <div :class="randomColor"
                             class="w-[40px] h-[40px] flex-none rounded-full flex items-center justify-center text-white font-bold text-lg">
                             <span x-text="initial"></span>
                         </div>

                         <div class="space-y-2">
                             <div>
                                 <h3 class="font-semibold sm:text-lg text-gray-600">{{ $review->name }}</h3>
                                 <p class="text-sm text-gray-600 font-medium">{{ $review->created_at->diffForHumans() }}
                                 </p>
                             </div>
                             <x-star-rating :rating="$review->rating" />
                             <p class="text-sm">{{ $review->comment }}</p>
                         </div>
                     </div>
                 </div>
             @endforeach
         </div>
     </div>
 </div>
