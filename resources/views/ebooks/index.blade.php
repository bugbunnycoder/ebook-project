@extends('layouts.app')

@section('title', 'Ebook List')

@section('content')
<h1>Ebook List</h1>
<a href="{{ route('ebooks.create') }}" class="btn btn-primary">Create New Ebook</a>
<table class="table mt-4">
    <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Paragraph</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ebooks as $ebook)
        <tr>
            <td>{{ $ebook->title }}</td>
            <td>{{ $ebook->author }}</td>
            <td>{!! Str::limit($ebook->paragraph, 30, ' ...') !!}</td>
            <td>
                <a target="_blank" href="{{ asset('storage/ebooks/' . $ebook->title . '.pdf') }}" class="btn btn-primary">View PDF</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
