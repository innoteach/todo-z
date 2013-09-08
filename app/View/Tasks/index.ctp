<?php echo $this->Html->script('jquery-1.8.3.min'); ?>
<?php echo $this->Html->script('jqueryui/ui/jquery-ui'); ?>
<?php echo $this->Html->script('todo'); ?>

<div class="tasks index">
	<h2><?php echo __('Tasks'); ?></h2>
	<table cellpadding="0" cellspacing="0" id="sort">
        <?php echo $this->Form->create(); ?>    
	<thead>
        <tr>
                        <th> &nbsp; </th>
                        <th><?php echo $this->Paginator->sort('sort'); ?></th>                           
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('completed'); ?></th>                     
                        <th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
        </thead>
        <tbody>
	<?php foreach ($tasks as $task): ?>
	<tr id="<?php echo $task['Task']['id']; ?>">
                <td><span class="ui-icon ui-icon-arrowthick-2-n-s" style="display:inline-block"></span></td>
                <td class="index"><?php echo h($this->Number->precision($task['Task']['sort'],0)); ?>&nbsp;</td>
                <td <?php if($task['Task']['completed']) echo "class=\"completed\"" ?>>
                    <?php echo h($task['Task']['name']); ?>&nbsp;</td>
		<td><?php echo h($task['Task']['completed']); ?>&nbsp;</td>
                <td><?php echo h($task['Task']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $task['Task']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $task['Task']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $task['Task']['id']), null, __('Are you sure you want to delete \'%s?\' ', $task['Task']['name'])); ?>
		</td>
	</tr>
        <?php endforeach; ?>
        </tbody>
        <?php echo $this->Form->end(); ?>
        </table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Task'), array('action' => 'add')); ?></li>
	</ul>
</div>  
<script>
// @Todo Cake-ify this. In the interest of time I'm leaving it as is for refactoring.
// Return a helper with preserved width of cells
// call sort with the special width fix callback
$("#sort tbody").sortable({
    cursor: "move",
    helper: fixHelper,
    stop: updateSortIndex
    }
).disableSelection();
</script>
 <?php 
/*    Cakified it would look like this. But we'd need to overload the jquery JS helper to handle 
 *    disableSelection() or create an alernative JS route since disable selection is deprecated in Jquery 1.9
      $this->Js->get('#sort tbody')->sortable(array(
                'cursor' => "move",
                'helper'=> 'fixHelper',
                'stop' => 'updateSortIndex',
            )
        );
      $this->Js->get('#sort tbody')->disableSelection();
 */
?>