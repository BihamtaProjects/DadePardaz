@extends('layouts.app')
@section('title')
    admin's dashboard
@endsection

@section('content')

    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست درخواست ها ({{ $applications->total() }})</h5>
            </div>

            <div>
                <table class="table table-bordered table-striped text-center">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th> نام درخواست دهنده</th>
                        <th>دسته بندی درخواست</th>
                        <th>توضیحات</th>
                        <th>مبلغ درخواستی</th>
                        <th>وضعیت</th>
                        <th>نام ادمین</th>
                        <th>توضیح ادمین</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($applications as $key => $application)
                        <tr>
                            <th>
                                {{ $applications->firstItem() + $key }}
                            </th>
                            <th>
                                    {{ $application->user->name }}

                            </th>
                            <th>
                                    {{ $application->category->name }}

                            </th>
                            <th>
                                {{ $application->description }}
                            </th>
                            <th>
                                {{ $application->price }}
                            </th>
                            <th>
                                  <span
                                      class="{{ $application->getRawOriginal('status') ? 'text-success' : 'text-danger' }}">
                                        {{ $application->status }}
                                    </span>
                            </th>
                            <th>
                                {{ App\Models\User::where('id',$application->admin_id)->pluck('name')->first() }}
                            </th>
                            <th>
                                {{ $application->admin_description }}
                            </th>

                            <th>
                                <a class="btn btn-sm btn-outline-success"
                                   href="{{ route('admin.applications.edit', ['application' => $application->id]) }}">تایید</a>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $applications->render() }}
            </div>
        </div>
    </div>
@endsection

