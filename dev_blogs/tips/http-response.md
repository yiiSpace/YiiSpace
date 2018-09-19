http响应
===========================

对请求性质的不同 响应的不同


laravel 中的做法：
-----------------------------

~~~
     
        
    namespace App\Http\Middleware;
    
    use Closure;
    use Illuminate\Contracts\Auth\Guard;
    
    class Authenticate
    {
        /**
         * The Guard implementation.
         *
         * @var Guard
         */
        protected $auth;
    
        /**
         * Create a new filter instance.
         *
         * @param  Guard  $auth
         * @return void
         */
        public function __construct(Guard $auth)
        {
            $this->auth = $auth;
        }
    
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle($request, Closure $next)
        {
            if ($this->auth->guest()) {
                if ($request->ajax()) {
                    return response('Unauthorized.', 401);
                } else {
                    return redirect()->guest('auth/login');
                }
            }
    
            return $next($request);
        }
    }
 
~~~

对应ajax api式  未登录 验证是用抛401异常的做法

对于常规http请求 是重定向到登录页面的。

另一例

~~~

    public function handle($request, \Closure $next) {
    if ( ! $this->auth->user()->isAdministrator()) {
    if ($this->request->ajax()) {
    return response('Forbidden.', 403);
    } else {
    throw new AccessDeniedHttpException;
    }
    }
    }

~~~