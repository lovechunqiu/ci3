<!doctype html>
<html>
    <head>
        <meta charset='utf-8' />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <!-- Mobile Metas --> 
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
        <title><?php echo implode('-', array_reverse($title))?></title>
        <meta name="Keywords" content="<?php echo implode(',', $meta_keywords)?>"/>
        <meta name="Description" content="<?php echo $meta_desc?>"/>
        <link rel="shortcut icon" href="<?php echo static_url('static/images/favicon.ico');?>" type="image/x-icon"/>
        <?php if(!empty($meta_location)):?>
        <meta name="location" content="<?php echo $meta_location?>">
        <?php endif;?>
        <?php if(!empty($meta_mobile_agent)):?>
        <meta http-equiv="mobile-agent" content="format=xhtml; url=<?php echo $meta_mobile_agent?>">
        <?php endif;?>

        <?php if(!empty($css)): ?>
        <?php foreach($css as $link_url): ?>
        <link rel="stylesheet" type="text/css" href="<?php echo static_url($link_url)?>?v=<?php echo C("release.last_release")?>" />
        <?php endforeach; ?>
        <?php endif; ?>

        <?php if(!empty($script)): ?>
        <?php foreach($script as $link_url): ?>
        <script type="text/javascript" src="<?php echo static_url($link_url)?>?v=<?php echo C("release.last_release")?>"></script>
        <?php endforeach; ?>
        <?php endif; ?>
    </head>
