
Share 的作用和功能说明
1.  和项目页面模块进行一对一的映射， 可以快速定位问题代码
3.  当其它项目需要用到我这个页面的某一部分数据时， 可以快速找到并调用， 避免产生重复多余代码
4.  可快速查到共享方法在哪些地方被调用
5.  可知道每个模块的执行时间，超过指定时间时，可进行详细记录（包括调用来源，调用参数, 调用时间）， 供性能优化参考
6.  可进行单元测试(单元测试输出调用api,传入参数,执行时间, 单元测试时开启所有报错)
7.  简单的调用方式    Share::module('Ask.Browse')->newQuestionList(1);
8.  可根据代码注释快速生成共享代码文档
9.  数据缓存只需要一行代码  $this->cacheTime(10); 
10. 自动检测每个共享方法的代码行数， 超过配置中指定行数不于执行
