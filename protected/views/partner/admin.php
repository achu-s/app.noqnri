<?php
$this->breadcrumbs = array(
    'Partner List',
);
?>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content" id="modal-content">
    </div>
  </div>
</div>
<div class="box">
    <div class="box-body">
<h1>Manage Partner list</h1>
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
        <?php if(Yii::app()->user->id==1){?>
        	<a href="<?php echo Yii::app()->request->baseUrl."/partner/create/"?>" style="float:right;padding: 3px 8px;margin-left:10px;" class="btn btn-primary">Add New</a>
        <?php }?>
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
    'id' => 'feedback-grid',
    'dataProvider' => $model->search(),
    'summaryText' => "{start} - {end} of {count}",
    'ajaxUpdate' => true,
    'enableDragDropSorting'=>false,
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
            'name'=>'name',
            'header'=> 'Name',
            'type' => 'html',
            'value'=> array($model,'PartnerName'),
            'htmlOptions' => array('style' => 'width: 10%'),
        ),
        array(
            'name'=>'category_id',
            'header'=> 'Category',
            'type' => 'html',
            'value'=> array($model,'CategoryName'),
            'htmlOptions' => array('style' => 'width: 10%'),
        ),
        array(
            'name'=>'email_id',
            'header'=> 'Email',
            'type' => 'html',
            'value'=> array($model,'Email_address'),
            'htmlOptions' => array('style' => 'width: 5%'),
        ),
        array(
            'name'=>'contact_person',
            'header'=> 'Contact Person',
            'type' => 'html',
            'htmlOptions' => array('style' => 'width: 5%'),
        ),
        array(
            'name'=>'mode_of_business',
            'header'=> 'Mode',
            'type' => 'html',
            'htmlOptions' => array('style' => 'width: 5%'),
        ),
        array(
            'name' => 'created_at',
            'value' => array($model,'CreatedDate'),
            // 'value'=>'Yii::app()->dateFormatter->format("m/d/y",$data->created)',
            'htmlOptions' => array('style' => 'width: 8%')
        ),
        array(
            'name'=>'status',
            'header'=> 'Status',
            'type' => 'html',
            'value'=> array($model,'Status'),
            'htmlOptions' => array('style' => 'width: 5%'),
        ),
        array(
            'header' => '',
            'class' => 'ButtonColumn',
            'template' => '{update}{view}',
            'htmlOptions' => array('style' => 'width: 10%','class' => "button-column"),
            'buttons' => array(
                    'update' => array(
                        'label' => '<i class="icon-pencil icon-white"></i> Edit', // text label of the button
                        'options' => array('class' => "btn btn-primary btn-xxs", 'title' => 'Update','style'=>'margin-right:0px'),
                        'url' => function($data) {
                            $url = Yii::app()->createUrl('partner/update/' . $data->id);
                            return $url;
                        },
                    ),
                    'view' => array( //the name {reply} must be same
                        'label' => '<i class="icon-remove icon-white"></i> View', // text label of the button
                        'options' => array('class'=>"btn btn-info btn-xxs ",'title'=>'View'),
                        'url' => function($data) {
                            $url = Yii::app()->createUrl('partner/partnerView?id=' . $data->id);
                            return $url;
                         },
                     ),
                  )
            ),
    ),
));
}
?>
</div>
</div>
</div>