<?php

const BTN_CANCEL = '<span class="cancel"><a href="index.php#formarea">Cancel</a></span>';

function viewAddGroup()
{
    $btn_cancel = BTN_CANCEL;
    echo <<<EOT
    <h3>New group</h3>
    <form action="index.php#formarea" method="POST">
        <input type="text" name="group" value=""/>
        <input type="hidden" name="action" value="addgroup"/>
        <div class="row btn-form">
            <input type="submit" value="Add"/>
            $btn_cancel
        </div>
    </form>
EOT;
}

function viewDeleteGroup()
{
    $grouptodelete = isset($_SESSION['group']) ? $_SESSION['group'] : '';
    $btn_cancel = BTN_CANCEL;
    echo <<<EOT
    <h3>Delete a group</h3>
    <form action="index.php#formarea" method="POST">
        <input type="hidden" name="group" value="$grouptodelete" />
        Are you sure you want to delete '$grouptodelete' group and all its tasks ?
        <div class="row btn-form">
            <input type="hidden" name="action" value="deletegroup"/>
            <input type="submit" value="Delete"/>
            $btn_cancel
        </div>
    </form>
EOT;
}

function viewEditGroup()
{
    $group = $_SESSION['group'];
    $btn_cancel = BTN_CANCEL;
    echo <<<EOT
    <h3>Rename a group</h3>
    <form action="index.php#formarea" method="POST">
        <input type="text" name="group" value="$group"/>
        <input type="hidden" name="oldgroup" value="$group"/>
        <input type="hidden" name="action" value="editgroup"/>
        <div class="row btn-form">
            <input type="submit" value="Rename"/>
            $btn_cancel
        </div>
    </form>
EOT;
}
