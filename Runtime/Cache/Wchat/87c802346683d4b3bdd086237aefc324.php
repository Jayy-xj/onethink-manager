<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="/Public/Wchat/bootstrap/css/bootstrap.css" rel="stylesheet">
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
</head>
<body>
<div class="main">
    <!--导航部分-->
    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container-fluid text-center">
            <div class="col-xs-3">
                <p class="navbar-text"><a href="<?php echo U('Index/index');?>" class="navbar-link">首页</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">服务</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">发现</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">我的</a></p>
            </div>
        </div>
    </nav>
    <!--导航结束-->

    <div class="container-fluid" id="content_list">
        <?php if(is_array($notices)): $i = 0; $__LIST__ = $notices;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="row noticeList">
            <a href="<?php echo U('Shop/detail',['id'=>$vo['id']]);?>">
                <div class="col-xs-2">
                    <img class="img-rounded img-responsive" src="<?php echo ($vo["image"]); ?>" />
                </div>
                <div class="col-xs-10">
                    <p class="title"><?php echo ($vo["title"]); ?></p>
                    <p class="intro"><?php echo ($vo["description"]); ?></p>
                    <p class="info">浏览: <?php echo ($vo["view"]); ?> <span class="pull-right"><?php echo ($vo["create_time"]); ?></span> </p>
                </div>
            </a>
        </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <div class="text-center">
        <button type="button" class="btn btn-info ajax-page">获取更多..</button>
    </div>
</div>

    <link href="/Public/Wchat/js/my.js" />

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/Public/Wchat/js/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/Public/Wchat/bootstrap/js/bootstrap.js"></script>
<script type="application/javascript">
    var p = 1;
    var url = '/wchat.php/Shop/notice';
    var inner_url = '/wchat.php/Shop/detail';
    $(function(){
        $('.ajax-page').click(function () {
            if($(this).hasClass('ajax-page')){
                p = p+1;
                $.get(url+'/p/'+p,function(data){
//                    console.debug(data);
                    if(data){
//                        console.debug(data['0']['status']);
                        list = data;
//                        console.debug(list);
                        html = '';
                        for(index in list){
                            inner = list[index];
//                            console.debug(inner['title']);
                            html += '<div class="row noticeList">\
                                            <a href="'+inner_url+'/id/'+inner['id']+'">\
                                                <div class="col-xs-2">\
                                                    <img class="img-rounded img-responsive" src="'+inner['image']+'" />\
                                                </div>\
                                                <div class="col-xs-10">\
                                                    <p class="title">'+inner['title']+'</p>\
                                                    <p class="intro">'+inner['description']+'</p>\
                                                    <p class="info">浏览: '+inner['view']+' <span class="pull-right">'+inner['create_time']+'</span> </p>\
                                                </div>\
                                            </a>\
                                        </div>';
                        }
                        $('#content_list').append(html);
                    } else {
                        $('.ajax-page').html("没有更多数据了").removeClass('ajax-page')
                    }
                })
            }
        });

    });
</script>
</body>
</html>