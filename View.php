<?php

class View
{    
    public function SelectList($list, $selected = 'todo', $attribute = 'status')
    {
        $select = "";
        foreach ($list as $state) {
            $select .= '<option value="'.$state.'"';
            if ($state == $selected) {
                $select .= 'selected = "selected"';
            }
            $select .= '>'.$state.'</option>';
        }
        return <<<EOT
            <label for="$attribute">$attribute</label>
            <select name="$attribute">
                $select
            </select>
EOT;
    }
}