@extends('layouts.app')

@section('title', 'Create PDF eBook')

@section('content')
<h1>Create PDF eBook</h1>
<form action="{{ route('ebooks.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" name="author" id="author" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="front_cover">Front Cover:</label>
                <input type="file" name="front_cover" id="front_cover" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="back_cover">Back Cover:</label>
                <input type="file" name="back_cover" id="back_cover" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="front_title">Front Page Title:</label>
                <input type="text" name="front_title" id="front_title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="back_title">Back Page Title:</label>
                <input type="text" name="back_title" id="back_title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="author_image">Author Image:</label>
                <input type="file" name="author_image" id="author_image" class="form-control" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="paragraph">Paragraph:</label>
                <textarea name="paragraph" id="paragraph" class="form-control" pattern="^\s*(\S\s*){330,2000}\s*$" title="Text should have between 330 and 2000 characters." onblur="this.value = this.value.trim();" required></textarea>
            </div>
            <div class="form-group">
                <label for="front_description">Front Page Description:</label>
                <textarea name="front_description" id="front_description" class="form-control" pattern="^\s*(\S\s*){330,400}\s*$" title="Text should have between 330 and 400 characters." onblur="this.value = this.value.trim();" required></textarea>
            </div>
            <div class="form-group">
                <label for="back_description">Back Page Description:</label>
                <textarea name="back_description" id="back_description" class="form-control" pattern="^\s*(\S\s*){330,400}\s*$" title="Text should have between 330 and 400 characters." onblur="this.value = this.value.trim();"></textarea>
            </div>
    <button type="submit" class="btn btn-primary">Create PDF</button>

        </div>
    </div>
</form>

@endsection
