@extends('layouts.admin')

@section('content')
<div class="main-content">
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Product Type</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{ route('admin.categories') }}">
                            <div class="text-tiny">Categories</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Edit Product Type</div>
                    </li>
                </ul>
            </div>
            <!-- form-edit-category -->
            <div class="wg-box">
                <form class="form-edit-category form-style-1" action="{{ route('admin.category.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $category->id }}">
                    <fieldset class="name">
                        <div class="body-title">Product Type Name <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Product Type Name" name="name" value="{{ $category->name }}" required>
                    </fieldset>
                    @error('name')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset class="name">
                        <div class="body-title">Product Type Code <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Product Type Code" name="code" value="{{ $category->code }}" required>
                    </fieldset>
                    @error('code')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="bottom-page">
        <div class="body-text">Copyright © 2025 Prefabex</div>
    </div>
</div>
@endsection
