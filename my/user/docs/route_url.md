路由 url的设计问题
============================

restful 中有个嵌套资源的url格式
参考：[phoenix-routing](http://www.phoenixframework.org/docs/routing)

~~~elixir

    . . .
    user_post_path  GET     users/:user_id/posts HelloPhoenix.PostController :index
    user_post_path  GET     users/:user_id/posts/:id/edit HelloPhoenix.PostController :edit
    user_post_path  GET     users/:user_id/posts/new HelloPhoenix.PostController :new
    user_post_path  GET     users/:user_id/posts/:id HelloPhoenix.PostController :show
    user_post_path  POST    users/:user_id/posts HelloPhoenix.PostController :create
    user_post_path  PATCH   users/:user_id/posts/:id HelloPhoenix.PostController :update
                    PUT     users/:user_id/posts/:id HelloPhoenix.PostController :update
    user_post_path  DELETE  users/:user_id/posts/:id HelloPhoenix.PostController :delete
~~~

>   
    We see that each of these routes scopes the posts to a user ID. For the first one, we will invoke the PostController index action, but we will pass in a user_id. This implies that we would display all the posts for that individual user only. The same scoping applies for all these routes.
    
    When calling path helper functions for nested routes, we will need to pass the IDs in the order they came in the route definition. For the following show route, 42 is the user_id, and 17 is the post_id. Let's remember to alias our HelloPhoenix.Endpoint before we begin.
    
    iex> alias HelloPhoenix.Endpoint
    iex> HelloPhoenix.Router.Helpers.user_post_path(Endpoint, :show, 42, 17)
    "/users/42/posts/17"
    
    Again, if we add a key/value pair to the end of the function call, it is added to the query string.
    
    iex> HelloPhoenix.Router.Helpers.user_post_path(Endpoint, :index, 42, active: true)
    "/users/42/posts?active=true"



在多租户 系统中 这种url很常见  比如后台为用户 商户 管理资源 经常会以主实体（user store）为中心 然后资源进行crud功能设计
这样url中会一直携带主实体的id

## route group  |  scoped routes

>
        
        Scoped Routes
        
        Scopes are a way to group routes under a common path prefix and scoped set of plug middleware. We might want to
         do this for admin functionality, APIs, and especially for versioned APIs. Let's say we have user generated
         reviews on a site, and that those reviews first need to be approved by an admin. The semantics of these 
         resources are quite different, and they might not share the same controller. Scopes enable us to segregate
         these routes.
        
        The paths to the user facing reviews would look like a standard resource.
        
        /reviews
        /reviews/1234
        /reviews/1234/edit
        . . .
        
        The admin review paths could be prefixed with /admin.
        
        /admin/reviews
        /admin/reviews/1234
        /admin/reviews/1234/edit
        
### 版本化api
>
    scope "/api", HelloPhoenix.Api, as: :api do
      pipe_through :api
    
      scope "/v1", V1, as: :v1 do
        resources "/images",  ImageController
        resources "/reviews", ReviewController
        resources "/users",   UserController
      end
    end
    
    $ mix phoenix.routes tells us that we have the routes we're looking for.
    
     api_v1_image_path  GET     /api/v1/images HelloPhoenix.Api.V1.ImageController :index
     api_v1_image_path  GET     /api/v1/images/:id/edit HelloPhoenix.Api.V1.ImageController :edit
     api_v1_image_path  GET     /api/v1/images/new HelloPhoenix.Api.V1.ImageController :new
     api_v1_image_path  GET     /api/v1/images/:id HelloPhoenix.Api.V1.ImageController :show
     api_v1_image_path  POST    /api/v1/images HelloPhoenix.Api.V1.ImageController :create
     api_v1_image_path  PATCH   /api/v1/images/:id HelloPhoenix.Api.V1.ImageController :update
                        PUT     /api/v1/images/:id HelloPhoenix.Api.V1.ImageController :update
     api_v1_image_path  DELETE  /api/v1/images/:id HelloPhoenix.Api.V1.ImageController :delete
    api_v1_review_path  GET     /api/v1/reviews HelloPhoenix.Api.V1.ReviewController :index
    api_v1_review_path  GET     /api/v1/reviews/:id/edit HelloPhoenix.Api.V1.ReviewController :edit
    api_v1_review_path  GET     /api/v1/reviews/new HelloPhoenix.Api.V1.ReviewController :new
    api_v1_review_path  GET     /api/v1/reviews/:id HelloPhoenix.Api.V1.ReviewController :show
    api_v1_review_path  POST    /api/v1/reviews HelloPhoenix.Api.V1.ReviewController :create
    api_v1_review_path  PATCH   /api/v1/reviews/:id HelloPhoenix.Api.V1.ReviewController :update
                        PUT     /api/v1/reviews/:id HelloPhoenix.Api.V1.ReviewController :update
    api_v1_review_path  DELETE  /api/v1/reviews/:id HelloPhoenix.Api.V1.ReviewController :delete
      api_v1_user_path  GET     /api/v1/users HelloPhoenix.Api.V1.UserController :index
      api_v1_user_path  GET     /api/v1/users/:id/edit HelloPhoenix.Api.V1.UserController :edit
      api_v1_user_path  GET     /api/v1/users/new HelloPhoenix.Api.V1.UserController :new
      api_v1_user_path  GET     /api/v1/users/:id HelloPhoenix.Api.V1.UserController :show
      api_v1_user_path  POST    /api/v1/users HelloPhoenix.Api.V1.UserController :create
      api_v1_user_path  PATCH   /api/v1/users/:id HelloPhoenix.Api.V1.UserController :update
                        PUT     /api/v1/users/:id HelloPhoenix.Api.V1.UserController :update
      api_v1_user_path  DELETE  /api/v1/users/:id HelloPhoenix.Api.V1.UserController :delete
