<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
?>
<!-- 
The container div below:
"<div style="display: flex;flex-direction: column-reverse;">"
makes the first children divs following it, display in the reverse direction.
So here we are showing the bottom div at the top.
Why? because Yii has a bug where if we have 2 CListView widgets, one of them will sometimes show the incorrect info.
I swapped the widgets around (reversed their position) on the page, and they worked.
But the layout needs to be a certain way, so in code I have them in the wrong order, but the css will reverse it back for correct viewing. Bad Yii!
-->
<div style="display: flex;flex-direction: column-reverse;">
    <div>
        <div>
            <h3 class="pull-left">All Events</h3>
            <!-- <h3 class="pull-right">Sort by Name / Date</h3>
            <hr/> -->
        </div>

        <?php $config = array(); $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$eventDataProvider,
            'itemView'=>'_index_event_view',
                'sortableAttributes'=>array(
                'name',
                'date',
            ),
        )); ?>
    </div>

    <div style="height: 50px;clear: both;"></div>
    <div>
        <div>
            <h3 class="pull-left">All Organizations</h3>
            <!-- <h3 class="pull-right">Sort by Name / Type</h3>
            <hr/> -->
        </div>
            <?php $this->widget('zii.widgets.CListView', array(
                'dataProvider'=>$orgDataProvider,
                'itemView'=>'_index_org_view',
                    'sortableAttributes'=>array(
                    'name',
                ),
            )); ?>
        </div>
    </div>
</div>