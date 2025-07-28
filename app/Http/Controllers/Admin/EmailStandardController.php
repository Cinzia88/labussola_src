<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEmailStandardRequest;
use App\Http\Requests\StoreEmailStandardRequest;
use App\Http\Requests\UpdateEmailStandardRequest;
use App\Models\EmailStandard;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EmailStandardController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('email_standard_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EmailStandard::query()->select(sprintf('%s.*', (new EmailStandard())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'email_standard_show';
                $editGate = 'email_standard_edit';
                $deleteGate = 'email_standard_delete';
                $crudRoutePart = 'email-standards';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('nome', function ($row) {
                return $row->nome ? $row->nome : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.emailStandards.index');
    }

    public function create()
    {
        abort_if(Gate::denies('email_standard_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.emailStandards.create');
    }

    public function store(StoreEmailStandardRequest $request)
    {
        $emailStandard = EmailStandard::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $emailStandard->id]);
        }

        return redirect()->route('admin.email-standards.index');
    }

    public function edit(EmailStandard $emailStandard)
    {
        abort_if(Gate::denies('email_standard_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.emailStandards.edit', compact('emailStandard'));
    }

    public function update(UpdateEmailStandardRequest $request, EmailStandard $emailStandard)
    {
        $emailStandard->update($request->all());

        return redirect()->route('admin.email-standards.index');
    }

    public function show(EmailStandard $emailStandard)
    {
        abort_if(Gate::denies('email_standard_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.emailStandards.show', compact('emailStandard'));
    }

    public function destroy(EmailStandard $emailStandard)
    {
        abort_if(Gate::denies('email_standard_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $emailStandard->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmailStandardRequest $request)
    {
        EmailStandard::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('email_standard_create') && Gate::denies('email_standard_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new EmailStandard();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
