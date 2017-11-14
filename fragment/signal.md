# Linux进程间通信

## 什么是信号

信号是Unix和Linux系统为响应某些条件产生的一个事件，接收到该信号的进程会相应采取一些行动。

## 信号类型

```
信号　　　值　　处理动作　发出信号的原因
--------------------------------------------
SIGHUP    1　　　 　A　　终端挂起或者控制进程终止
SIGINT    2　　　 　A　　键盘中断（如break键被按下）
SIGQUIT   3　　 　  C　　键盘的退出键被按下
SIGILL    4　　 　　C　　非法指令
SIGABRT   6　　　　 C　　由abort(3)发出的退出指令
SIGFPE    8　　　　 C　　浮点异常
SIGKILL   9　　  　 AEF　 Kill信号
SIGSEGV   11　　 　 C　　无效的内存引用
SIGPIPE   13　　 　 A　　管道破裂: 写一个没有读端口的管道
SIGALRM   14　　　  A　　由alarm(2)发出的信号
SIGTERM   15　　　  A　　终止信号
SIGUSR1   30,10,16  A　　用户自定义信号1
SIGUSR2   31,12,17  A　　用户自定义信号2
SIGCHLD   20,17,18  B　　子进程结束信号
SIGCONT   19,18,25 　　　进程继续（曾被停止的进程）
SIGSTOP   17,19,23  DEF　终止进程
SIGTSTP   18,20,24  D　　控制终端（tty）上按下停止键
SIGTTIN   21,21,26  D　　后台进程企图从控制终端读
SIGTTOU   22,22,27  D　　后台进程企图从控制终端写
```

## 信号的处理

在C语言中，`signal`函数接收两个参数，信号类型和处理函数，PHP的`pcntl_signal`也一样。我们可以用它来改变进程的默认行为，比如实现一个功能，用户在第一次按`Ctrl+C`时进程不会中断而是打印一段文字，在第二次时就会中断。

```
#include <signal.h>
#include <stdio.h>
#include <unistd.h>

void ouch(int sig)
{
	printf("\nOUCH! - I got signal %d\n", sig);
	// 恢复终端中断信号SIGINT的默认行为
	(void) signal(SIGINT, SIG_DFL);
}

int main()
{
	// 改变终端中断信号SIGINT的默认行为，使之执行ouch函数
	// 而不是终止程序的执行
	(void) signal(SIGINT, ouch);
	while(1)
	{
		printf("Hello World!\n");
		sleep(1);
	}
	return 0;
}
```

## 发送信号

在C语言中，`kill`函数接收两个参数，进程id和信号类型，PHP的`posix_kill`也一样。

有次在看Workerman源码时发现里面有发送信号类型为0来检查进程是否在运行中，实际上并没有真正地发送信号，它仅仅只是检测进程是否在运行。

## 信号处理函数的安全问题

当进程接收到一个信号时，转到你的回调函数中执行，但是在执行的时候，又收到同一个信号或另一个信号又要执行你的回调函数时，程序会怎么执行？

信号处理函数可以在执行期间被中断并被再次调用。我们要求处理函数是“可重入的”，即中断后再次进入执行。
