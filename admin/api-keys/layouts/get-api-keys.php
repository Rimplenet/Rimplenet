<?php

require plugin_dir_path(dirname(__FILE__)) . '/assets/php/get.php';
?>
<!-- <h2> Active Users</h2> -->
<div class="table-responsive bg-white p-5 mr-3 ml-3 rimplenet-bs5">
    <table class="table table-sm table-borderless table-striped rimplenet-bs5" style="width:100%" id="rimplenetmyTable">

        <thead>
            <tr>
                <th> Name </th>
                <th> API Key </th>
                <th> Type </th>
                <th> Permission </th>
                <th> Date </th>
                <th> Actions </th>
            </tr>
        </thead>

        <tbody>


            <?php
            if (isset($keys['data']) && !empty($keys['data']) && is_iterable($keys['data'])) :
                foreach ($keys['data'] as $key) :
                    $type = $transferType ?? '';

                    extract((array) $key);
                    $id = $keyId ?? 3; ?>
                    <tr>
                        <td> <?= $name ?: '__' ?> </td>
                        <td> <?= $key ?: '__' ?> </td>
                        <td> 
                        <?php 
                            $sel = "<select class='form-control' style='background:transparent'>";
                            $types = explode(',', $allowedAction);
                            foreach($types as $type){
                                $sel .= "<option>". ucwords(str_replace('_', ' ', $type)) ."</option>";
                            }
                            $sel .= "</select>";
                            echo $sel;
                        ?>        
                    </td>
                        <td> <?= ucwords(str_replace('-', ' ', $keyType)) ?: '__' ?> </td>
                        <td> <?= date('M d y H:ia', $created) ?> </td>
                        <td>
                            <?php

                            $viewUrl = ''; # add_query_arg(array('post_type' => $_GET["post_type"], 'page' => 'transfers', 'tab' => 'view_transfer', 'viewing_user' => get_current_user_id(), 'transfer' => $id), admin_url("edit.php"));
                            $editUrl =  ''; #add_query_arg(array('post' => $transferId, 'action' => 'edit'), admin_url("post.php"));
                            ?>
                            <a href="<?= $viewUrl ?: '__' ?>" target="_blank" class="btn-outline-warning btn-sm btn">View</a>
                            <a href="#" target="_blank" class="btn-outline-danger btn-sm btn">Delete</a>
                        </td>
                    </tr>
            <?php endforeach;
            endif; ?>

        </tbody>

        <tfoot>
            <tr>
                <th> Name </th>
                <th> API Key </th>
                <th> Type </th>
                <th> Permission </th>
                <th> Date </th>
                <th> Actions </th>
            </tr>
        </tfoot>

    </table>
</div>