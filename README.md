[toc]

# 0. 简介
> 博客模版，包含后代管理和前台页面（web端和移动端）

# 1. 环境搭建
## 1.1 tp5.0
## 1.1 php及其相关扩展
```
yum search php-json
yum search php-mbstring
yum search php-pdo
yum search mysqlnd //php的mysql驱动
yum search php-gd //captcha验证码使用·
```

## 1.2 php-fpm
```
yum search php-fpm
修改配置文件 /etc/php-fpm.d/www.conf：
    1. 更改启动的user：
        user = work
        group = work
    2. 更改监听的地址：
        listen = 0.0.0.0:9000
        listen = /run/php-fpm/www.sock
    3. 更改启动的主进程数：
        pm.start_servers = 2
        pm.min_spare_servers = 2
    
测试配置文件
sudo php-fpm -t
```
## 1.3 composer
```
yum search composer
1. 设置中国镜像
composer config -g repo.packagist composer https://packagist.phpcomposer.com
```
## 1.4 nginx
> 1. nginx启动指定配置文件时注意路径要是绝对路径
> 2. 还要注意路径权限的问题

## 1.5 mysql
> 1. systemctl start mysqld
> 2. 根据项目application/database.php配置数据库，如下：
```
    // 数据库类型
    'type'            => 'mysql',
    // 服务器地址
    'hostname'        => '127.0.0.1',
    // 数据库名
    'database'        => 'blog',
    // 用户名
    'username'        => 'root',
    // 密码
    'password'        => '123456',
```

## 1.6 redis
> systemctl start redis

## 1.7 sphinx
### 1.7.1 安装（http://sphinxsearch.com/）
> 1. ./configure --prefix=/usr/local/sphinx --with-mysql
> 2. make & make install

### 1.7.2 配置sphinx.conf

### 1.7.3 启动
> 1. 生成索引: indexer --all

> 2. 启动: searched


# 2. 修改配置
## 1. session默认保存位置
> 1. application/config.php，修改如下

```
'session'                => [
    'id'             => '',
    // SESSION_ID的提交变量,解决flash上传跨域
    'var_session_id' => '',
    // SESSION 前缀
    'prefix'         => 'think',
    // 驱动方式 支持redis memcache memcached
    'type'           => '',
    // 是否自动开启 SESSION
    'auto_start'     => true,
    'path' => '/home/work/tp-blog/runtime/session', //session默认保存位置
    // 'expire' => 86400, //过期时间设置
],
```

# 3. 使用第三方包
## 2.1 引入captcha 1.*版本
> 
composer require topthink/think-captcha 1.*

## 2.2 引入think-image 处理图片
> composer require topthink/think-image

# FAQ
## 1. 
