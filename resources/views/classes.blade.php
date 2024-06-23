@php
    use App\Models\Clas;
@endphp
<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <h1 class="text-2xl font-semibold text-gray-900">Orar</h1>
        <div class="mt-4" hidden>
            <label for="card-select" class="block mt-4 text-sm font-medium text-gray-700">Selecteaza o intrare</label>
            <select name="card" id="card-select" disabled
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="" disabled selected>Selecteaza o intrare</option>
            </select>
        </div>

        <div class="mt-4">
            <label for="search" class="block text-sm font-medium text-gray-700">Cauta:</label>
            <input type="text" id="search" name="search"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <x-back-button
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"/>

        <div class="mt-4">
            <div class="w-full flex justify-center">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Curs
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Profesor
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Semigrupa
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Sala
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ora
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ziua
                        </th>
                    </tr>
                    </thead>
                    <tbody id="selected-data">
                    @foreach($cards->sortBy('lesson.days') as $index => $card)
                        @php
                            $lesson = $card->lesson;//curs

                            $subject = $lesson->subject->name ?? 'No Subject';//curs -> materie

                            $teacher = ltrim($lesson->teacher->name, '_') ?? 'No Teacher';//curs -> nume profesor

                            // Fetching class names for each class ID
                            $classIds = explode(',', $lesson->classids);
                            $classNames = [];
                            $prefixes = []; // To store unique prefixes

                            foreach ($classIds as $classId) {
                                $class = Clas::find($classId);
                                if ($class) {
                                    // Extract the prefix before the slash
                                    $prefix = strtok($class->name, '/');

                                    // Store unique prefixes
                                    if (!isset($prefixes[$prefix])) {
                                        $prefixes[$prefix] = [];
                                    }

                                    $prefixes[$prefix][] = $class->name;
                                }
                            }

                            $class = '';
                            foreach ($prefixes as $prefix => $classes) {
                                if (count($classes) > 1) {
                                    // If there are multiple classes with the same prefix, clump them together
                                    $class .= $prefix . ', ';
                                } else {
                                    // Otherwise, include the individual class
                                    $class .= implode(', ', $classes) . ', ';
                                }
                            }

                            $class = rtrim($class, ', '); // Remove trailing comma and space


                            $classroom = $card->classroom->short ?? 'No Classroom';//sala

                            $period = $card->period ?? 'No Period';//ora

                            $dayMapping = [
                                '00001' => 'Luni',
                                '00010' => 'Marti',
                                '00100' => 'Miercuri',
                                '01000' => 'Joi',
                                '10000' => 'Vineri',
                            ];
                            $day = $dayMapping[$card->days] ?? 'No Day';//ziua

                            $periodMapping = [
                                '1' => '08:00 - 08:50',
                                '2' => '09:00 - 09:50',
                                '3' => '10:00 - 10:50',
                                '4' => '11:00 - 11:50',
                                '5' => '12:00 - 12:50',
                                '6' => '13:00 - 13:50',
                                '7' => '14:00 - 14:50',
                                '8' => '15:00 - 15:50',
                                '9' => '16:00 - 16:50',
                                '10' => '17:00 - 17:50',
                                '11' => '18:00 - 18:50',
                                '12' => '19:00 - 19:50',
                                '13' => '20:00 - 20:50',
                                '14' => '21:00 - 21:50',
                            ];

                            $period = $periodMapping[$card->period] ?? 'No Period';
                        @endphp
                        <tr class="bg-white">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $subject }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $teacher }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $class }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $classroom }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $period }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $day }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search');
            const rows = document.querySelectorAll('#selected-data tr');

            searchInput.addEventListener('input', function () {
                const searchTerms = this.value.trim().toLowerCase().split(/\s+/);

                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    let found = false;

                    cells.forEach(cell => {
                        const textContent = cell.textContent.trim().toLowerCase();
                        if (searchTerms.every(term => textContent.includes(term))) {
                            found = true;
                        }
                    });

                    if (found) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>

</x-app-layout>
