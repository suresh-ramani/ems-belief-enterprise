@extends('layouts.app', [
    'title' => 'Edit | User',
    'breadcrumb' => [
        'title' => 'Edit User',
        'links' => [
            [
                'title' => 'Home',
                'url' => route("home")
            ],
            [
                'title' => 'Users',
                'url' => route("users.index")
            ],
            [
                'title' => 'Edit User',
                'active' => true
            ]
        ]
    ]
])

@push('style')
<link rel="stylesheet" href="/assets/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit User</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route("users.update", $user) }}" method="post">
                        @csrf
                        @method("patch")
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter Name" value="{{ old("name", $user->name) }}">
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" name="email" placeholder="Enter Email" value="{{ old("email", $user->email) }}">
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="text" class="form-control" name="password" placeholder="Enter Password" value="{{ old("password") }}">
                                    @error('password')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="meter">Meters</label>
                                    <select name="meter_ids[]" class="form-control select2" id="meter" multiple>
                                        @foreach ($meters as $meter)
                                            <option {{ in_array($meter->id, $selectedMeterIds) ? 'selected' : '' }} value="{{ $meter->id }}">{{ $meter->name }} ({{ $meter->location }}) - {{ $meter->industry->name }}</option>
                                        @endforeach
                                    </select>
                            
                                    @error('meter_ids')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-2">Save</button>
                                <a href="{{ route("users.index") }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <!-- Select2 -->
    <script src="/assets/plugins/select2/js/select2.full.min.js"></script>

    <script>
        $(function () {
          //Initialize Select2 Elements
          $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: "Select a Meters"
          })
        })
    </script>
@endpush

@endsection