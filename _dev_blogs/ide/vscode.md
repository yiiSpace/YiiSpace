[vscode实用插件推荐](https://zhuanlan.zhihu.com/p/441608260)


导出自己当前的插件列表 防止换机器插件丢失（当然如果有账号同步 可以忽略）
vscode 自带导出功能 
> code --list-extensions >vs-extensions.txt

导入：
win powerShell
> cat vs-extensions.txt | %{ code --install-extension $_ }

下面👇的没有试过哦 不知道好用不😯
linux | osx | wsl
> cat vs-extensions.txt | xargs code --install-extensions {}

## 快捷键

把快捷键 键盘映射 改为 JetBrains家族的了

有时候不清楚是不是来自jb 也可能是其他扩展的快捷键
- command+i : 代码智能提示
  command+ .

- ctrl+o 当前行下新插入一个空行 有点vi的意思
- shift+o 是可以在当前行下开一行的 且光标自动跳至下行行首
