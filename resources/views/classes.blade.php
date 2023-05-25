@extends('layout')

@section('content')
    <h1>Grupe</h1>
    <select name="class" id="class-select">
        <option value="" disabled selected>Selecteaza o grupa</option>
        @foreach($classes as $index => $class)
            <option value="{{ $class['id'] }}" {{ $index == -1 ? 'selected' : '' }}>{{ $class['name'] }}</option>
        @endforeach
    </select>

    @include('_back-button')

    <h3 id="selected-class"></h3>

    <script>
        const select = document.getElementById('class-select');
        const selectedTeacher = document.getElementById('selected-class');

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
