<?php

class View
{
    public function manageAttributesDisplay($crud, $id = null, $attributeSelect = 'status')
    {
            $attributesList = $crud->attributesList;
            $select = "";
            if (in_array($attributeSelect, $attributesList)) {

                if (!empty($id)) {
                    $select .= $this->selectList($crud->statusList, $crud->data[$id][$attributeSelect]);
                } else {
                    $select .= $this->selectList($crud->statusList);
                }

                $rmkey = array_search($attributeSelect, $attributesList);
                unset($attributesList[$rmkey]);
            }
            return [
                'stdAttributes' => $attributesList,
                'select' => $select
            ];
    }

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
