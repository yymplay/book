<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016080200148122",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEpAIBAAKCAQEAu0287wCJNgJryjJfB8bDAUXiI/Us1RO4/Al/5BgWJuRax1g5gj0NUARCqZEmu19P3TEx9plL4RuTCZSTgfno/KioPivUEzW9AL2+WXBc028ji6wOxBhkGJ+9YQPIvk6VH0UHiAzXOYoLS0eTKc/W7dEMGdi0cRM0C2zLB4Q/FmvceISWFPHaBUjsoF70zSXtWvIED+kIr19cEO4F82m0jXJaTuUA6lwdmycixgA0oXw10+CLHaZNInfoKH9ImijRgyBR8iVFLwWpo5RalHSgVu2vjkNrhzwkWGf+sBJbrH8oYf1Mw8//nqsBmUWdsxtyXVwo1OIHD9tptO8qh9RPcwIDAQABAoIBAEdz03R1huKEr+wVpS0JRRDyQN+owy6R9IqpcRFpouG5UWwkmuO1OKPizC91wQnPxV7DSqUhO9InO8N224LE/H2ONYhqHeAqKuzidYAXHkJGbo/01jk2eNDv90XQNL9sqPSh18qt41j+8WoJZvmXYQ2eJvihM8zDH6KQIS+/4nVBjwizWcKk5yL9hFeYy1aimYCvUp/SorB3HEiA1NXIzHDvO9WJoS3J8zrrYHcjXVIBZDsdM7nozBY0KK5I28VBcJfF1KOEFvk0neDoI8iAErQo8BcH5r5CbE7NSC14zwQmZYTzQKEUiQ9BPHAKS4SQ6Qqs3pqjqus8PKUYKDlVVUkCgYEA6ks5cxyw1sonNfgxefJmAkDYYUt7Bxb6vkkfU+hmMIYKPQL4+39XoP49HC92TRZsk+eHhBQ25Z71vG+zo9veifHiMs+CPkrz+U2D8ffv7akx9XPsqsjEcydHMKQnv5IDqTQsEDMeN5VJtzSg4Sb9eQz6N86/miYw2WHJDryZW48CgYEAzKgKsbMO6ZzUx7HH7z5XL7mK5yqRJKzStGn4etMpF7zdpZZ9/UszqQ3ZwuYp2je79l/LckEkt4FgSgbI8JD6UfVXLxXEuGwA/LfaHHvVxeAgQbdiMV4cfhgTeR81PbxduTQDvhe2Rm+w5XVrLy5UCv3ksr3XFkls4bdGCudc690CgYEAj6oUzisXnH1U0dkgrYAfYN5WUEKya8SBeFDqLs9gafynJoY+GikZmJSM8E2CIv7PEVp1VF3405BHaoasBpv5t2hkpXdsi7n2JDaN479+laKcCcBNrONy4pGBK6hc3zEvoX9mTYCq1LZr/zT8OVNpNeLpQ3M5NdKZPZKicLDg8K0CgYAG+FIk6yw+2JCGnI9qnnzpqzAH33NCBIDIlDNaO4bSwCPsV8vCrKT9xPL9qEkUnYFRSsHrCjzt4wIcg06kostjry9g8yTYAxWlhb1v6ufE7XUrx8sYU1Q1FyzSmzV8/MVUYWkfOD+E9pjXt8AGw1Upaqw3Si/hGm8S4OMJzAdmIQKBgQC+zrHtx3o/zMSL88mSKcY4zBD5WNGMM9ehvFImvn4p6lsclIcPy3+TqlFbav3LAnRqiigqHFgGUtLTT+7865+2AIbNi+5clEavG0E34xVDBYm/TazNmkEMvVKQj76M64D1bn/yT84eugnQ6U1t5+z0Xpgm4LXUy/nlllcMcYMdCw==",
		
		//异步通知地址
		'notify_url' => "http://test.izhiwo.com/service/return_url",
		
		//同步跳转
		'return_url' => "http://www.baidu.com",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA5J9AeacaB1jgc5felOFG0wZzSkoFI0W7J6M+dxpla1Wcjw1Hwmkbqm0ruTsuQiPK6yq+chkzHzuJziKOUloxhln53mY3ROAqmP4Tv5Y9f1sXemaJY7nSi51+riFXBqkXvSoL2SIl/4kp7Y7C1KhP825dIL4EWco7/ZXbaMrfcyBn5YmMBRjPjpdmH5WYWJgL46oGjfivkk3Gr0izAaLaTnVwD//vuv/eRv1p33pBa7Rt2Ky2R3TWHsuti8K8eSFgY+w2sOKI37DCBWd3crapz+21ccRqEYkISkv1mELaWyV4L6rK77McMVSsRc1PYRJ4dzObgsJP47X580eOcIWzjwIDAQAB",

		
	
);