<?php

namespace App\Http\Controllers;
use App\Post;
use App\User;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;
use Illuminate\Http\Request;
class PostController extends Controller
{
	public function index()
	{
		 //fetch 5 posts from database which are active and latest
        $posts = Post::where('active',1)->orderBy('created_at','desc')->paginate(5);
        //page heading
        $title = 'Latest Posts';
        //return home.blade.php template from resources/views folder
        return view('posts.home')->withPosts($posts)->withTitle($title);
	}
    public function create(Request $request)
	{
		// if user can post i.e. user is admin or author
		if($request->user()->can_post())
		{
			return view('posts.create');
		}    
		else 
		{
			return redirect('/')->withErrors('You have not sufficient permissions for writing post');
		}
	}
	public function store(PostFormRequest $request)
	{
		$post = new Post();
		$post->title = $request->get('title');
		$post->content = $request->get('content');
		$post->slug = str_slug($post->title);
		$post->author_id = $request->user()->id;
		if($request->has('save'))
		{
		  $post->active = 0;
		  $message = 'Post saved successfully';            
		}            
		else 
		{
		  $post->active = 1;
		  $message = 'Post published successfully';
		}
		$post->save();
		return redirect('edit/'.$post->slug)->withMessage($message);
	}
	public function show($slug)
	  {
	    $post = Post::where('slug',$slug)->first();
	    if(!$post)
	    {
	       return redirect('/')->withErrors('requested page not found');
	    }
	    $comments = $post->comments;
	    return view('posts.show')->withPost($post)->withComments($comments);
	  }
	public function edit(Request $request,$slug)
  { 
    $post = Post::where('slug',$slug)->first();
    if($post && ($request->user()->id == $post->author_id || $request->user()->is_admin()))
      return view('posts.edit')->with('post',$post);
    return redirect('/')->withErrors('you have not sufficient permissions');
  }
  public function update(Request $request)
  {
    //
    $post_id = $request->input('post_id');
    $post = Post::find($post_id);
    if($post && ($post->author_id == $request->user()->id || $request->user()->is_admin()))
    {
      $title = $request->input('title');
      $slug = str_slug($title);
      $duplicate = Post::where('slug',$slug)->first();
      if($duplicate)
      {
        if($duplicate->id != $post_id)
        {
          return redirect('posts/edit/'.$post->slug)->withErrors('Title already exists.')->withInput();
        }
        else 
        {
          $post->slug = $slug;
        }
      }
      $post->title = $title;
      $post->content = $request->input('content');
      if($request->has('save'))
      {
        $post->active = 0;
        $message = 'Post saved successfully';
        $landing = 'posts/edit/'.$post->slug;
      }            
      else {
        $post->active = 1;
        $message = 'Post updated successfully';
        $landing = 'posts';
      }
      $post->save();
           return redirect($landing)->withMessage($message);
    }
    else
    {
      return redirect('/')->withErrors('you have not sufficient permissions');
    }
  }
public function delete(Request $request, $id)
  {
    //
    $post = Post::find($id);
    if($post && ($post->author_id == $request->user()->id || $request->user()->is_admin()))
    {
      $post->delete();
      $data['message'] = 'Post deleted Successfully';
    }
    else 
    {
      $data['errors'] = 'Invalid Operation. You have not sufficient permissions';
    }
    return redirect('/')->with($data);
  }
  public function active()
  {
    # code...ajax
  }

  public static function prevBlogPostUrl($id) {
        $blog = static::where('id', '<', $id)->orderBy('id', 'desc')->first();

        return $blog ? $blog->url : '#';
    }

    public static function nextBlogPostUrl($id) {
        $blog = static::where('id', '>', $id)->orderBy('id', 'asc')->first();

        return $blog ? $blog->url : '#';
    }

    public function tags() {
        return $this->belongsToMany('App\BlogTag','blog_post_tags','post_id','tag_id');
    }

}
