<?php
$this->breadcrumbs = array(
    'Countries',
);
?>
<div class="box">
    <div class="box-body">
        <h1>Manage Countries</h1>
        <hr>
        <?php
        $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']);
        $pageSizeDropDown = CHtml::dropDownList(
            'pageSize', $pageSize, array(10 => 10, 15 => 15, 30 => 30, -1 => 'All'), array(
             'id' => 'pageSize',
            )
        );
        ?>
        <div class="table-toolbar">
            <div class="page-size-wrap" style="width:100%">
                <div class="results-perpage">
                    <?= $pageSizeDropDown; ?><label>results per page</label>
                    <a href="<?php echo Yii::app()->request->baseUrl."/country/create/"?>" style="float:right;padding: 3px 8px;margin-left:10px;" class="btn btn-primary">Add New</a>
                </div>
            </div>
            <?php Yii::app()->clientScript->registerCss('initPageSizeCSS', '.page-size-wrap{width: 10%; float: left;}'); ?>            
        </div>
        <div class="custom_div_data">
            <div class="space_10px"></div>
            <div class="clear"></div>
            <?php
            if($model->search()){
                $this->widget('ext.yiisortablemodel.widgets.SortableCGridView', array(
                'id' => 'country',
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
                        'htmlOptions' => array('style' => 'width: 4%')
                    ),
                    array(
                        'name'=>'country_name',
                        'header'=> 'Country',
                        'type' => 'html',
                        'value'=> array($model,'CountryName'),
                        'htmlOptions' => array('style' => 'width: 10%'),
                    ),
                    array(
                        'name'=>'country_code',
                        'header'=> 'Country Code',
                        'type' => 'html',
                        'htmlOptions' => array('style' => 'width: 15%'),
                    ),
                    array(
                        'name'=>'country_phone_code',
                        'header'=> 'Telephone Code',
                        'type' => 'html',
                        'htmlOptions' => array('style' => 'width: 15%'),
                    ),
                    array(
                        'name' => 'created_at',
                        'value' => array($model,'CreatedDate'),
                        'htmlOptions' => array('style' => 'width: 10%')
                    ),
                    array(
                        'name'=>'status',
                        'header'=> 'Status',
                        'type' => 'html',
                        'value'=> array($model,'Status'),
                        'htmlOptions' => array('style' => 'width: 5%'),
                    ),
                    array(
                        'header' => 'Action',
                        'class' => 'ButtonColumn',
                        'template' => '{update}',
                        'htmlOptions' => array('style' => 'width: 10%','class' => "button-column"),
                        'buttons' => array(
                            'update' => array(
                                'label' => '<i class="icon-pencil icon-white"></i> Edit', // text label of the button
                                'options' => array('class' => "btn btn-primary btn-xxs", 'title' => 'Update','style'=>'margin-right:0px'),
                                'url' => function($data) {
                                    $url = Yii::app()->createUrl('country/update/' . $data->id);
                                    return $url;
                                    },
                                ),
                              )
                    ),
                ),
                'afterAjaxUpdate'=>"function(){<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/vendor/js/bootstrap-switch.js', CClientScript::POS_END);?>}", 
            ));
            }
            ?>
        </div> 
    </div>
</div>