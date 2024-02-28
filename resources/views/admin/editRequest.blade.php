@extends('layouts.app')
@section('title')
    admin's edit applications
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">ویرایش درخواست </h5>
            </div>
            <hr>


            <form action="{{ route('admin.applications.update', ['application' => $application->id]) }}" method="POST">
                @csrf
                @method('put')
                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for="name">نام درخواست دهنده</label>
                        <input id="name" name="name" class="form-control" value="{{ $application->user->name }}" disabled>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="description">توضیحات </label>
                        <textarea id="description" name="description" class="form-control" disabled>{{$application->description}}</textarea>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="price">مبلغ درخواستی </label>
                        <input id="price" name="price" class="form-control" value="{{ $application->price }}" disabled>
                    </div>

                    <div class="form-group col-md-3">
                        <input  hidden id="admin_id" name="admin_id" type="text" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="admin_description">توضیحات ادمین</label>
                        <textarea class="form-control" id="admin_description" name="admin_description" type="text">{{$application->admin_description}}</textarea>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="status">وضعیت</label>
                        <select class="form-control" id="status" name="status">
                            <option value="1" {{ $application->getRawOriginal('status')==1 ? 'selected' : '' }}>تایید شده</option>
                            <option value="0" {{ $application->getRawOriginal('status')==2 ? 'selected' : '' }}>تایید نشده</option>
                            <option value="0" {{ $application->getRawOriginal('status')==0 ? 'selected' : '' }}>درحال بررسی</option>
                        </select>
                    </div>

                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">تایید</button>
                <a href="{{ route('admin.applications.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
