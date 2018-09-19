对于分层架构

可以用命令行进入任意一个层 进行接口调用 
>
    In [1]: from models import User, db
    In [2]: user = User.create("charlie@gmail.com", password="secret",
    name="Charlie")
    In [3]: print user.password
    $2a$12$q.rRa.6Y2IEF1omVIzkPieWfsNJzpWN6nNofBxuMQDKn.As/8dzoG
    In [4]: db.session.add(user)
    In [5]: db.session.commit()
    In [6]: User.authenticate("charlie@gmail.com", "secret")
    Out[6]: <User u"Charlie">
    In [7]: User.authenticate("charlie@gmail.com", "incorrect")
    Out[7]: False
    
python 中（flask） 可以直接从命令行导入模型层的东西 并直接进行接口调用 不需要麻烦的先做个UI接口 这样很方便 可以快速验证功能 ！！
好像 phoenix 也有这种能力   
这种能力 使得可以从 db --》  model --》 UI 这样的顺序开发 