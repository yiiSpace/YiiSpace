可以在B站看看 华为培训视频 istio


- pilot 大管家 做配置分发 同步静态配置到各个sidecar 

- mixer 服务混入器 原先服务的各个功能统一由mixer处理了 内部维护有adapter列表 这些adapter实现不同的功能
总的来说就两类 <<check>> 和 <<record>>
服务检查 如 权限控制 流量控制 白名单｜黑名单
服务监控记录收集 做调用链绘制 日志 监控 metrics

类似
~~~php

trait Mixer{

  // 添加
  protected IAdapter[] adapters ;


  public function register(IAdapter adpt)
  {

  }

  public function configure(){

  }


  public function check(...){
    ...
  }

  public function record(...){
    ...
  }

}

class ServiceX{
    use Mixer
    // istio是在架构级别使用这种理念的 类级别我们有其他选择 比如这里可以作为trait 把功能包含进来 本质上是一种复用 还可以作为内部依赖组件
}

class ServiceX2{
    protected Mixer mixer ; // 所有服务类共享一个mixer系统组件
}



~~~