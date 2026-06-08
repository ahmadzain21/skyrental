<div >
    {{-- About us --}}
    <form wire:submit="save" class="space-y-4 pb-4">
        <button type="button" @click="about = ! about" class="text-start">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('About Us') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Perbarui setelan Tentang Kami disini') }}
            </p>
        </button>
        <div wire:ignore class=" prose-base lg:prose-lg prose-code:text-rose-500 prose-a:text-blue-600" >
            <div id="summernote_about"></div>
        </div>
        <x-primary-button type="submit" class="disabled:bg-gray-600" wire:loading.attr="disabled">
            <div class="flex items-center space-x-1 w-full">
                <h2>
                    Save
                </h2>
            </div>
        </x-primary-button>
    </form>
    <script>
        window.addEventListener('livewire:init', function() {

            $('#summernote_about').summernote({
                tabsize: 2,
                height: 300, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: true,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    //   ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onInit: function() {
                        $('#summernote_about').summernote('code', @json($about_us));
                        $('.note-group-select-from-files').first().remove();
                    },
                    onChange: function(contents, $editable) {
                        @this.set('about_us', contents, true);
                    }
                }
            });

        })
    </script>
</div>
