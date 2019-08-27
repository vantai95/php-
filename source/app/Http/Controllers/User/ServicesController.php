<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Category;
use App\Models\Faq;
use App\Models\ServiceFeedback;
use App\Models\Contact;
use App\Models\Province;
use App\Models\RegisterAdvice;
use App\Models\Page;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use DB,Session,Validator;

class ServicesController extends Controller
{
    public function index(Request $request) {
        $lang = Session::get('locale');

        $services = Service::select("services.id","services.image", "services.name_$lang as service_name","services.slug" , "categories.name_$lang as category_name")
        ->join('categories' , "categories.id", "services.category_id")
        ->orderBy('services.created_at', 'desc');

        $provinces = Province::select('provinces.id',"provinces.name_$lang as name")->get();
        $province_id = $request->get('province_id');

        $categories = Category::select('categories.id',"categories.name_$lang as name")->get();

        $category_id= $request->input('category_id');
        if(!empty($category_id))
        {
            $services = Service::select("services.id","services.image", "services.name_$lang as service_name", "services.slug","categories.name_$lang as category_name")
            ->join('categories' , "categories.id", "services.category_id")
            ->where('services.category_id',$category_id)
            ->orderBy('services.created_at', 'desc');
        }

        $services = $services->paginate(9);
        $page = Page::where('name','=','service')->with('sections.data')->first();
        $sections = $page->sections;
        return view('user.services.list.list',compact('categories','services', 'province_id','provinces','category_id','sections'));
    }

    public function detail($slug, Request $request) {
        $lang = Session::get('locale');
        //related treatment
        $relatedTreament = Service::select("services.id","services.image", "services.name_$lang as service_name", "categories.name_$lang as category_name")
        ->join('categories' , "categories.id", "services.category_id")
        ->where('services.slug', '!=', $slug)
        ->orderBy('services.created_at', 'desc')
        ->take(3)->get();

        $services = Service::select("services.id", "services.name_$lang as name")->get();
        $service_id = $request->get('service_id');

        $serviceDetail = Service::select("services.*", "services.name_$lang as name", "services.short_description_$lang as short_description", "services.description_$lang as description")
        ->where('services.slug',$slug)->first();
        $faqsId = ($serviceDetail['faqs'] == null) ? [] : json_decode($serviceDetail['faqs']);

        $faqs = Faq::whereIn('id',$faqsId)->get();
        $feedbackId = ($serviceDetail['services_feedbacks'] == null) ? [] : json_decode($serviceDetail['services_feedbacks']);
        $feedbacks = ServiceFeedback::whereIn('id',$feedbackId)->get();
        return view('user.services.detail.detail',compact('serviceDetail','faqs','feedbacks','relatedTreament','services','service_id'));
    }
    public function customerService(Request $request) {
        $customMessages = [
            'name.required' => trans('b2c.service.index.validate.name'),
            'phone.required' => trans('b2c.service.index.validate.phone'),
            'province_id.required' => trans('b2c.service.index.validate.province'),
            'content.required' => trans('b2c.service.index.validate.content'),
         ];
        $validators = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'province_id' => 'required',
            'content' => 'required',
        ], $customMessages);

        if($validators->fails()){
            return response()->json([
                "success" => false,
                "message" => $validators->messages()
            ]);
        }
        $requestData = $request->all();
        $requestData['sequence'] = Contact::count() + 1;
        Contact::create($requestData);
        return response()->json(['error'=>false, 'done' => trans('b2c.service.index.validate.success')]);
    }

    public function registerAdvice(Request $request) {
        $customMessages = [
            'name.required' => trans('b2c.service.detail.validate.name'),
            'phone.required' => trans('b2c.service.detail.validate.phone'),
            'service_id.required' => trans('b2c.service.detail.validate.service'),
         ];
        $validators = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'service_id' => 'required',
        ], $customMessages);

        if($validators->fails()){
            return response()->json([
                "success" => false,
                "message" => $validators->messages()
            ]);
        }
        $requestData = $request->all();
        RegisterAdvice::create($requestData);
        return response()->json(['error'=>false, 'done' => trans('b2c.service.detail.validate.success')]);
    }
}
