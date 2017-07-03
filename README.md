# yaf-seed 2.0

## 目录说明
1. system 目录是对yaf进行了进一步的封装
2. 每个站点一个目录，如：site1
3. 各个站点的核心配置文件放在system目录下，这样正式环境如果用版本管理系统对配置进行管理时可以分权限
4. 跨站点公用的东西放在system目录下
5. system/core对yaf进行了一些封装
6. system/library提供了一些常用函数，同时对yaf进行封装

## 进行了哪些封装
1. 各个站点目录下不需要写 Yaf_* 的类，因为真的很恶心
2. 通过bootstrap覆盖route结果，把各个站点根目录下的controllers目录和view目录干掉。
3. yaf自带的异常句柄不太好用，而且必须放在根目录下controllers目录里。
4. 引入laravel ardent
5. 引入swoole来做消息队列

