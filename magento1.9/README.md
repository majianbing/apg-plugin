# 一、安装步骤
app、skin两个目录上传到magento发布目录下
如果网站开启编译、需要关闭编译状态，然后再上传目录
编译状态是否开启，请检查
system->tools->Compilation
Compiler status应该是Disabled

apgpay的商户号需要绑定集成网站
http://www.xxx.com/index.php/apgpay/payment/notify

# 二、后台配置
后台系统->配置->payment methods:
91Magento apgpay Payment

Enabled		是否启用
Title		标题
MerchantID	商户id, 从apgpay支付接口处获取
Key		密钥,从apgpay支付接口处获取
Gateway		网关提交接口,填写 https://www.xxxx.com/payment/page/v4/pay
ReturnUrl   回调地址填写http://www.xxx.com/index.php/apgpay/payment/return
NotifyUrl	异步通知地址http://www.xxx.com/index.php/apgpay/payment/notify
New order status	新订单状态 选择pending
Order status when payment success by apgpay:订单支付成功状态 选择processing
Describe	描述出现在checkout onepage中的payment method下的描述,支持html
Redirect Message 支付跳转时的描述信息,支持html You will be redirected to the apgpay website in a few seconds.

