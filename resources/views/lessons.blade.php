@php use App\Models\Clas;use App\Models\Subject;use App\Models\Teacher; @endphp
<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <h1 class="text-2xl font-semibold text-gray-900">Cursuri</h1>

        <div class="mt-4">
            <label for="lesson-select" class="block text-sm font-medium text-gray-700">Selecteaza un curs</label>
            <select name="lesson" id="lesson-select"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="" disabled selected>Selecteaza un curs</option>
                @foreach($lessons as $index => $lesson)
                    @php
                        $subject = Subject::find($lesson['subjectid']);
                        $subjectName = $subject ? $subject->name : 'N/A';
                        $teacherids = Teacher::find($lesson['teacherids']);
                        $teacherName = $teacherids ? str_replace('_', ' ', $teacherids->name) : 'N/A';
                        $classids = Clas::find($lesson['classids']);
                        $className = $classids ? $classids->name : 'N/A';
                    @endphp
                    @if($className !== 'N/A')
                        {{-- Only show options where class name is not N/A --}}
                        <option value="{{$lesson['id']}}"
                                {{$index == -1 ? 'selected' : ''}} data-lesson="{{ $subjectName }}"
                                data-teacher="{{ $teacherName }}" data-class="{{ $className }}">
                            {{ $subjectName }} - {{ $teacherName }} - {{ $className }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <x-back-button
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"/>
        </div>

        <div id="group-header" style="display:none;" class="mt-6">
            <h2 class="text-lg leading-6 font-medium text-gray-900">Curs: <span id="selected-lesson"
                                                                                class="text-indigo-600">N/A</span></h2>
            <h2 class="text-lg leading-6 font-medium text-gray-900">Profesor: <span id="selected-teacher"
                                                                                    class="text-indigo-600">N/A</span>
            </h2>
            <h2 class="text-lg leading-6 font-medium text-gray-900">Grupa: <span id="selected-class"
                                                                                 class="text-indigo-600">N/A</span></h2>
        </div>
    </div>

    <script>
        const select = document.getElementById('lesson-select');
        const selectedLesson = document.getElementById('selected-lesson');
        const selectedTeacher = document.getElementById('selected-teacher');
        const selectedClass = document.getElementById('selected-class');

        select.addEventListener('change', function () {
            const selectedIndex = select.selectedIndex;
            const selectedOption = select.options[selectedIndex];
            const groupHeader = document.getElementById('group-header');

            if (selectedOption.value) {
                selectedLesson.textContent = selectedOption.dataset.lesson || 'N/A';
                selectedTeacher.textContent = selectedOption.dataset.teacher || 'N/A';
                selectedClass.textContent = selectedOption.dataset.class || 'N/A';
                groupHeader.style.display = '';
            } else {
                groupHeader.style.display = 'none';
            }
        });

        // Initialize with the first option's data if available
        if (select.options.length > 1 && select.options[0].dataset) {
            const initialData = select.options[0].dataset;
            selectedLesson.textContent = initialData.lesson || 'N/A';
            selectedTeacher.textContent = initialData.teacher || 'N/A';
            selectedClass.textContent = initialData.class || 'N/A';
        }
    </script>
</x-app-layout>
