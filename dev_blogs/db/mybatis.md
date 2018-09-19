## 类结构
    Entities
        User
        (POJO   { attributes setter/getter })
    Mappers
        UserMapper
        ( 全是接口型  这个在spring最后应该是动态实现了一个单体 )
        Controller中直接通过  userMapper.xxx 访问方法！
    Service
        UserService