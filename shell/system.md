# 系统

使用终端模式登录，终端又称tty。默认情况下，Linux提供6个终端。就我当前的系统Ubuntu17.10(以下所有系统都是此版本)，我是在终端tty2下。如果切换到其它终端，比如第三个，就按Ctrl+Alt+F3。要返回当前终端就按Ctrl+Alt+F7。

## 系统启动流程
* 计算机加载BIOS，这是最接近硬件的软件。它会对自身的硬件做一次健康检查，英文中称Power On Self Test(POST)。
* BIOS开始引导系统，会从硬盘第0柱面、第0磁道、第一扇区中读取MBR(主引导记录)。MBR记录了引导程序和分区信息，只有512个字节(引导程序占446个字节，磁盘分区表占64字节，最后2个字节是结束位)。MBR是由某程序生成的，比如fdisk。
* 运行GRUB。因为现代操作系统引导程序比较大，MBR存不下，所以MBR只存放GRUB地址，具体的引导操作交给GRUB。GRUB会加载kenel镜像，并运行第一个程序/sbin/init，这个程序会根据/etc/inittab(我的系统是没有这个文件的，但是可以自己创建个)来初始化工作。内容格式"id:3:initdefault:"，其中3就是runlevel(我的系统是5)。
* 系统根据上面定义的runlevel设置系统变量、网络配置，启动swap等。
* 根据runlevel，运行/etc/rc3.d/下面的脚本(在runlevel为3的情况下)。
* 运行/etc/rc.local。
* 生成终端等待用户登录。

## 系统运行级别
就是上面说的runlevel，有7个级别
* 运行级0:关机
* 运行级1:单用户模式，系统出现问题可以进这种模式维护。典型场景是忘记root密码时进此模式修改。
* 运行级2:多用户模式，但是没有网络连接。
* 运行级3:完全多用户模式，一般linux服务器都是这种。
* 运行级4:保留未使用。
* 运行级5:窗口模式，支持多用户，支持网络。(桌面系统都是这种)
* 运行级6:重启

读取对应某个级别下的所有脚本(/etc/rcX.d，X代表0-6)。脚本名称格式，以K(停止kill)或S(开启start)开头，中间的两位数是脚本执行顺序，最后的字母是服务的名称。实际上这些脚本都是链接自/etc/init.d/。系统会根据文件名称调用对应的命令，比如K01atd，就是/etc/init.d/atd stop。

GRUB
一般配置文件在/etc/grub/grub.conf。磁盘命名，第一个磁盘是sda，第二个就是sdb。磁盘分区的命名就是第一个磁盘第一个分区sda0，第二个分区是sda1。而grub使用hd0代表第一个磁盘，(hd0,0)就是第一个磁盘第一个分区。

initrd，初始化的内存磁盘，就是系统启动时的临时文件系统，通过它来获取各种可执行文件和设备驱动，并挂载真实的文件系统。一旦完成，就会卸载这个临时文件系统。

# 用户

## UID和GID
用户信息都在/etc/passwd里可见，其密码是存在/etc/shadow。后面这个文件仅root可读。这种密码保存方式叫“影子密码”。即便是加密的密码都有可被破解的可能性，最好是连加密的密码也不让你知道。

useradd newuser会执行以下几个步骤
* 系统会在上面两个用户信息文件追加记录，并生成新的UID
* 创建home目录
* 复制/etc/skel/目录下的文件到/home/newuser下。默认就是几个隐藏文件，比如.bashrc(只针对指定用户的初始化脚本)。

## su和sudo的区别
su默认是切换到root，后面跟用户名su newuser并输入相应密码切换到该用户。su newuser和su - newuser的区别是后者切换用户会一并切到该用户home目录。

su的缺点是你不得不把root密码告诉别人才能完成超级管理员的动作。

针对上面这个缺点，sudo就可以解决。sudo的本质是输入当前用户的密码来验证此用户是否被root允许做此类动作。其配置文件在/etc/sudoers。

## 例行任务

* 在单一时刻执行一次，用at
* 周期性执行，用cron

# 文件和目录管理

Ubuntu根目录:
* /bin 常见用户指令
* /cdrom
* /etc 系统和服务的配置文件
* /lib 系统函数库目录
* /lib64 64位函数库目录
* /lib32
* /lost+found ext3文件系统需要的目录，用于磁盘检查
* /mnt 系统加载文件系统时常用的挂载点
* /proc 虚拟文件系统，在内存里
* /run
* /snap Ubuntu的snap程序
* /tmp 临时文件夹
* /boot 内核和启动文件
* /dev 设备文件
* /home 用户根目录
* /media 挂在光驱等临时文件系统的挂载点
* /opt 第三方软件安装目录
* /root
* /sbin 系统指令
* /srv
* /sys
* /usr 存放与用户相关的文件和目录
* /var 动态数据，比如日志文件


## 文件相关常用命令
* dos2unix 换行符转换
* touch 除了新建文件，还可以**更新文件的时间戳**
* ls -al 第一列文件类型:
 * d 目录
 * - 普通文件
 * l 链接文件
 * b 块文件
 * c 字符文件
 * s socket文件
 * p 管道文件
* lsattr 查看文件隐藏属性
* chattr 更改文件隐藏属性
* umask 遮罩值，比如值是022，那么----w--w-，那么默认文件的权限就被遮了两位,rwxr-xr-x，即755。
* find -mtime -n/+n
* locate 定位文件，linux会将文件记录到数据库，使用locate比find更快。但是新创建的文件，必须updatedb之后，才能locate。
* which/whereis 查找执行文件。whereis相比which会找出man文件
* cpio 打包工具，不单独使用，与find结合
* sort
* uniq
* tr
* cut
* split
* tr

### grep 正则表达式匹配行
```
# 匹配单个单词
grep '\<start\>' README.md
grep '\bstart\b' README.md
# 匹配含有这个单词的行数
grep -c '\bstart\b' README.md
# 遍历查找
grep -rn ./ -e 'start'
# 使用\{\}
grep "\(test\)\{2\}" ttt
```

### sed 针对流的文本行编辑工具
默认并不会更改源文件，只打印。如果要修改源文件就必须加-i，或者重定向。
* d 删除
* s 查找替换
* i或a 插入
* r 读入
* p 打印
* w 写文件

```
# 匹配字符串
sed -n '/test/p' filename
# 打印第一行
sed -n '1p' filename
# sed 删除行首空格
sed 's/^[ ]*//g' filename
# 在行后或行前添加新行
sed 's/pattern/&\n/g' filename
sed 's/pattern/\n&/g' filename
# 使用变量替换
sed -e "s/$var1/$var2/g" filename
# 在第一行前插入文本
sed -i '1i\被插入的文本' filename
# 在最后一行插入
sed -i '$a\被插入的文本' filename
# 在匹配的行前插入sed
sed -i '/pattern/i被插入的文本' t2
# 删除文本中的空行和以#注释的行
grep -v  ^# t2 | sed '/^\s*$/d'  | sed '/^$/d'
# 有时候我们会写sed脚本，比如sed.rule:
s/bbbb/haha/
$a\xxxx
# 然后执行这个脚本
sed -f sed.rule filename
# 将test行下面的的bbbb替换成haha
sed '/test/{n;s/bbbb/haha/g}' ttt
sed -n '/pattern/p' file_name |sed -n 7,12p
sed -n '/pattern/{7,12p}' file_name
```

### awk 基于列的文本处理工具
awk认为文件都是结构化的，即由单词和空白字符(空格，tab等)组成。每个非空白的地方叫“域”，其中$0表示全部域，$1是第一个域...
```
# 指定分隔符
netstat -tlnp | awk -F: '{print $1}'
# 计算分隔的列数
netstat -tlnp | awk -F: '{print NF}'
# 打印每行倒数第二列
netstat -tlnp | awk '{print $(NF-1)}'
# 截取字符串，第一列第四个字符串到结束
netstat -tlnp | awk '{print substr($1, 4)}'
# 计算所有进程ID之和
ps -aux | grep mysql-workbench-bin | awk 'BEGIN{total=0}{total+=$2}END{print total}'
```
