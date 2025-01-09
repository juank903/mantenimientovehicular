
<x-main-layout>
    <main class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
        <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6">
            <img class="object-cover object-center rounded" alt="policial" src="{{ asset("img/homePolicia.jpeg") }}">
        </div>
        <div class="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
            <x-logopoliciahorizontal/>
            <div class="flex justify-center">
                <a href=""
                    class="inline-flex text-white bg-blue-500 border-0 py-2 px-6 focus:outline-none hover:bg-blue-600 rounded text-lg">Read</a>
                <a href=""
                    class="ml-4 inline-flex text-gray-700 bg-gray-100 border-0 py-2 px-6 focus:outline-none hover:bg-gray-200 rounded text-lg">About
                    me</a>
            </div>
        </div>
    </main>
</x-main-layout>
