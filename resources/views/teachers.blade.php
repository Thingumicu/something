@extends('layout')

@section('content')
    <h1>Cadre didactice</h1>
    <select name="teacher" id="teacher-select">
        <option value="" disabled selected>Selecteaza un cadru didactic</option>
        @foreach($teachers as $index => $teacher)
            <option value="{{ $teacher['id'] }}" {{ $index == -1 ? 'selected' : '' }}>{{ ltrim($teacher['name'], '_') }}</option>
        @endforeach
    </select>

    @include('_back-button')

    <h3 id="selected-teacher"></h3>

    <script>
        const select = document.getElementById('teacher-select');
        const selectedTeacher = document.getElementById('selected-teacher');

        select.addEventListener('change', function() {
            const selectedIndex = select.selectedIndex;
            const selectedOption = select.options[selectedIndex];
            selectedTeacher.textContent = selectedOption.text;
        });

        // Display the first option by default
        const firstOption = select.options[0];
        selectedTeacher.textContent = firstOption.text;
    </script>
@endsection
