<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panou de control') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="flex justify-end p-6">
            <form action="{{ route('seedDatabase') }}" method="POST">
                @csrf
                @php
                    $disableButton = collect($tableCounts)->contains(function ($count) {
                        return $count > 14;
                    });
                    $seeded = $seedingStatus->seeded ?? false; // Assuming $seedingStatus is fetched from the database or cache
                @endphp
                <button id="seedButton" type="submit" class="bg-{{ $seeded ? 'green' : 'blue' }}-500 hover:bg-{{ $seeded ? 'green' : 'blue' }}-700 text-white font-bold py-2 px-4 rounded" {{ $disableButton ? 'disabled' : '' }}>
                    {{ $seeded ? 'Database Seeded' : 'Seed Database' }}
                </button>
            </form>
        </div>



        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <table class="min-w-full">
                    <thead class="border-b">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Baza de date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Număr de intrări
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tables as $table)
                        <tr class="border-b">
                            <td class="text-sm text-gray-900 dark:text-gray-100 px-6 py-4 whitespace-nowrap">
                                {{ $table }}
                            </td>
                            <td class="text-sm text-gray-900 dark:text-gray-100 px-6 py-4 whitespace-nowrap">
                                {{ $tableCounts[$table] }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
