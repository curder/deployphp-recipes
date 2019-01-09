## Deployer部署时的钉钉通知

### 使用

本项目是[Deployer](https://github.com/deployphp/deployer)的一个部署通知，所以使用之前需要您安装好deployer/deployer（建议您完成一次成功部署之后再来配置）。

```
composer require curder/deployphp-recipes
```

在您的部署配置文件`deploy.php`文件中添加文件的引入：

```
require __DIR__.'/packages/curder/deployphp-recipes/dingtalk.php';
```

### 配置
修改本地部署文件添加如下语句：

```
// config access token value
set('dingtalk_access_token', '');

// DingTalk text
set('dingtalk_text', '_{{user}}_ deploying **domain.com** `{{branch}}` to *{{target}}*');
set('dingtalk_failure_text', 'Deploy to **domain.com** *{{target}}* failed');
set('dingtalk_success_text', 'Deploy to **domain.com** *{{target}}* successful');

// Handle notify
before('deploy:info', 'dingtalk:notify');
after('success', 'dingtalk:notify:success');
after('deploy:failed', 'dingtalk:notify:failure');
```

> 获取对应通知到的钉钉群的token值，获取方式通过下面的网址中获取。
> 将上述代码中的**domain.com**换成您自己可辨识的部署目标网址即可。

## 参考链接

* [Deployer](https://github.com/deployphp/deployer)

* [DingTalk](https://open-doc.dingtalk.com/docs/doc.htm?spm=a219a.7629140.0.0.karFPe&treeId=257&articleId=105735&docType=1)
