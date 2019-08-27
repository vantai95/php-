<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Services\CommonService;
use Session, Log;
use Carbon\Carbon;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            'title' => __('admin.contacts.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/contacts'),
                    'text' => __('admin.contacts.breadcrumbs.contact_index')
                ]
            ]
        ];
        $keyword = $request->get('q');
        $contactDate = $request->get('contact-date');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage') > 0 ? Session::get('perPage') : config('constants.PAGE_SIZE');

        $contactList = Contact::orderBy('created_at','desc');
        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $contactList = $contactList->where('email', 'LIKE', $keyword);
        }

        if(!empty($contactDate)){
            $contactList = $contactList->whereDate('created_at','=',Carbon::parse($contactDate)->toDateString());
        }
        $contactList = $contactList->paginate($perPage);
        return view('admin.contacts.index', compact('contactList','breadcrumbs'));
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
            'title' => __('admin.contacts.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/contacts'),
                    'text' => __('admin.contacts.breadcrumbs.contact_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.contacts.breadcrumbs.contact_update')
                ]
            ]
        ];
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.edit', compact('contact','breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $requestData = $request->all();
        $contact = Contact::findOrFail($id);
        $contact->update($requestData);
        Session::flash('flash_message', trans('admin.contacts.flash_message.update'));
        return redirect('admin/contacts');
    }

    public function show($id)
    {
        $breadcrumbs = [
            'title' => __('admin.contacts.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/contacts'),
                    'text' => __('admin.contacts.breadcrumbs.contact_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.contacts.breadcrumbs.contact_detail')
                ]
            ]
        ];
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.show', compact('contact','breadcrumbs'));
    }
}
