<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Log;

class EmailTemplatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            'title' => __('admin.email_templates.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/email_templates'),
                    'text' => __('admin.email_templates.breadcrumbs.email_templates_index')
                ]
            ]
        ]; 
        session(['mainPage' => $request->fullUrl()]);

        $keyword = $request->get('q');
        $status = $request->get('status');
        $lang = Session::get('locale');
        
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage')>0 ? Session::get('perPage'):config('constants.PAGE_SIZE');
       
        $email_templates = EmailTemplate::select('email_templates.*', "email_templates.name_$lang as name")
           ->orderBy('email_templates.id', 'desc');

        if ($status == EmailTemplate::STATUS_FILTER['inactive']) {
            $email_templates = $email_templates->where('email_templates.active', '=', false);
        } elseif ($status == EmailTemplate::STATUS_FILTER['active']) {
            $email_templates = $email_templates->where('email_templates.active', '=', true);
        } else {
            $status = "";
        }
        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $email_templates = $email_templates->where(function ($query) use ($keyword) {
                $query->orWhere('email_templates.name_en', 'LIKE', $keyword);
                $query->orWhere('email_templates.name_vi', 'LIKE', $keyword);
                $query->orWhere('email_templates.name_ja', 'LIKE', $keyword);
            });
        }

        $email_templates = $email_templates->paginate($perPage);
        return view ('admin.email_templates.index',compact('email_templates', 'status', 'breadcrumbs','lang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $breadcrumbs = [
            'title' => __('admin.email_templates.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/email_templates'),
                    'text' => __('admin.email_templates.breadcrumbs.email_templates_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.email_templates.breadcrumbs.email_templates_create')
                ]
            ]
        ];
        
        return view('admin.email_templates.create', compact('breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name_en' => 'required',
            'description_en' => 'required'
        ]);
        $requestData = $request->all();
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;

        
        EmailTemplate::create($requestData);

        Session::flash('flash_message', trans('admin.email_templates.flash_message.new'));

        return redirect('admin/email-templates');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $breadcrumbs = [
            'title' => __('admin.email_templates.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/email_templates'),
                    'text' => __('admin.email_templates.breadcrumbs.email_templates_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.email_templates.breadcrumbs.email_templates_update')
                ]
            ]
        ];
        $email_template = EmailTemplate::findOrFail($id);
        return view('admin.email_templates.edit',compact('email_template', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param Request|\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $this->validate($request,[
            'name_en' => 'required',
            'description_en' => 'html_required'
        ]);
        $requestData = $request->all();
        isset($requestData['active']) ? $requestData['active'] = true : $requestData['active'] = false;
        $email_template = EmailTemplate::findOrFail($id);
        $flag = false;

        $email_template->update($requestData);
        Session::flash('flash_message', trans('admin.email_templates.flash_message.update'));
        return redirect('admin/email-templates');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $email_template = EmailTemplate::findOrFail($id);
        $email_template->delete();
        Session::flash('flash_message', trans('admin.email_templates.flash_message.destroy'));
        return redirect('admin/email-templates');
    }

    public function upload(){
        return;
    }
}
