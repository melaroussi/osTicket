<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="pragma" content="no-cache" />
    <title><?php echo ($ost && ($title=$ost->getPageTitle()))?$title:'Research Requests'; ?></title>
    <!--[if IE]>
    <style type="text/css">
        .tip_shadow { display:block !important; }
    </style>
    <![endif]-->
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-ui-1.10.3.custom.min.js"></script>
    <script type="text/javascript" src="../js/jquery.multifile.js"></script>
    <script type="text/javascript" src="./js/tips.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor.min.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-osticket.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-fonts.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/bootstrap.js"></script>
    <script type="text/javascript" src="./js/bootstrap-typeahead.js"></script>
    <script type="text/javascript" src="./js/scp.js"></script>
    <script type="text/javascript" src="./js/highlight.js"></script>
    <script type="text/javascript" src="./js/highlight-function.js"></script>
    <!-- unicornblast.js -->
    <script src="./js/jquery.unicornblast.js"></script>
    <script type="text/javascript">
      function printTextArea() {
        childWindow = window.open();
        childWindow.document.write('<html><head></head><body><h2>');
        childWindow.document.write(document.getElementById('subject').innerHTML);
        childWindow.document.write('</h2><p>');
        childWindow.document.write(document.getElementById('response').value.replace(/\n/gi,'<br>'));
        childWindow.document.write('</p></body></html>');
        childWindow.print();
        childWindow.document.close();
        childWindow.close();
      }
    </script>
    <!-- Google Analytics -->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','http://www.google-analytics.com/analytics.js','ga');
        
        ga('create', 'UA-10013579-1', 'rockarch.org');
        ga('send', 'pageview');

    </script>
    <link rel="stylesheet" href="<?php echo ROOT_PATH ?>css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="<?php echo ROOT_PATH ?>css/thread.css" media="screen">
    <link rel="stylesheet" href="./css/scp.css" media="screen">
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/redactor.css" media="screen">
    <link rel="stylesheet" href="./css/typeahead.css" media="screen">
    <link type="text/css" href="<?php echo ROOT_PATH; ?>css/ui-lightness/jquery-ui-1.10.3.custom.min.css"
         rel="stylesheet" media="screen" />
     <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/font-awesome.min.css">
    <!--[if IE 7]>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/font-awesome-ie7.min.css">
    <![endif]-->
    <link type="text/css" rel="stylesheet" href="./css/dropdown.css">
    <script type="text/javascript" src="./js/jquery.dropdown.js"></script>
    <?php
    if($ost && ($headers=$ost->getExtraHeaders())) {
        echo "\n\t".implode("\n\t", $headers)."\n";
    }
    ?>
</head>
<body>
<div id="container">
    <?php
    if($ost->getError())
        echo sprintf('<div id="error_bar">%s</div>', $ost->getError());
    elseif($ost->getWarning())
        echo sprintf('<div id="warning_bar">%s</div>', $ost->getWarning());
    elseif($ost->getNotice())
        echo sprintf('<div id="notice_bar">%s</div>', $ost->getNotice());
    ?>
    <div id="header">
        <a href="index.php">
            <!--<img src="images/rac-logo.jpg"></img>-->
            <h1 onclick="ga('send', 'event', 'Navigation', 'Primary', 'Logo');">Research Requests</h1>
        </a>
        <p id="info">Welcome, <strong><?php echo $thisstaff->getFirstName(); ?></strong>
           <?php
            if($thisstaff->isAdmin() && !defined('ADMINPAGE')) { ?>
            | <a href="admin.php">Admin Panel</a>
            <?php }else{ ?>
            | <a href="index.php">Staff Panel</a>
            <?php } ?>
            | <a href="profile.php">My Preferences</a>
            | <a href="logout.php?auth=<?php echo $ost->getLinkToken(); ?>">Log Out</a>
        </p>
    </div>
    <ul class="nav nav-tabs nav-primary">
        <?php
        if(($tabs=$nav->getTabs()) && is_array($tabs)){
            foreach($tabs as $name =>$tab) {
                echo sprintf('<li class="%s"><a href="%s" onClick="ga(\'send\', \'event\', \'Navigation\', \'Primary\', \'%s\');">%s</a>',$tab['active']?'active':'inactive',$tab['href'],$tab['desc'],$tab['desc']);
                //if(!$tab['active'] && ($subnav=$nav->getSubMenu($name))){
                  //  echo '<ul class="dropdown-menu">';
                    //foreach($subnav as $k => $item) {
                      //  if (!($id=$item['id']))
                        //    $id="nav$k";

                   //     echo sprintf('<li><a href="%s" title="%s" id="%s">%s</a></li>',
                     //           /*$item['iconclass'], */$item['href'], $item['title'], $id, $item['desc']);
                  //  }
                 //   echo "\n</ul>\n";
               // }
                echo "\n</li>\n";
            }
        } ?>
    </ul>
    <ul class="nav nav-tabs nav-secondary">
        <?php
        if(($subnav=$nav->getSubMenu()) && is_array($subnav)){
            $activeMenu=$nav->getActiveMenu();
            if($activeMenu>0 && !isset($subnav[$activeMenu-1]))
                $activeMenu=0;
            foreach($subnav as $k=> $item) {
                if($item['droponly']) continue;
                //$class=$item['iconclass'];
                if ($activeMenu && $k+1==$activeMenu
                        or 
                        (!$activeMenu
                            && (strpos(strtoupper($item['href']),strtoupper(basename($_SERVER['SCRIPT_NAME']))) !== false
                                or ($item['urls']
                                    && in_array(basename($_SERVER['SCRIPT_NAME']),$item['urls'])
                                   )
                                )))
                    {$class="active";}
                    else {$class="inactive";}
                if (!($id=$item['id']))
                    $id="subnav$k";

                echo sprintf('<li class="%s"><a href="%s" title="%s" id="%s" onClick="ga(\'send\', \'event\', \'Navigation\', \'Secondary\', \'%s\');">%s</a></li>',
                        $class, $item['href'], $item['title'], $id, $item['title'], $item['desc']);
            }
        }
        ?>
    </ul>
    <div id="content">
        <?php if($errors['err']) { ?>
            <div class="alert alert-danger"><?php echo $errors['err']; ?></div>
        <?php }elseif($msg) { ?>
            <div class="alert alert-info"><?php echo $msg; ?></div>
        <?php }elseif($warn) { ?>
            <div class="alert alert-warning"><?php echo $warn; ?></div>
        <?php } ?>
