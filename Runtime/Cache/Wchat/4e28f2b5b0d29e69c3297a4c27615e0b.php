<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->

<!-- Bootstrap -->
<link href="/Public/Wchat/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="/Public/Wchat/css/style.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

    <style>
        .main{margin-bottom: 60px;}
        .indexLabel{padding: 10px 0; margin: 10px 0 0; color: #fff;}
    </style>


<title><?php echo C('WEB_SITE_TITLE');?></title>

</head>
<body>
<div class="main">
	<!-- 头部 -->
	<div class="container-fluid">
	<div id="top-alert" class="fixed alert alert-error bg-danger" style="display: none;margin-top: 10%;">
		<button class="close fixed" style="margin-top: 4px;">&times;</button>
		<div class="alert-content">这是内容</div>
	</div>
</div>


<!--导航部分-->
<nav class="navbar navbar-default navbar-fixed-bottom">
	<div class="container-fluid text-center">
		<?php if(is_array($channel)): $i = 0; $__LIST__ = $channel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="col-xs-3">
			<p class="navbar-text"><a href="<?php echo U($vo['url']);?>" class="navbar-link"><?php echo ($vo["title"]); ?></a></p>
		</div><?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
</nav>
<!--导航结束-->

	<!-- /头部 -->
	
	<!-- 主体 -->
	

  <div class="container">

    <form class="form-signin login-form" action="/wchat.php/User/login.html" method="post">
      <h2 class="form-signin-heading">登陆</h2>
      <p>
        <label for="inputUsername" class="sr-only">用户名</label>
        <input type="text" name="username" id="inputUsername" class="form-control" placeholder="请填写用户名" errormsg="请填写1-16位用户名" nullmsg="请填写用户名" required autofocus>
      </p>

      <p>
        <label for="inputPassword" class="sr-only">密码</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="密码为6-20位" required>
      </p>

      <p>
        <label for="inputVerify" class="sr-only">验证码</label>
        <input type="text" id="inputVerify" name="verify" class="form-control" placeholder="请填写5位验证码" required>
      </p>
      <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
          <img class="verifyimg reloadverify" alt="点击切换" src="<?php echo U('Wchat/verify');?>" style="cursor:pointer;">
        </div>
        <div class="controls Validform_checktip text-warning"></div>
      </div>

      <button class="btn btn-lg btn-primary btn-block" type="submit">登陆</button>
    </form>
	<p class="text-danger text-right"><a href="<?php echo U('register');?>">新用户注册</a></p>
  </div>
  <!-- /container -->


	<!-- /主体 -->

	<!-- 底部 -->
	
    <!-- 底部
    ================================================== -->
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="/Public/Wchat/js/jquery-1.11.2.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="/Public/Wchat/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript">
(function(){
	var ThinkPHP = window.Think = {
		"ROOT"   : "", //当前网站地址
		"APP"    : "/wchat.php", //当前项目地址
		"PUBLIC" : "/Public", //项目公共目录地址
		"DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
		"MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
		"VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
	}
})();
</script>

  <script type="text/javascript">
    $(document)
      .ajaxStart(function () {
        $("button:submit").addClass("log-in").attr("disabled", true);
      })
      .ajaxStop(function () {
        $("button:submit").removeClass("log-in").attr("disabled", false);
      });


    $("form").submit(function () {
      var self = $(this);
      $.post(self.attr("action"), self.serialize(), success, "json");
      return false;

      function success(data) {
        if (data.status) {
          window.location.href = data.url;
        } else {
          self.find(".Validform_checktip").text(data.info);
          //刷新验证码
          $(".reloadverify").click();
        }
      }
    });

    $(function () {
      var verifyimg = $(".verifyimg").attr("src");
      $(".reloadverify").click(function () {
        if (verifyimg.indexOf('?') > 0) {
          $(".verifyimg").attr("src", verifyimg + '&random=' + Math.random());
        } else {
          $(".verifyimg").attr("src", verifyimg.replace(/\?.*$/, '') + '?' + Math.random());
        }
      });
    });
  </script>
 <!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<div class="hidden"><!-- 用于加载统计代码等隐藏元素 -->
	
</div>

	<!-- /底部 -->
</div>
</body>
</html>