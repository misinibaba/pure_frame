## 此框架为laravel的简略版，用于在需要高性能需求，且需要部分laravel功能的场景
### 框架可以使用eloquent也可以使用原生sql
### 框架可以使用blade


# 初始化
#### 1.安装composer依赖
#### 2.根据自身配置config下的配置
#### 3.配置route下的路由


# 目录解析
##### bootstrap：框架初始化相关代码
##### cache：暂时只有blade的前端缓存在里面
##### component：各种组键的初始化
##### config：配置文件
##### Http：用户代码
##### Kernel：依赖注入容器以及各组键provider等
##### Public：可直接访问的文件
##### resource：目前是放的blade前端文件
##### Route：路由文件
