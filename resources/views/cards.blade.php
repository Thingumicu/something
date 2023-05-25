@extends('layout')

@section('content')
    <h1>Cards</h1>

    <table>
        <thead>
        <tr>
            <th>Lesson</th>
            <th>Classrooms</th>
            <th>Period</th>
            <th>Weeks</th>
            <th>Terms</th>
            <th>Days</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cards as $card)
            <tr>
                <td>{{ $card['lessonid'] }}</td>
                <td>{{ $card['classroomids'] }}</td>
                <td>{{ $card['period'] }}</td>
                <td>{{ $card['weeks'] }}</td>
                <td>{{ $card['terms'] }}</td>
                <td>{{ $card['days'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
