@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.employee.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employees.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.first_name') }}
                        </th>
                        <td>
                            {{ $employee->first_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.last_name') }}
                        </th>
                        <td>
                            {{ $employee->last_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.company') }}
                        </th>
                        <td>
                            {{ $employee->company->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.email') }}
                        </th>
                        <td>
                            {{ $employee->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.phone') }}
                        </th>
                        <td>
                            {{ $employee->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.profile_photo') }}
                        </th>
                        <td>
                            @if($employee->profile_photo)
                                <a href="{{ $employee->profile_photo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $employee->profile_photo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employees.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection