<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use App;
use Lang;
use App\Models\Newsletter;
use App\Models\Promotion;
use Session, Log, Exception;
use Auth;
use Validator;
use App\Models\News;
use App\Models\NewsType;
use App\Models\Category;
use App\Services\CommonService;
use App\Models\Page;

class HomesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $lang = Session::get('locale');
        $news = News::select('news.*', "news.name_$lang as name", "news.short_description_$lang as short_description","news_types.name_$lang as news_type_name")
        ->join('news_types', 'news.news_type_id', 'news_types.id')
        ->orderBy('created_at', 'desc')->take(4)->get();
        $promotions = Promotion::select("name_$lang as name", "description_$lang as description", "image", "short_description_$lang as short_description")
        ->where(function($query){
          $query->where(function($querySub){
            $date = date('Y-m-d h:i:s');
            $querySub->where('begin_date','<=',$date)->where('end_date','>=',$date);
          })
          ->orWhere(function($querySub){
            $querySub->whereNull('begin_date')->whereNull('end_date');
          });
        })
        ->where('show_in_home_page',1)
        ->where('active',1)
        ->get();
        $page = Page::where('name','=','home')->with('sections.data')->first();
        $sections = $page->sections;

        $categories = Category::select("id","name_$lang as name", "description_$lang as description", 'image')
        ->with(['category_metas' => function($query) use ($lang){
          $query->select('id','category_id',"name_$lang as name");
        }])->limit(3)->get();

        $promotions = $promotions->map(function($promotion){
          $promotion->image = CommonService::imgUrl($promotion->image);
          return $promotion;
        });
        return view('user.home.home',compact('news','promotions','sections','categories'));
    }

    public function changeLocalization($language)
    {
        App::setLocale($language);
        Session::put('locale', $language);
        return redirect()->back();
    }

    public function subscribe(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if($validators->fails()){
            return response()->json([
                "success" => false,
                "message" => $validators->messages()
            ]);
        }
        $requestData = $request->all();
        Newsletter::create($requestData);
        return response()->json(['success'=>true]);
    }
}
