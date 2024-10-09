<?php

use wbraganca\fancytree\FancytreeWidget;
use yii\web\JsExpression;
use klisl\nestable\Nestable;

$this->title = 'NESTED SETS TREE';
$this->params['breadcrumbs'][] = $this->title;

function renderTree($nodes)
{
    $html = '<ul>';
    foreach ($nodes as $node) {
        $html .= '<li class="folder" data-id="' . $node['id'] . '">';
        $html .= '<div>';
        if ($node['children']) {
            $html .= '<span class="toggle">&#9660;</span>';
        }
        $html .= '<span class="folder-name">' . $node['name'] . '</span>';
        $html .= '</div>';
        if ($node['children']) {
            $html .= '<ul class="folder-contents" style="display: none;" data-id="' . $node['id'] . '">';
            $html .= renderTree($node['children']);
            $html .= '</ul>';
        }
        $html .= '</li>';
    }
    $html .= '</ul>';
    return $html;
}

?>
<script>
    var passedArray = <?php echo json_encode($data); ?>;
</script>

<style>
    .folder {
        display: flex;
        flex-direction: column;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 10px;
        cursor: pointer;
    }

    .folder-name {
        margin-left: 10px;
        font-weight: bold;
    }

    .file {
        display: flex;
        align-items: center;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .file-name {
        margin-left: 10px;
    }

    .toggle {
        cursor: pointer;
        margin-right: 10px;
    }

    .folder-contents {
        display: none;
        padding: 0;
    }
</style>

<div class="">
<!--    <pre>--><?php //print_r($data) ?><!--</pre>-->

    <div class="container">
        <div class="row">

            <div class="col-sm-3">
                <?= FancytreeWidget::widget([
                    'options' => [
                        'source' => $data,
                        'extensions' => ['dnd', 'edit'],
                        'dnd' => [
                            'preventVoidMoves' => true,
                            'preventRecursiveMoves' => true,
                            'autoExpandMS' => 400,
                            'dragStart' => new JsExpression('function(node, data) {
                console.log(node, data);
                return true;
            }'),
                            'dragEnter' => new JsExpression('function(node, data) {
                            console.log(node, data);
                return true;
            }'),
                            'dragDrop' => new JsExpression('function(node, data) {
                 $.get("/menu/move",{ item: data.otherNode.data.id, action: data.hitMode, second: node.data.id},
                     function(){
                         data.otherNode.moveTo(node, data.hitMode);
                      })
            }'),
                        ],
                        'edit' => [
                            'triggerStart' => ["dblclick"],
                            'close' => new JsExpression('function(event, data){
                        console.log(event, data);
                        // Editor was removed
                        $.post("/menu/update-ajax",{ id: data.node.data.id, name: data.node.title },
                         function(){
                             data.otherNode.moveTo(node, data.hitMode);
                          })
                      }')
                        ]
                    ]
                ]) ?>
            </div>

            <div id="window-view" class="col-sm-9 border-1">
                <?php
                echo renderTree($data);
                ?>
            </div>


        </div>
    </div>


    <p id="sampleButtons" class="mt-2">
        <span class="sampleButtonContainer">
            <button>
                <a href="/menu/create">Add child</a>
            </button>
        </span>
    </p>

    <p id="sampleButtons" class="mt-2">
        <span class="sampleButtonContainer">
            <button>
                <a href="/menu/">Delete child</a>
            </button>
        </span>
    </p>

</div>
