<?php
//Tharindu Prabash - All Rights Reserved - 2022
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEmployeeRequest;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Company;
use App\Models\Employee;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class EmployeesController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('employee_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::with(['company', 'media'])->get();

        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        abort_if(Gate::denies('employee_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employees.create', compact('companies'));
    }

    public function store(StoreEmployeeRequest $request)
    {
        $employee = Employee::create($request->all());

        if ($request->input('profile_photo', false)) {
            $employee->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile_photo'))))->toMediaCollection('profile_photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $employee->id]);
        }

        return redirect()->route('admin.employees.index');
    }

    public function edit(Employee $employee)
    {
        abort_if(Gate::denies('employee_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employee->load('company');

        return view('admin.employees.edit', compact('companies', 'employee'));
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->all());

        if ($request->input('profile_photo', false)) {
            if (!$employee->profile_photo || $request->input('profile_photo') !== $employee->profile_photo->file_name) {
                if ($employee->profile_photo) {
                    $employee->profile_photo->delete();
                }
                $employee->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile_photo'))))->toMediaCollection('profile_photo');
            }
        } elseif ($employee->profile_photo) {
            $employee->profile_photo->delete();
        }

        return redirect()->route('admin.employees.index');
    }

    public function show(Employee $employee)
    {
        abort_if(Gate::denies('employee_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee->load('company');

        return view('admin.employees.show', compact('employee'));
    }

    public function destroy(Employee $employee)
    {
        abort_if(Gate::denies('employee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeRequest $request)
    {
        Employee::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('employee_create') && Gate::denies('employee_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Employee();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
