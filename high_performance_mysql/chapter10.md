# 复制

## 10.1-复制概述

MySQL复制方式有两种：基于行的复制和基于语句的复制。这两种都是通过在主库记录二进制日志，在从库重放来实现数据复制。

复制解决的问题:
* 数据分布。很容易将数据同步到其他服务器。
* 负载均衡。用虚拟IP将查询分配到多台服务器。
* 备份。
* 高可用和故障切换。随时将从库变成主库。
* MySQL升级测试。如果要升级最新版本，可以考虑建新版本从库，看有没问题。

复制如何工作：
* 在主库记录二进制日志
* 从库将主库上的日志复制到自己的中继日志
* 重放中继日志

从库有两个线程SQL线程和IO线程。这两个线程是独立的。这意味着在主库中并发查询，到从库也必须串行化。

## 10.2-配置复制

简要几步：
* 在每台服务器上创建帐号
* 配置主库和从库
* 通知从库连接主库复制数据


主库
```
[mysqld]  
log-bin=mysql-bin  
server-id=1 //给数据库服务的唯一标识，一般为大家设置服务器Ip的末尾号
```

从库
```
[mysqld]  
log-bin=mysql-bin  //也可以不要开启log-bin
server-id=2 //给数据库服务的唯一标识，一般为大家设置服务器Ip的末尾号
```

主从断掉？

查看从库错误(在从库中执行):
```
'Could not execute Update_rows event on table testrepl.new_table; Can''t find record in ''new_table'', Error_code: 1032; handler error HA_ERR_KEY_NOT_FOUND; the event''s master log mysql-bin.000001, end_log_pos 2314'
// 意思就是说执行到2314的时候断掉了，那么从2314开始即可
// 如果可以，尽量把从库的数据或结构搞到跟主库一样，启动服务即可，不然就继续下面步骤
```
查看主库日志(在主库中执行)：
```
show master logs;
show binlog events in 'mysql-bin.000001';
show binlog events in 'mysql-bin.000001' FROM 2314 LIMIT 0,20;
```
重新设置起点：
```
stop slave
change master to master_host = '192.168.0.106',  master_user = 'root', master_password = 'PASSWORD',
master_log_file='mysql-bin.000001',master_log_pos=2314

```
注意了：truncate 主库表是不会因为主从库表不一致而产生问题,而delete或者update都会产生问题
