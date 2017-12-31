<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Application Template With Redis, Oauth, RoleBasedAccountFilter, Rbac based Dynamic Menu</h1>
    <br>
</p>

It's a Yii2 Application Template Build on Yii2Basic Template. OAuth2 Library, RbacFilter, RedisSetting has included in <b>componentes</b> directory.

It has 3 base controllers as BaseController, BaseDeleteController and BaseViewController. Look at these classes and extend one of these in your controllers.

LDAP Setting parameters (If you want to use), OAuth2 Setting parameters, Redis Parameters are in params.php file.

You should have another OAuth Server for work with this template. If you don't have, you should delete all of RBAC and OAuth usages (<b>If you dont have, dont prefer this template</b>).

<b>There are a few example controller and models. You can delete after review.</b>

Install with Composer


    php /bin/composer install
OR

  
    php composer.phar install
  

Files are added to yii2basic template
    
    /components/RbacFilter.php
    /components/RedisSetting.php
    /components/OAuth2.php
    /controllers/base/*
    /controllers/*
    /models/*
    /views/*
    /widgets/DynamicMenu.php
    /web/css/* and /web/js/* (Included AdminLTE)
    
Files are changed

    /config/db.php
    /config/params.php (It is so important)
    /config/web.php