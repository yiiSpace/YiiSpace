
### 命令风格

- 一般形式

>  cmd  -option  --longOption arguments

选项是用来决定cmd行为的  可以通过指定选项来改变默认行为
-option 短选项 可以跟多个 比如 -va (verbose and all)
--longOption   --all --verbose  长风格 一般是端风格的完整字符串

题外话
hadoop FsCommand FsShell 实现很有意思 里面有一段解析实现命令的代码
[Command::run](https://github.com/apache/hadoop/blob/trunk/hadoop-common-project/hadoop-common/src/main/java/org/apache/hadoop/fs/shell/Command.java#L169)

#### 常见的option
- v verbose  冗长模式  会打印有用的“啰嗦”信息
- i interactive 交互模式  需不需要人为确定 还是一路执行到底



- 复数形式

cp src dist
cp src1 src2 ...  dist    拷贝多个文件到一个目标去

ls file1 file2 ...        ls命令接受 一到多个参数

rm item...

### rm 

| Option   |     long-option      |  Meaning |
|:----------|:-------------:|------:|
| -i       |  --interactive |    执行删除已有文件前 进行prompt提示询问确认  |
| -r       |  --recursive   |    递归删除    |
| -f       |  --force       |    强制        |
| -v       |  --verbose     |    当执行删除时显示信息       |

rm删除消息是不可逆的 没有unrm  
一个好的做法是在搭配通配符时  先用ls 再删除 防止误操作  然后替换ls 为rm命令


### markdown 表格

| 左对齐标题 | 右对齐标题 | 居中对齐标题 |
| :------| ------: | :------: |
| 短文本 | 中等文本 | 稍微长一点的文本 |
| 稍微长一点的文本 | 短文本 | 中等文本 |


