<div
    x-data="{
        showButton : false,
        init() {
            window.addEventListener('scroll', () => {
                this.showButton = window.scrollY > window.innerHeight * 1.5;
            })
        }
    }"
    class="fixed bg-red-300 w-full max-w-[1600px] mx-auto left-1/2 -translate-x-1/2 bottom-1"
>
    <button
        x-data
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        x-show="showButton"
        x-on:click="window.scrollTo({top : 0, behavior : 'smooth'})"
        class="absolute right-1 bottom-0 p-4 bg-primary-light hover:bg-primary-mid rounded-md flex items-center gap-1 text-sm font-medium"
    >
        <x-i icon="arrow-up" size="sm" />
        Back to top
    </button>
</div>
