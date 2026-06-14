@extends('layouts.app', [
    'title' => 'Add | Meter',
    'breadcrumb' => [
        'title' => 'Add Meter',
        'links' => [
            [
                'title' => 'Home',
                'url' => route("home")
            ],
            [
                'title' => 'Meters',
                'url' => route("meters.index")
            ],
            [
                'title' => 'Add Meter',
                'active' => true
            ]
        ]
    ]
])

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Meter</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route("meters.store") }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="industry">Industry</label>
                                    <select name="industry_id" class="form-control" id="industry">
                                        <option value="">Select an Industry</option>
                                        @foreach ($industries as $industry)
                                            <option value="{{ $industry->id }}" @selected(old("industry_id")==$industry->id)>{{ $industry->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('industry_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="code">Code</label>
                                    <input type="text" class="form-control" name="code" placeholder="Enter Code" value="{{ old("code") }}">
                                    @error('code')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter Meter Name" value="{{ old("name") }}">
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <input type="text" class="form-control" name="location" placeholder="Enter Location" value="{{ old("location") }}">
                                    @error('location')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        @foreach ($statusOptions as $value => $label)
                                            <option value="{{ $value }}" @selected(old('status')==$value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-2">Save</button>
                                <a href="{{ route("meters.index") }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection