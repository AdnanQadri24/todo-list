<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>To Do List</title>
        @vite('resources/css/app.css')
        <script
            defer="defer"
            src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>

    <body class="min-h-screen text-white">
        <!-- Navbar -->
        <nav class="bg-black w-full text-center">
            <div class="text-white p-4 font-mono">
                <h3 class="text-3xl font-bold font-mono">
                    SIMPLE TO DO LIST
                </h3>
                <p>
                    by: Adnan
                </p>
            </div>
        </nav>

        <main class="w-full min-h-screen pt-[40px] bg-[#00090A]">
            <div
                class="relative max-w-[1440px] mx-auto w-full flex flex-col lg:px-16 xl:px-20 px-4 lg:py-8 xl:py-10 py-4 overflow-hidden gap-10 lg:gap-20 items-center">
                {{-- content --}}
                <div class="text-black w-2/4">
                    <div class="bg-gray-700 p-4 rounded-sm mb-2">
                        @if (session('success'))
                        <div
                            class="bg-green-100 border-l-8 border-green-500 text-green-700 p-2 mb-2 opacity-80"
                            role="alert">
                            {{ session('success') }}
                        </div>
                        @endif @if ($errors->any())
                        <div
                            class="bg-orange-100 border-l-8 border-orange-500 text-orange-700 p-2 mb-2 opacity-80"
                            role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>
                                    {{ $error }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        {{-- form input data --}}
                        <form id="todo-form" action="{{ route('todo.post') }}" method="POST">
                            @csrf
                            <div class="input-group flex flex-row ">
                                <input
                                    type="text"
                                    class="form-control w-full px-2 py-3 outline-none rounded-l-lg"
                                    name="task"
                                    id="todo-input"
                                    placeholder="tambahkan tugas"
                                    required="requerid"
                                    value="{{ old('task') }}">
                                <button
                                    class="btn btn-primary text-white bg-blue-500 px-1 rounded-r-lg"
                                    type="submit">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="bg-gray-700 p-4 rounded-sm">

                        {{-- searching --}}
                        <form id="todo-form" action="{{ route('todo') }}" method="GET">
                            <div class="input-group mb-3 flex flex-row ">
                                <input
                                    type="text"
                                    class="form-control w-full px-2 py-3 outline-none rounded-l-lg"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="masukkan kata kunci"
                                    required="requerid">
                                <button
                                    class="bg-green-600 text-white px-2 rounded-r-lg btn btn-primary"
                                    type="submit">
                                    Cari
                                </button>
                            </div>
                        </form>

                        <ul x-data="{ isOpen: false }" class="mb-4" id="todo-list">
                            @foreach ($data as $item)

                            <!-- Display Data -->
                            <li
                                class="bg-white shadow-md rounded-md p-4 mb-2 flex justify-between items-center relative z-10">
                                <span class="">
                                    {!! $item->is_done == 1 ? '<del>' : '' !!}
                                    {{ $item->task }}
                                    {!! $item->is_done == 1 ? '</del>' : '' !!}
                                </span>
                                <input
                                    type="text"
                                    class="hidden form-control edit-input"
                                    value="{{ $item->task }}">
                                <div class="flex space-x-2">

                                    <form action="{{ route('todo.delete', ['id'=>$item->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin mengapus data ini ?')">
                                        @csrf
                                        @method('delete')
                                        <button class="bg-red-500 text-white px-2 py-1 rounded-md delete-btn">✕</button>
                                    </form>

                                    <button
                                        type="button"
                                        @click="isOpen = !isOpen; currentItem = {{ $item->id }}"
                                        class="bg-blue-500 text-white px-2 py-1 rounded-md edit-btn"
                                        >✎
                                    </button>
                                </div>
                            </li>
                            
                            <!-- Update Data -->
                            <li class="list-group-item mb-2 bg-gray-600 -mt-3 rounded-b-lg" x-show="isOpen && currentItem == {{ $item->id }}">
                                <form class="pt-4 p-2" action="{{ route('todo.update', ['id'=>$item->id]) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="task" value="{{ $item->task }}">
                                        <button
                                            class="bg-blue-500 text-white px-2 py-1 rounded-md update-btn"
                                            type="submit">Update</button>
                                    </div>
                                    <div class="flex text-white">
                                        <div class="radio px-2">
                                            <label>
                                                <input type="radio" value="1" name="is_done" {{ $item->is_done == '1' ? 'checked':''}}>
                                                Selesai
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" value="0" name="is_done" {{ $item->is_done == '1' ? '':'checked' }}>
                                                Belum
                                            </label>
                                        </div>
                                    </div>
                                </form>
                            </li>

                            @endforeach
                        </ul>

                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </main>
    </body>

</html>