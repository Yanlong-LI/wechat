微信SDK
===
>希望打造一个尽量全面的微信平台管理工具，包含公众号、小程序、微信商户、移动app、网站app等。


当前为方便开发，第一个大版本中所有子扩展均集成在一起，并且主维护 公众号 功能， 后期将会单例拆分各个子扩展。

当前已更新 PHP7.4 类属性强类型，请注意您的PHP版本是否为 PHP7.4.0 及以上


### 更新日志
    
    2020年3月27日
    更新许可协议为MulanPSL2

    2020年1月3日
    去除 irc 值
    更改package包开源许可标识为MIT，请注意本项目不采用 MIT 开源许可，而是 MulanPSL 开源许可
    更新PHP依赖 >= 7.4.1
    
    2019年12月28日
    增加 链接 视频和短视频的监听Demo
    重新调整事件判定方式
    重新调整动作注册
    增加菜单的多个事件推送
    
    2019年12月5日
    改进服务注册支持 return 发送数据
    改进服务注册明确第二个参数为回调函数
    增加创建菜单的选项
    增加 模板消息发送成功事件
    增加发送模板后收到模板消息发送成功事件监听
    修复部分BUG
    增加 发送公众号模板消息 demo
    增加 创建公众号菜单 demo
    增加 消息事件监听服务默认动作处理
    修复 模板消息发送未写静态方法问题
    
    2019年12月4日
    修复部分错误
    增加一个临时accessToken 文件缓存，后期会调整
    
    2019年12月4日
    修正部分文档错误
    改进回复信息，移除 NoReplay 类，由 null 代替
    修复部分参数类型定义错误

    2019年12月4日
    修复部分错误
    增强类属性的类型定义
    更新PHP依赖版本PHP7.4及以上版本

    2019年11月22日
    处理服务注册及消息监听处理
    是的，就要完成基本的公众号工作了。现在需要处理一些细节，比如accessToken的获取和储存逻辑，log打印等

    2019年11月20日
    调整事件基础接口改为抽象类

    2019年11月14日
    补曾移动app类型
    增加Config类用于参数处理
    增加 消息事件 模型
    大量工作内容
    
    2019年11月13日
    改进服务调用方式改为静态方法，优化性能
    
    2019年11月7日
    初始化项目
    编排子扩展结构，方便后期拆分

### 说明 
本项目采用中国 木兰开源许可协议 

部分代码及处理方式逻辑来自 [pfinal/wechat](https://github.com/pfinal/wechat)


### 文档目录
* [微信APP定义](/doc/AppType.md)
* [命名规则](/doc/NamingRules.md)
