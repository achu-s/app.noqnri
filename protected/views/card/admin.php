<?php
$this->breadcrumbs = array(
    'Card List',
);
$this->menu = array(
    array('label' => 'List Requestors', 'url' => array('index')),
    array('label' => 'Create Requestors', 'url' => array('create')),
);
?>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog card-modal">
    <div class="modal-content">
    </div>
  </div>
</div>
<div class="box">
    <div class="box-body">
        <h1>Manage card list</h1>
        <hr>
        <?php
        $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']);
        $pageSizeDropDown = CHtml::dropDownList(
            'pageSize', $pageSize, array(10 => 10, 15 => 15, 30 => 30, -1 => 'All'), array(
             'id' => 'pageSize',
             'onChange'=>'ChangePagecount(this,"Feedback","index","")',
            )
        );
        ?>
        <div class="table-toolbar">
        <div class="page-size-wrap" style="width:100%">
            <div class="results-perpage">
                <?= $pageSizeDropDown; ?><label>results per page</label>
                <a href="javascript:void(0);" style="float:right;" class="btn btn-primary btn-xxs"  data-toggle='modal' data-target='#myModal' id="add_new_form">Generate Card</a>
            </div>
        </div>
        <?php Yii::app()->clientScript->registerCss('initPageSizeCSS', '.page-size-wrap{width: 10%; float: left;}'); ?>            
        </div>
        <div class="custom_div_data">
        <div class="clear"></div>
        <div class="space_10px"></div>
        <div class="clear"></div>
        <?php
        if($model->search()){
            $this->widget('ext.yiisortablemodel.widgets.SortableCGridView', array(
            'id' => 'card-grid',
            'dataProvider' => $model->search(),
            'summaryText' => "{start} - {end} of {count}",
            'ajaxUpdate' => true,
            'enableDragDropSorting'=>false,
            //'orderField' => 'id',
            'idField' => 'id',
            'filter' => $model,
            'htmlOptions' => array('class' => 'span12 table-responsive'),
            'itemsCssClass' => 'table',
            'columns' => array(
                array(
                    'name'=>'id',
                    'header' => 'Id',
                    'htmlOptions' => array('style' => 'width: 10%')
                ),
                array(
                    'name'=>'card_number',
                    'type' => 'html',
                    'value'=>array($model,'CardNumber'),
                    'htmlOptions' => array('style' => 'width: 20%'),
                ),
                array(
                    'name'=>'phone_number',
                    'header' => 'Phone Number',
                    'type' => 'html',
                    'htmlOptions' => array('style' => 'width: 20%'),
                ),
                array(
                    'name'=>'card_issue_status',
                    'header' => 'Card Availablity',
                    'type' => 'html',
                    'value'=> array($model,'Card_availability'),
                    'htmlOptions' => array('style' => 'width: 20%'),
                ),
                array(
                    'name' => 'created_at',
                    'value' => array($model,'CreatedDate'),
                    // 'value'=>'Yii::app()->dateFormatter->format("m/d/y",$data->created)',
                    'htmlOptions' => array('style' => 'width: 20%')
                ),
                array(
                    'name' => 'created_at',
                    'header'=> 'Action',
                    'filter'=>'',
                    'value' => array($model,'ActionButton'),
                    'htmlOptions' => array('style' => 'width: 15%')
                ),
            ),
        ));
        }
        ?>
        </div>
	</div>
</div>