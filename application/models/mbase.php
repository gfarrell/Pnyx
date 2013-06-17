<?php
class mBase extends Eloquent {
    protected function beforeSave() { return true; }
    protected function afterSave()  { return true;}

    public function save() {
        if($this->beforeSave(true)) {
            $res = parent::save();
            $this->afterSave(true);

            return $res;
        } else {
            throw new Exception('Unable to save data, beforeSave returned false.');
        }
    }
}
?>