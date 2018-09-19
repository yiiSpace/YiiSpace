验证：

[https://github.com/laravelbook/ardent](https://github.com/laravelbook/ardent)

此是标准laravel做法

```
        
        Route::post('register', function() {
                $rules = array(
                    'name'                  => 'required|min:3|max:80|alpha_dash',
                    'email'                 => 'required|between:3,64|email|unique:users',
                    'password'              => 'required|alpha_num|between:4,8|confirmed',
                    'password_confirmation' => 'required|alpha_num|between:4,8'
                );
        
                $validator = Validator::make(Input::all(), $rules);
        
                if ($validator->passes()) {
                    User::create(array(
                            'name'     => Input::get('name'),
                            'email'    => Input::get('email'),
                            'password' => Hash::make(Input::get('password'))
                        ));
        
                    return Redirect::to('/')->with('message', 'Thanks for registering!');
                } else {
                    return Redirect::to('/')->withErrors($validator->getMessages());
                }
            }
        );

```
上面例子中可看出，验证 跟创建这两个操作 被明晰的分离了  验证通过了再创建实体
 yii的标准gii逻辑跟此是不同的，yii中是先用request（<Input>）填充实体(AR) , 然后save （此中先要过验证这一关 验证失败会
 把错误存储在改实体上的 $ar->errors 属性上）
 >
       /**
           * Creates a new Brand model.
           * If creation is successful, the browser will be redirected to the 'view' page.
           * @return mixed
           */
          public function actionCreate()
          {
              $model = new Brand();
      
              if ($model->load(Yii::$app->request->post()) && $model->save()) {
                  return $this->redirect(['view', 'id' => $model->id]);
              } else {
      
                  return $this->render('create', [
                      'model' => $model,
                      ...
              }
          }
          
->save() 的逻辑其实等价：  $model->validate() && $model->save(false) 
          即： 先验证，如果成功了再存储（save 通过传递false参数显式的跳过验证）



下面是用了Ardent后的做法

~~~

            class User extends \LaravelBook\Ardent\Ardent {
              public static $rules = array(
                'name'                  => 'required|between:4,16',
                'email'                 => 'required|email',
                'password'              => 'required|alpha_num|between:4,8|confirmed',
                'password_confirmation' => 'required|alpha_num|between:4,8',
              );
            }
~~~

看出这种思路也是想往yii的方式上靠拢。
            
跟yii的区别 ：
            
> 通过**静态属性** 配置验证规则

这种设计决策跟方法的细微差距：

通过方法有更多的便利。
    方法中 可以有动态决策  但属性（或者静态属性）不能实现这种需求
    
    if(Config::get('verifyCodeEnable')){
        $rules[] = [
            'verify' => ...
        ] ;
    }

## 主要设计中采用方法或者属性作为 **协议** 的差别

不要忘了简单实用的CRC

方法框架中往往需要协作者，具备某些功能（某些属性）
此时可以让协作者具备某个属性或者方法即可

但这两种决策灵活性正如上面所指出，属性往往不及方法灵活！！！



验证功能可采取的设计方法
=============
有的框架中 把验证功能跟模块的其他逻辑独立开来了 这样用来保证model类的“纯洁”。然后用验证引擎 去验证 
**数据(input)+验证规则配置**
然后查看验证器验证是否通过 如果通过了 再把 **纯净** 的数据传递给model

yii 是把验证功能内置在Model中了 所以要采取上面的形式也是可以做到的 ：就是用DynamicModel

```php

      public function actionSearch($name, $email)
      {
          $model = DynamicModel::validateData(compact('name', 'email'), [
              [['name', 'email'], 'string', 'max' => 128],
              ['email', 'email'],
          ]);
          if ($model->hasErrors()) {
              // validation fails
          } else {
              // validation succeeds
          }
      }
      // 动态添加其他验证规则
       /**
       * $model = new DynamicModel(compact('name', 'email'));
       * $model->addRule(['name', 'email'], 'string', ['max' => 128])
       *     ->addRule('email', 'email')
       *     ->validate();
       ...
```


            
            