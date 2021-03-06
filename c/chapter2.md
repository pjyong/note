# 编程初步

## 计算机内存
组成程序的指令和数据必须要存储到某个地方，这个地方就是机器的内存，也称为主内存(main memory)，或随机访问存储器(random access memory,RAM)。机器关机，RAM的内容会丢失。
可以将RAM想象成一排竟然有序的盒子，每个格子是0或1，格子也就是位(bit)。bit是计算机最小单位。

### 在KB,M,G换算中，为什么不使用更简单的整数？
1000在十进制中确实好用，但在二进制中就不好用了，11 1110 1000。而1023是由11 1111 1111表示，MB需要20个位。

### 为什么硬盘厂家标的容量和实际有差？
因为他们标的256GB，实际是表示2560亿字节，那么换算过来就是231GB。

## 变量
变量是计算机里一块特定的内存，它是由一个或多个连续的字节所组成，一般是1、2、4、8或16字节。

## 整数变量
整数是不能带小数点的，比如:2.0就是浮点数。

### 基本运算
+、-、×、/、%(取模Modules)。

一元运算符就是只有一个操作数，二元运算符就有两个操作数，比如上面的基本运算。

## 变量与内存
计算机内存组织为字节，每个变量都要占据一定数量的内存字节。

### 带符号的整数类型
* signed char = 1 Byte
* short int = 2 Bytes
* int = 4 Bytes
* long int = 4 Bytes
* long long int = 8 Bytes

为什么int和long int占相同字节？
* long int(长整型)和int(整型)，二者区别与编译器相关。
* 如果是16位编译器，int占2字节，范围为-32768~32767;long int占4字节，范围为-2147483648~2147483647
* 如果是32位编译器，int 和long均占4字节，范围均为-2147483648~2147483647
* 如果是64位编译器，int 占4字节，范围为-2147483648~2147483647;long因平台实现不同而不同，有4字节，6字节和8字节三种。可以打印sizeof(long)查看。

为什么short int是-32768-32767，负数比正数多1呢？
首先两个字节表示的最大数是2的15次方，即32767。而最高位1表示负数，0表示正数。当表示0的时候，后面15位都是0,如果最高位可以是1也可以是0,这样无疑是浪费。所以约定如果最高位是1，且其它位都是0就表示-32768。

* 一般来说都是64位编译器了，int 4Bytes，long int 8Bytes，其中long long int和long int一样。

### 无符号的整数类型
无符号用unsigned表示。使用无符号类型所提供的值不会多于对应的带符号类型，但其表示的数字比对应的带符号类型大一倍。

### 指定整数常量
什么是整数常量？比如100就是。那这100默认是整型。如果要指定为长整型可以这样。
```
long BigNumber = 100L;
unsigned int count = 100U;
unsigned long value = 999999999UL;
```

#### 十六进制常量
在数值前加0x或0X前缀

#### 八进制常量
很少使用，在数值前面加0前缀，比如014

## 使用浮点数

浮点数表示法，比如1.6在C语言中也可以写成0.16E1，0.00008就是0.8E-4。

## 定义命名常量

### 极限值
在limits.h头文件中，定义了数据类型的极限值。比如int最大值、long int最大值等。

### sizeof运算符
计算数据类型的字节。返回的size_t在标准头文件<stddef.h>中定义。用%u说明符输出它。
```
size_t size = sizeof(long long)
```

## 选择正确的类型
选择的数据类型，要使之包含我们所期望的值。选择错误的数据类型，程序就可能出现很难检测出来的错误。

## 强制类型转换
比如`(float)oneIntVar`

### 自动转换类型
编译器会进行隐式转换，在二元操作运算中，会自动将不同类型的数据转为值域较大的一种。

### 隐式类型转换的规则

### 赋值语句中的隐式类型转换

## 再谈数值数据类型

### 字符类型
无符号char类型变量的值是0~255，有符号是-128~127。字符是可以直接进行算术运算的。

### 枚举
枚举是一个类型，而不是变量。使用场景:就是希望变量在限定值范围内取值，就使用枚举。
```
enum Weekday {Mon,Tue,Wed,Thu,Fri,Sat,Sun};
enum Weekday today = Mon;
```
枚举器名称必须要求唯一，但值是可以不唯一的。并且值是默认+1的，比如当Mon=1时，Tue默认就是2，当Fri=10时Sat默认是11。

### 存储布尔类型的变量
如非特殊情况，在使用bool类型时，要`include <stdbool.h>`。因为bool类型是最近才加入的，如果不引入头文件就只能使用_Bool，不太好看。
