@extends('layout')

@section('content')
    <h1>Grades</h1>

    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Grade</th>
        </tr>
        </thead>
        <tbody>
        @foreach($grades as $grade)
            <tr>
                <td>{{ $grade['name'] }}</td>
                <td>{{ $grade['grade'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
