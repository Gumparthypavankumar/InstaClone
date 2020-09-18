<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

use Intervention\Image\Facades\Image;

class PostsController extends Controller
{

    //write vnow the page can be visited through url without authorization but to authorize the user and to protect routes we use middleware to protect routes 
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create()
    {
        // the . is similar to posts/create you can use either of them
        return view('posts.create');
    }

    public function store()
    {
        //  if you have a field and you dont want to validate it but the request()->validate() will only return you the validated field array to overcome that issue we use 'another => ''
       $data = request()->validate([
            'caption' => 'required',
            'image' => ['required' , 'image'],
        ]);
        // general way of doing databse save is

        // $post = new App\Post();
        // $post->caption ='Cool Caption';
        // ...
        // $post->save();

        // But laravel provides you a better feature of that

        //\App\Post::create($data);
        // still you will get an Error because laravel protects the form data to be stored in database lets take a situation wher a user try to puh some extra data which your model does not have which create crash of app to avoid such things laravel guards application as we are validating (checking) every field so you can temporarily remove guarding by protected $guarded=[];

        $imagePath = request('image')->store('uploads','public');// Getting the path of image actually the file will put in a file which can not be understantable the store method creates a uploads directory and put that image path in uploads directory but to access in view you need to use php artisan storage:link command which basically links to the public folder which is open to the application you need to use this once in the lifetime of your application 
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(800,800);
        $image->save();
        // if you run the above command you are going to get an sql integrity constraint error for posts.user_id because of the relationship the there is a way to handle this get the authenticated user and post the images to that user account 

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath
        ]);
        //laravel adds the user id for the posts method in user model is returned which can have one to many relationship
        return redirect('profile/'. auth()->user()->id);
    }
    public function show(\App\Post $post)
    {
        // \App\Post by using this as a type will authenticate the data and then process request withou this you might get error if user types wrong url make a note that the argument must be same as url parameter
        return view('posts.show',compact('post'));
    }

    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');

        $posts = Post::whereIn('user_id',$users)->with('user')->latest()->paginate(5);

        $user = auth()->user();
        
        return view('posts.index', compact('posts','user'));
        
        return view('posts.index', compact('posts'));
    }
}
