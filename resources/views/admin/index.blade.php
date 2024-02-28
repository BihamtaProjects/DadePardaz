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

            <form method="POST" action="{{ route('admin.payToUsers') }}">
                @csrf
                <div>
                    <table class="table table-bordered table-striped text-center">

                        <thead>
                        <tr>
                            <th>#</th>
                            <th>
                                ردیف
                            </th>
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
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="selected_applications[]" value="{{ $application->id }}" id="defaultCheck{{ $key }}">
                                    </div>
                                </td>
                                <td>
                                    {{ $applications->firstItem() + $key }}
                                </td>
                                <td>
                                    {{ $application->user->name }}
                                </td>
                                <td>
                                    {{ $application->category->name }}
                                </td>
                                <td>
                                    {{ $application->description }}
                                </td>
                                <td>
                                    {{ $application->price }}
                                </td>
                                <td>
                                    <span class="{{ $application->getRawOriginal('status') ? 'text-success' : 'text-danger' }}">
                                        {{ $application->status }}
                                    </span>
                                </td>
                                <td>
                                    {{ App\Models\User::where('id',$application->admin_id)->pluck('name')->first() }}
                                </td>
                                <td>
                                    {{ $application->admin_description }}
                                </td>

                                <td>
                                    <a class="btn btn-sm btn-outline-success" href="{{ route('admin.applications.edit', ['application' => $application->id]) }}">تایید</a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary" style="background-color: blue !important;">پرداخت</button>
                </div>
            </form>

            <div class="d-flex justify-content-center mt-5">
                {{ $applications->render() }}
            </div>
        </div>
    </div>
@endsection
