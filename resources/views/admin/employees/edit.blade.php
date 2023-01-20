@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="container-lg">
    <div class="text-center">
        <h2>Employee edit</h2>
    </div>

    <div class="row justify-content-center my-5">

        <div class="col-lg-6">
            <form method="post" action="{{ route('admin.employees.update', ['id' => $employee->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <label for="image_path" class="form-label">Photo</label>
                <!--<img src='{{ asset("images/$employee->image_path") }}' class="img-thumbnail form-control-file"/>-->
                <img src="{{ asset("images/$employee->image_path") }}" class="img-thumbnail form-control-file mb-2"  style="width: 80%">
                <input type="file" name="image_path" class="form-control-file" >
                <small class="form-text text-muted">File format jpg,png up to 5MB, the minimum size of 300x300px</small>
                @error('image_path')
                    <div class="alert alert-danger mt-2" role="alert"><strong>{{ $message }}</strong></div>
                @enderror

                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $employee->name }}" placeholder="Name is..." id="myText">
                <div class="d-flex justify-content-end">
                    <span id="wordCount" class="text-muted">0</span>
                    <span class="text-muted">/</span>
                    <span class="text-muted">256</span>
                </div>
                @error('name')
                    <div class="alert alert-danger mt-2" role="alert"><strong>{{ $message }}</strong></div>
                @enderror


                <label for="phone_number" class="form-label">Phone</label>
                <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', preg_replace('/[^0-9]/', '', $employee->phone_number)) }}" placeholder="380...">
                <small class="form-text text-muted d-flex justify-content-end">Required format +380 (xx) XXX XX XX</small>
                @error('phone_number')
                    <div class="alert alert-danger mt-2" role="alert"><strong>{{ $message }}</strong></div>
                @enderror


                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $employee->email) }}" placeholder="Email is...">
                @error('email')
                    <div class="alert alert-danger mt-2" role="alert"><strong>{{ $message }}</strong></div>
                @enderror



                <label for="position_id" class="form-label">Position</label>
                <select class="form-control" name="position_id" aria-label=".form-select-lg example">
                    @foreach ($positions as $position)
                        <option value="{{ $position->id }}" {{$employee->position_id == $position->id  ? 'selected' : ''}}>{{ $position->name }}</option>
                    @endforeach
                </select>
                @error('position_id')
                    <div class="alert alert-danger mt-2" role="alert"><strong>{{ $message }}</strong></div>
                @enderror


                <label for="payment" class="form-label">Salary, $</label>
                <input type="text" name="payment" class="form-control" value="{{ old('payment', preg_replace('/[^0-9]/', '', $employee->payment)) }}" placeholder="Salary is...">
                @error('payment')
                    <div class="alert alert-danger mt-2" role="alert"><strong>{{ $message }}</strong></div>
                @enderror


                <label for="head_id" class="form-label">Head</label>
                <input type="text" id="head_id" name="head_id" class="form-control" value="{{ $employee->head->name ?? '' }}" placeholder="Head is...">
                @error('head_id')
                    <div class="alert alert-danger mt-2" role="alert"><strong>{{ $message }}</strong></div>
                @enderror


                <label for="recruitment_date" class="form-label">Date</label>
                <input type="datetime-local" name="recruitment_date" value="{{ old('recruitment_date', $employee->recruitment_date) }}" class="form-control">
                @error('recruitment_date')
                    <div class="alert alert-danger mt-2" role="alert"><strong>{{ $message }}</strong></div>
                @enderror

                <div class="container">
                    <div class="row mt-4">
                        <label for="head" class="form-label">Created at:</label>
                      <div class="col">
                        {{ $employee->created_at->format('d-m-y') }}
                      </div>
                      <label for="head" class="form-label">Admin created ID:</label>
                      <div class="col">
                        {{ $employee->admin_created_id }}
                      </div>
                    </div>
                    <div class="row mt-4">
                        <label for="head" class="form-label">Updated at:</label>
                      <div class="col">
                        {{ $employee->updated_at->format('d-m-y') }}
                      </div>
                        <label for="head" class="form-label">Admin updated at:</label>
                      <div class="col">
                        {{ $employee->admin_updated_id }}
                      </div>
                    </div>
                  </div>


                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-secondary">Submit</button>
                </div>
            </form>
        </div>
    </div>
    </div>

@stop

@section('css')
@stack('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@stop

@push('scripts')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("input[type=datetime-local]");
</script>
<script type="text/javascript">
    var route = "{{ url('autocomplete-search') }}";
    $('#head_id').typeahead({
        source: function (query, process) {
            return $.get(route, {
                query: query
            }, function (data) {
                return process(data);
            });
        }
    });

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
