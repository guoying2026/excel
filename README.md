simple-mvc
==========

请注意部署到服务器时，public为入口文件的目录

修改数据库配置app/database.php

用户验证，没有用数据表验证，在app/core/app.php的__construct()方法中手动向数组$remote_user中添加有效用户。通过获取$_SERVER['REMOTE_USER']与数组（有效用户）的$remote_user进行对比，如果不存在，则验证失败，登录不进去。如果存在，则成功。

如果excel表读取行列变了，要修改app目录下controllers下的home.php中的upload方法。

后端框架，最简易的mvc框架，查看composer.json

前端框架，是layui,官网地址https://www.layui.com

上传文件所存放的目录是public/upload

app/models是数据库模型

app/viewModels是对数据表的增删改查

Report查看当前季度信息

upload file上传文件

Dashboard选择季度查看对应的所有文件，选择完文件之后，会跳转到Version's Detail详情页

Delete all data 是删除所有表数据
