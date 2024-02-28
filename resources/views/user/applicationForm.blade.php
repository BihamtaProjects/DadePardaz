@extends('layouts.app')
@section('title')
    user application's form
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">فرم ثبت درخواست هزینه کرد</h5>
            </div>
            <hr>


            <form action="{{ route('form.user.sendForm') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="category_id">نوع هزینه کرد</label>
                        <select id="categorySelect" name="category_id" class="form-control">

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" id="description" name="description"> {{old('description')}} </textarea>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="price">هزینه</label>
                        <input class="form-control" id="price" name="price" type="text" value="{{old('price')}}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="files"> انتخاب فایل </label>
                        <div class="custom-file">
                            <input type="file" name="files[]" multiple class="custom-file-input">
                        </div>
                    </div>

                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                <a href="{{ route('admin.applications.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
