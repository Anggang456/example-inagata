<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use Carbon\Carbon;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $news = News::with('user')->where('user_id', Auth::user()->id)->get();
        return view('home', compact('news'));
    }

    public function welcome()
    {
        $latestNews = News::with('user')->latest()->first();
        $otherNews = collect();
    
        if ($latestNews) {
            $otherNews = News::with('user')->where('id', '!=', $latestNews->id)->latest()->take(3)->get();
        }
    
        return view('welcome', compact('latestNews', 'otherNews'));
    }
    

    public function make(Request $request)
    {
        $date = Carbon::now();
        $request->validate([
            'title' => 'required|string',
            'image' => 'required|image|max:1024',
            'description' => 'required|string',
        ]);

        $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();

        News::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'image' => $uploadedFileUrl,
            'upload' => $date,
            'description' => $request->description,
        ]);

        return redirect()->route('home')->with('success', 'News item created successfully!');
    }

    public function update(Request $request, $id)
    {
        $date = Carbon::now();
        $request->validate([
            'title' => 'required|string',
            'image' => 'nullable|image|max:1024',
            'description' => 'required|string',
        ]);

        $newsItem = News::findOrFail($id);

        if ($request->hasFile('image')) {
            $publicId = basename($newsItem->image, '.' . pathinfo($newsItem->image, PATHINFO_EXTENSION));
            Cloudinary::destroy($publicId);
            $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            $newsItem->image = $uploadedFileUrl;
        }

        $newsItem->title = $request->title;
        $newsItem->description = $request->description;
        $newsItem->upload = $date;
        $newsItem->save();

        return redirect('home');
    }

    public function delete($id)
    {
        $newsItem = News::findOrFail($id);
        $publicId = basename($newsItem->image, '.' . pathinfo($newsItem->image, PATHINFO_EXTENSION));
        Cloudinary::destroy($publicId);
        $newsItem->delete();
        return redirect()->route('home')->with('success', 'News item deleted successfully!');
    }


    public function profile()
    {
        $image = User::where('id', Auth::user()->id)->first();
        return view('profile',compact('image'));
    }

    public function update_profile(Request $request) 
    {
        $request->validate([
            'image' => 'nullable|image|max:1024',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'fname' => 'required|string|max:50',
            'lname' => 'required|string|max:50',
            'number' => 'required|string',
            'company' => 'required|string|max:50'
        ]);

        $user = User::findOrFail(Auth::user()->id);
        if ($request->hasFile('image')) {
            $publicId = basename($user->image, '.' . pathinfo($user->image, PATHINFO_EXTENSION));
            Cloudinary::destroy($publicId);
            $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            $user->image = $uploadedFileUrl;
        }
        $user->name = $request->name;
        $user->address = $request->address;
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->number = $request->number;
        $user->company = $request->company;
        $user->save();

        return redirect()->route('profile');
    }
}
