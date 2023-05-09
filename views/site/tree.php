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

    <div style="margin: 10px 0">
        <label for="settings">
            Settings
            <input id="settings" type="checkbox">
        </label>
    </div>

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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log('loaded');

        const checkbox = document.querySelector('#settings')
        let liArray = document.querySelectorAll('li');

        checkbox.addEventListener('change', (event) => {
            if (event.currentTarget.checked) {
                console.log('checked');
                liArray.forEach(el=>{
                    el.addEventListener('click', click)
                })
                liArray.forEach(el=>{
                    el.addEventListener('contextmenu', rightClick)
                })
            } else {
                liArray.forEach(el=>{
                    el.removeEventListener("click",click);
                    el.removeEventListener("contextmenu",rightClick);
                })
                console.log('not checked');
            }
        })

    })
    function click (e){
        e.preventDefault();
        e.stopPropagation();
        let  oldDiv = document.querySelector('#tree-setting');
        if (oldDiv) oldDiv.remove();
        let div = document.createElement('div');
        div.setAttribute("id", "tree-setting");
        div.innerHTML('123')
        e.target.after(div)
        console.log(e.target.parentElement);
    }
    function rightClick (e){
        e.preventDefault();
        e.stopPropagation();
        console.log(e.target);
    }
</script>

