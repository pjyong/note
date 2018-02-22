# 字符串和文本的应用

## 什么是字符串
在C语言中，字符串都是以\0结尾，\0称为空字符串。所以字符串的长度总是比字符数多1。

## 存储字符串中的变量
```
char a[] = "abc,this is string";
char a[5] = "abcd";
char a[40] = "abcd";
```
上面第一种情况，编译器会自动分配足够内存给这个字符串变量。第三种情况，会在前5个字节写入字符串内容，其它为空。

## 字符串操作
```
#include <stdio.h>
#include <string.h>

int main(void)
{
    char test[50] = "abcd";
    printf("%lu \n", strlen(test));

    char test2[20];
    strcpy(test2, test);
    printf("%s \n", test2);

    char test3[5] = "efgh";
    printf("%s \n", strcat(test, test3));

    char test4[4] = "eeh";
    printf("%d \n", strcmp(test3, test4));
}
```
