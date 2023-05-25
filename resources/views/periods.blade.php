@extends('layout')

@section('content')
    <h1>Periods</h1>

    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Short</th>
            <th>Period</th>
            <th>Start time</th>
        </tr>
        </thead>
        <tbody>
        @foreach($periods as $period)
            <tr>
                <td>{{ $period['name'] }}</td>
                <td>{{ $period['short'] }}</td>
                <td>{{ $period['period'] }}</td>
                <td>{{ $period['starttime'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
