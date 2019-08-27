<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\NewsType;
use App\Models\EventType;
use App\Models\News;
use App\Models\Service;
use App\Models\Category;
use Session;
use Carbon\Carbon;

class NewsController extends Controller
{
    public function detail($id) {
        $lang = Session::get('locale');

        $news = News::select('news.*', "news.name_$lang as name", "news.description_$lang as description")
        ->findOrFail($id);

        $events = Event::select('events.*', "events.name_$lang as name")
        ->orderBy('created_at', 'desc')->take(4)->get();

        $service = Service::select("services.id","services.image", "services.name_$lang as service_name", "categories.name_$lang as category_name")
        ->join('categories' , "categories.id", "services.category_id")
        ->orderBy('services.created_at', 'desc')
        ->take(3)->get();

        return view('user.news.detail',compact('events','news','service'));
    }
}
