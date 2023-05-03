<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Note> $notes
 */
?>
<div class="notes index content">
    <?= $this->Html->link(__('New Note'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Notes') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('address') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $counter = 0;
                foreach ($notes as $note):
                $counter++;
                ?>
                <tr>
                    <td><?= $this->Number->format($counter) ?></td>
                    <td><?= h($note->name) ?></td>
                    <td><?= h($note->address) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $note->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $note->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $note->id], ['confirm' => __('Are you sure you want to delete # {0}?', $note->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p><br>
    </div>

    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3neA22vhHB3NjyQGBtmz35R5N3JWUEHA&callback=initMap"></script>
    <script>
        function initMap() {
            var mapPosition = new google.maps.LatLng( 35.6896,139.701 );
            var map = new google.maps.Map(document.getElementById('gmap'), {
            zoom: 4,
            center: mapPosition
            });
            <?php foreach ($notes as $note): ?>
                var markerPosition = new google.maps.LatLng( <?= $note->latitude ?>,<?= $note->longitude ?> );
                var marker = new google.maps.Marker({
                    position: markerPosition,
                    map: map
                });
            <?php endforeach; ?>
        }
    </script>
    <div id="gmap"></div>
    <style>
        #gmap {
            width:100%;
            height:500px;
        }
    </style>
</div>
