# MySQL基准测试

基准测试就是针对系统的一种压力测试。

## 2.1-为什么要基准测试

* 重现某些异常行为
* 验证基于系统假设
* 测试当前运行情况
* 规划未来业务增长
* ...

基准测试不是真实的压力测试。真实压力测试是不可预期且变化多端的，有时候难以解释，可能很难从中分析出确切的结论。

## 2.2-基准测试的策略

* 集成式(full-stack)基准测试。就是针对针对整个系统。
* 单组件式(single-component)单组件式基准测试。仅仅针对MySQL。

### 测试何种指标

* 吞吐量
* 响应时间或延迟
* 并发性
* 可拓展性

## 2.3-基准测试的方法

## 2.4-基准测试工具

* 集成测试工具
  * ab
  * http_load(可以测试多个不同的url)
  * JMeter
* 单组件式
  * sysbench
  * mysqlslap
  * MySQL Benchmark Suite
  * ...

## 2.5-基准测试案例

### sysbench

* sysbench的CPU基准测试
```
// 测试计算素数直到某个最大值所需要的时间
sysbench cpu --cpu-max-prime=200000 run
```
* sysbench的文件I/O基准测试
```
sysbench fileio --file-total-size=10G prepare
sysbench fileio --file-total-size=10G --file-test-mode=rndrw --time=300 --events=0 run
sysbench fileio --file-total-size=10G cleanup
```
* sysbench的oltp基准测试
```
sysbench ./oltp_common.lua --db-driver=mysql --mysql-socket=/app/data/mysql/mysql.sock --mysql-db=masterdb1 --mysql-user=root --mysql-password=root --table-size=1000000 prepare
sysbench ./oltp_read_only.lua --db-driver=mysql --mysql-socket=/app/data/mysql/mysql.sock --mysql-db=masterdb1 --mysql-user=root --mysql-password=root --table-size=1000000 --time=60  --events=0 --threads=8 run
```

### 图表工具(R或gnuplot)

将统计出来的数值转换成图表，能更容易帮助你发现问题
