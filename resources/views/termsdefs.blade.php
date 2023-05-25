@extends('layout')

@section('content')
    <h1>Terms</h1>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Short</th>
            <th>Terms</th>
        </tr>
        </thead>
        <tbody>
        @foreach($termsdefs as $term)
            <tr>
                <td>{{ $term['id'] }}</td>
                <td>{{ $term['name'] }}</td>
                <td>{{ $term['short'] }}</td>
                <td>{{ $term['terms'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
