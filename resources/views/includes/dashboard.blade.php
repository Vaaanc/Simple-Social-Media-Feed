
<section class="row create-post">
    <div class="col-md-offset-2 col-md-6">
            <h1>Welcome {{ Auth::user()->name }} </h1>
        <header class="pull-left">What's on your mind?</header>
        <span id="text-length" class="pull-right">0/250</span>
        <form method="POST">
                {{ csrf_field() }}
            <div class="form-group">
                <textarea class="form-control"id="newpost" name="newpost" rows="4" placeholder="Your Post" required></textarea>
            </div>
            <button type="submit" id="btn-post" class="btn btn-primary">Post!</button>
        </form>
    </div>
</section>
<section class="row show-post">
    <div class="col-md-offset-2 col-md-6" id="posts-container">
        @if(count($posts) > 0)
        @foreach($posts as $post)
            <div id="post" data-postid="{{$post->id}}">
                @if(Auth::user() == $post->user)
                    <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="" class="edit">Edit</a></li>
                            <li><a href="" class="delete">Delete</a></li>
                        </ul>
                    </div>
                @endif
                <div class="poster-name">
                    <a href="#">{{$post->user->name}}</a>
                </div>
                <div class="post-content">{{$post->content}}
                    <div class="image">
                        {{$post->image}}
                    </div>
                </div>
                <small class="post-date">{{ Carbon\Carbon::parse($post->created_at)->format('M/d/Y - D') }}
                </small>
            </div>
        @endforeach
            <!--pagination-->
        {{$posts->links()}}
        @else
            <h1>No post found, try posting something.</h1>
        @endif

    </div>
</section>
<div class="modal fade" id="edit-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Edit Post</h5>
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-message">
                </div>
                <form>
                    <div class="form-group">
                        <label for="post">Edit post</label>
                        <span id="text-length-modal" class="pull-right">0/250</span>
                        <textarea class="form-control" name="post-edit" id="post-edit" rows="4"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="modal-save" >Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
<script>
    var token = "{{ Session::token() }}";
    var url ="{{ route('edit')}} ";
    var deleteUrl ="{{ route('del') }}";
    var postUrl = "{{ route('post') }}";
</script>