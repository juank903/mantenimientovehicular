@props(['href'])

<a href="{{$href}}">
    <div class="group flex h-10 w-10 cursor-pointer items-center justify-center bg-white p-1 hover:bg-slate-200">
        <div class="space-y-2">
            <span
                class="block h-1 w-5 origin-center rounded-full bg-slate-500 transition-transform ease-in-out group-hover:translate-y-1.5 group-hover:rotate-45"></span>
            <span
                class="block h-1 w-5 origin-center rounded-full bg-orange-500 transition-transform ease-in-out group-hover:w-5 group-hover:-translate-y-1.5 group-hover:-rotate-45"></span>
        </div>
    </div>
</a>
