对于某个用户的资源管理 
============

资源（entity）是有 属主的  此时gii生出的crud代码需要改造

>
    # controllers/video_controller.ex
    defp user_videos(user) do
    assoc(user, :videos)
    end
    
    We use the assoc function, also imported from Ecto, to return a query of all videos scoped to the given user. 
    Next, we use the new user_videos function in the index and show actions:

~~~
       
       #controllers/video_controller.ex
       def index(conn, _params , user) do
        videos  = Repo.all(user_videos(user))
        render(conn, "index.html", videos: videos)
       end
       
       def show(conn, %{"id"=> id} , user) do
        video = Repo.get!(user_videos(user), id)
        render(conn, "show.html", video: video)
       end
~~~   
   
The only difference is that we’re using our new query instead of the default one that returns all videos. 
Notice that we’re using user_videos even in the show action that fetches videos by ID. 
This guarantees that users can only access the information from videos they own.
If the ID of a video the user doesn’t own is given, Ecto raises an error saying that the record couldn’t be found. 
Let’s do the same change to edit and update to ensure that they can only change videos coming from the association:   

...
Finally, we need to do the same for delete:
...

Once again, we fetch a video from the scoped list of user videos. After those changes, our users have a panel for
managing their videos in a safe way. Using Ecto.assoc, we built a simple authorization rule restricting deletes and
updates to the video’s owner.

可以看出 这里的处理是通过改造Query 来限制只能够查询当前用户的资源。 对所有的 CRUD 代码都做了这种改造（包括delete哦！）

在SNS程序中 这种问题很常见 这也就给了我们如何改造CRUD的一种启示。 