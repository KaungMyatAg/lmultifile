@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6">
                    @if(session('Success'))
                        <div class="alert alert-success">
                            {{ session('Success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        @foreach($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                        @endforeach
                    @endif
                    <form action="{{ url("home") }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" name="image[]" multiple>
                                <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" id="inputGroupFileAddon04">Button</button>
                            </div>
                        </div>
                    </form>
                    @if(count($galleries) > 0)
                    <div class="row">
                        @foreach($galleries as $gallery)
                        <div class="col-12 col-lg-6">
                            <div class="card my-2 rounded-0">
                                <img src="{{ asset("images/$gallery->name") }}" alt="" class="img-fluid">
                                <div class="card-footer d-flex">
                                    <a href="{{ asset("images/$gallery->name") }}" class="btn btn-primary btn-sm rounded-0" target="_blank">View</a>
                                    <a href="{{ route("home.show" , $gallery->id) }}" class="btn btn-success btn-sm rounded-0">Download</a>
                                    <form action="{{ url("home/$gallery->id") }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm rounded-0" onclick="return confirm('Are You Sure To Delete!')">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection