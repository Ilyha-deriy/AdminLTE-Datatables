@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="container-lg">
    <div class="text-center">
        <h2>Add positon</h2>
    </div>

    <div class="row justify-content-center my-5">

        <div class="col-lg-6">
            <form method="post" action="{{ route('admin.positions.post') }}">
                @csrf
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Name is..." id="myText">
                <div class="d-flex justify-content-end">
                    <span id="wordCount" class="text-muted">0</span>
                    <span class="text-muted">/</span>
                    <span class="text-muted">256</span>
                </div>
                @error('name')
                    <div class="alert alert-danger mt-2" role="alert"><strong>{{ $message }}</strong></div>
                @enderror

                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-secondary">Submit</button>
                </div>
            </form>
        </div>
    </div>
    </div>

@stop

@push('scripts')
<script type="text/javascript">

    var myText = document.getElementById("myText");
    var wordCount = document.getElementById("wordCount");

    const wordCounterHelper = () => {
        var characters = myText.value.split('');
        wordCount.innerText = characters.filter( item => {
        return (item != ' ');
        }).length;
    }

    wordCounterHelper()

    myText.addEventListener("input", () => {wordCounterHelper()});

</script>
@endpush

@section('js')
@stack('scripts')
@stop


