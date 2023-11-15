<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('List User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('user.create') }}">
                        <x-success-button>Create User</x-success-button>
                    </a>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ((count($users) - 1) !== 0)
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($users as $user)
                                        @if ($user->id !== auth()->id())
                                            <tr class="bg-white border-b hover:bg-gray-50">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                    {{ $no++ }}.
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{ $user->name }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ $user->email }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('user.edit', $user->id) }}">
                                                            <x-warning-button>Edit</x-warning-button>
                                                        </a>
                                                        <form action="{{ route('user.destroy', $user->id) }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                            <x-danger-button>Delete</x-danger-button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 text-center" colspan="4">
                                            <i>data does not exist</i>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
