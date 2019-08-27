<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Image;
use Session,Log;
use App\Services\CommonService;
use Illuminate\Support\Facades\File;

class FaqsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            'title' => __('admin.faq.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/faqs'),
                    'text' => __('admin.faq.breadcrumbs.faq_index')
                ]
            ]
        ];

        $keyword = $request->get('q');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage')>0 ? Session::get('perPage'):config('constants.PAGE_SIZE');
        $faqs = Faq::select('faqs.*' )->orderBy('faqs.id', 'desc');
      
        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $faqs = $faqs->where(function ($query) use ($keyword) {
                $query->orWhere('question_en', 'LIKE', $keyword);
                $query->orWhere('question_vi', 'LIKE', $keyword);
            });
        }
        $faqs = $faqs->paginate($perPage);
        return view('admin.faq.index', compact('breadcrumbs','faqs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $imageList = Image::get();

        foreach ($imageList as $image) {
            $image->size = $image->getFileSize();
        }
        $breadcrumbs = [
            'title' => __('admin.faq.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/faqs'),
                    'text' => __('admin.faq.breadcrumbs.faq_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.faq.breadcrumbs.add_faq')
                ]
            ]
        ];
        return view('admin.faq.create', compact( 'breadcrumbs', 'imageList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'question_vi' => 'required',
        ]);
        $requestData = $request->all();
        isset($requestData['question_en']) ? $requestData['question_en'] = $request->get('question_en') : $requestData['question_en'] = $requestData['question_vi'];

        Faq::create($requestData);
        Session::flash('flash_message', trans('admin.faq.flash_messages.new'));
        return redirect('admin/faqs');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      
        $faq = Faq::findOrFail($id);      
        $breadcrumbs = [
            'title' => __('admin.faq.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/faqs'),
                    'text' => __('admin.faq.breadcrumbs.faq_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.faq.breadcrumbs.edit_faq')
                ],
            ]
        ];
        return view('admin.faq.edit', compact('faq', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'question_en' => 'required',
        ]);

        $requestData = $request->all();
        $faq = Faq::findOrFail($id);
        isset($requestData['question_en']) ? $requestData['question_en'] = $request->get('question_en') : $requestData['question_en'] = $requestData['question_vi'];

        $faq->update($requestData);
        Session::flash('flash_message', trans('admin.faq.flash_messages.update'));
        return redirect('admin/faqs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);        
        $faq->delete();

        Session::flash('flash_message', __('admin.faq.flash_messages.destroy'));

        return redirect("admin/faqs");
    }

    public function upload()
    {
        return;
    }
}
