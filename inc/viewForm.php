<?php

const BTN_CANCEL = '<span class="cancel"><a href="index.php#formarea">Cancel</a></span>';

function viewAddGroup()
{
    $btn_cancel = BTN_CANCEL;
    echo <<<EOT
    <h3>New group</h3>
    <form action="index.php#formarea" method="POST">
        <input type="text" name="newgroup" value=""/>
        <input type="hidden" name="action" value="addgroup"/>
        <div class="row btn-form">
            <input type="submit" value="Add"/>
            $btn_cancel
        </div>
    </form>
EOT;
}
