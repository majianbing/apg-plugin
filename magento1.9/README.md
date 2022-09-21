# 一、安装步骤
- app、skin两个目录上传到magento发布目录下。
- 注意，如果网站开启编译、需要关闭编译状态，然后再上传插件文件。
- 编译状态是否开启，请检查 system->tools->Compilation； Compiler status应该是Disabled。

# 二、后台配置
后台系统 -> 配置 -> payment methods:

找到 Magento193 APG Payment，配置如下参数


- Enabled
  
  是否启用，选择启用

- Title		
  
  标题，输入支付方式标题，例如：APG Credit payment
  
- MerchantID	 
  
  商户id，从APG获取
  
- Key	
  
  密钥,从APG 处获取

- Gateway
  
  网关提交接口,填写 https://test.next-api.com/payment/page/v4/pay

- ReturnUrl
  
  回调地址填写 http://www.yourdomain.com/index.php/apgpay/payment/return

- NotifyUrl
  
  异步通知地址 http://www.yourdomain.com/index.php/apgpay/payment/notify

- New order status	
  
  新订单状态 选择 pending

- Order status when payment success by APG
  
  订单支付成功状态 选择 processing

- Describe
  
  描述出现在checkout onepage中的payment method下的描述,支持html

- Redirect Message 
  
  支付跳转时的描述信息,支持html. 例如：You will be redirected to the APG website in a few seconds.

- Sort order

  支付方式排序，按需设置，可以留空。

# 配置demo

如下图

![img](./flow.jpg)


# 推荐的测试方法

- mysql docker image 5.7

magento版本比较老，推荐使用mysql5.7; arm架构的可以参考[here](https://betterprogramming.pub/mysql-5-7-does-not-have-an-official-docker-image-on-arm-m1-mac-e55cbe093d4c)

启动完成后创建数据库备用

- magento docker  image 1.9.3

https://hub.docker.com/r/alexcheng/magento

启动后可以直接进入安装流程，mysql连接上一步创建好的数据库。
