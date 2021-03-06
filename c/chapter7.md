# 指针

## 指针初探
指针是用来存储地址的变量。既然是地址，为什么声明指针时，需要加上各种数据类型呢？
在程序使用指针变量时，编译器除了分配一块16进制(8个字节)的内存外，还需要分配该指针地址存储的内容，如果没有类型，编译器就不知道分配多少内存，也无法通过指针存储的地址去获取这些内容。

### 声明指针
任何指针声明，必须得初始化。比如设置为NULL。

指针本身占用的8个字节内存，存储一个16进制的数字。这个跟编译器有关。

## 数组和指针
数组和指针很像，数组名称(不带索引)就是引用了数组第一个元算的地址。下面显示的地址值是一样的。
```
char a[5] = "abcd";
char *p = &a[0];
printf("%p", p);
p = a;
printf("%p", p);
```
但是两者又有区别，指针变量的值(存储的地址)是可以改变的，但是数组名称引用的地址就不行了(可以改变数组的内容)。

## 多维数组
二维数组名称跟二级指针很像。二级指针存储的是一级指针的地址。在内存中，二维数组实际就是多个一维数组。

### 访问数组元素
比如有`a[3][3]`这样一个数组，访问`a[1][2]`，可以用`*(a[0]+5)`，也可以`*(a[1]+2)`，`*(*a+5)`。

## 内存的使用

在程序执行期间分配内存的时，内存区域这个空间称为堆(heap)，还有另一个内存区域，称为栈(stack)，这个空间会分配给函数参数和本地变量。在执行完这个函数后，栈就会释放，而堆却是由程序员控制的。

### 动态内存分配

### 释放动态分配的内存
