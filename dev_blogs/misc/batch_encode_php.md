批量转码找到好工具了，用enca
【群主】Terry 2017/4/16 23:57:04
iconv还得判断原来的编码
enca不用
【群主】Terry 2017/4/16 23:57:05
#!/bin/bash

for file in `find ./ -name '*.php'`; do

  echo "$file"

 # iconv -f gb2312 -t utf8 -o $file $file
  enca -L zh_CN -x UTF-8 $file
done