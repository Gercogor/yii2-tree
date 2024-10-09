<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'TREE';
$url = '';
if (!$dynoRoute) {
    $this->params['breadcrumbs'][] = $this->title;
} else {
    foreach ($dynoRoute as $route) {
        $url .= $route . '/';
        $this->params['breadcrumbs'][] = [
            'label' => $route, // название ссылки
            'url' => [$url] // сама ссылка
        ];
    }
}
?>
<div class="site-tree">
    <h1><?= Html::encode($this->title) ?></h1>

    To create tree run
    <pre>
        php yii seed;
    </pre>

    <?php
        function print_list($array, $parent = 0, $url='')
        {
            print "<ul>";
            foreach ($array as $row) {
                $currUrl = $url . '/' . $row['name'];
                if ($row['parent_id'] == $parent) {
                    $href = Url::toRoute([$currUrl]);
                    print "<li> <a href='{$href}'>{$row['name']}</a>";
                    if(array_key_exists('children',$row)) print_list( $row['children'], $row['id'], $currUrl);  # recurse
                    print "</li>";
                }
                $currUrl = $url;
            }
            print "</ul>";
        }
    print_list($tree)
    ?>

    <code><?= __FILE__ ?></code>
</div>

