@extends('layouts.app', [
    'title' => 'Add | Industry',
    'breadcrumb' => [
        'title' => 'Add Industry',
        'links' => [
            [
                'title' => 'Home',
                'url' => route("home")
            ],
            [
                'title' => 'Industries',
                'url' => route("industries.index")
            ],
            [
                'title' => 'Add Industry',
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
                    <h3 class="card-title">Add Industry</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route("industries.store") }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="name">Industry Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter Industry Name" value="{{ old("name") }}">
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="owner_name">Owner Name</label>
                                    <input type="text" class="form-control" name="owner_name" placeholder="Enter Owner Name" value="{{ old("owner_name") }}">
                                    @error('owner_name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="owner_phone">Owner Phone</label>
                                    <input type="text" class="form-control" name="owner_phone" placeholder="Enter Owner Phone" value="{{ old("owner_phone") }}">
                                    @error('owner_phone')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="owner_email">Owner Email</label>
                                    <input type="text" class="form-control" name="owner_email" placeholder="Enter Owner Email" value="{{ old("owner_email") }}">
                                    @error('owner_email')
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
                            <div class="col-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" class="form-control" cols="30" rows="2">{{ old('address') }}</textarea>
                                    @error('address')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-2">Add</button>
                                <a href="{{ route("industries.index") }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection