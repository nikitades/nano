<div class="container buffer-sm">
    <div class="row">
        <nav class="navbar navbar-default navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand"><?= ucfirst(dpl('TITLE')) ?></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li <?= curir('/', 'class="active"') ?>>
                            <a href="/">Список постов <?= curir('/', '<span class="sr-only">(current)</span>') ?></a>
                        </li>
                        <li <?= curir('/post', 'class="active"') ?>><a href="/post">Добавить пост</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <? if (User::checkAuth()) { ?>
                            <li>
                                <a><?= User::current()->name ?></a>
                            </li>
                            <li class="dropdown">
                                <a href="/logout">Выйти</a>
                            </li>
                        <? } else { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true"
                               aria-expanded="false">Авторизация <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="/login">Войти</a></li>
                                <li><a href="/register">Регистрация</a></li>
                                <li><a href="/logout">Выйти</a></li>
                            </ul>
                            <? } ?>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </div>
</div>