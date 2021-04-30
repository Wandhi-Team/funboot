<?php
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Html;

$topicActive = true;


NavBar::begin([
//     'brandLabel' => Html::img('/images/logo.png'),
    'brandLabel' => $this->context->store->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-expand-lg navbar-light fixed-top',
    ],
]);

$rootMenu = [];
$nodes = Yii::$app->cacheSystemBbs->getStoreNode(Yii::$app->storeSystem->getId(), 0);
$items = [];
foreach ($nodes as $node) {
    $item = [];
    $item['label'] = $node->name;
    $item['url'] = ['/bbs/node/index', 'id' => $node->id];
    $item['active'] = (Yii::$app->request->get('id', 0) == $node->id);

    $items[] = $item;
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav'],
    'items' => \yii\helpers\ArrayHelper::merge($items, [
        ['label' => Yii::t('app', 'BBS'), 'url' => ['/'], 'active' => Yii::$app->request->get('id', 0) == 0],
        ['label' => Yii::t('app', 'Jobs'), 'url' => ['/bbs/default/index', 'id' => 2], 'active' => Yii::$app->request->get('id', 0) == 2],
        ['label' => Yii::t('app', 'Tags'), 'url' => ['/bbs/default/tag'], 'active' => false],
        ['label' => Yii::t('app', 'Yellow Pages'), 'url' => ['/bbs/default/index', 'id' => 9], 'active' => false],

    ]),
    'encodeLabels' => false
]);

    echo '<ul class="navbar-nav mr-auto ml-3"><li class="nav-item"><form class="navbar-form navbar-left" role="search" action="/bbs/default/index" method="get">
                <div class="form-group mb-0">
                    <input type="text" value="' . $keyword . '" name="ModelSearch[name]" class="form-control search_input" id="navbar-search" placeholder="搜索..." data-placement="bottom" data-content="请输入要搜索的关键词！">
                </div>
            </form></li></ul>';

if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => Yii::t('app', 'Sign up'), 'url' => ['/bbs/site/signup']];
    $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/bbs/site/login']];
} else {
    // 撰写
    $menuItems[] = [
        'label' => Html::tag('i', '', ['class' => 'bi-bell-fill']) . (1 > 0 ?Html::tag('span', 1, ['class' => 'badge badge-danger']) : ''),
        'url' => ['/notice/index'],
        'options' => ['class' => 'notice-count'],
    ];

    // 个人中心
    $menuItems[] = [
        'label' => Yii::$app->user->identity->username,
        'items' => [
            ['label' => Yii::t('app', 'Profile'), 'url' => ['/bbs/user/profile']],
            ['label' => Yii::t('app', 'Avatar'), 'url' => ['/bbs/user/avatar']],
            ['label' => Yii::t('app', 'Change Password'), 'url' => ['/bbs/user/change-password']],
            ['label' => Yii::t('app', 'Logout'), 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']]
        ]
    ];
}

// 语言
$menuItems[] = [
    'label' => Html::tag('i', '', ['class' => 'bi-globe']),
    'items' => [
        ['label' => '<i class="flag-icon flag-icon-cn mr-2"></i>' . Yii::t('app', 'Chinese'), 'url' => 'javascript:;', 'linkOptions' => ['class' => 'funboot-lang', 'data-lang' => 'cn']],
        ['label' => '<i class="flag-icon flag-icon-gb mr-2"></i>' . Yii::t('app', 'English'), 'url' => 'javascript:;', 'linkOptions' => ['class' => 'funboot-lang', 'data-lang' => 'en']],
    ]
];

echo Nav::widget([
    'encodeLabels' => false,
    'options' => ['class' => 'nav navbar-nav navbar-right'],
    'items' => $menuItems,
    'activateParents' => true,
]);
NavBar::end();


