<?php
class mBase extends Eloquent {
    public static $timestamps = false;

    protected function beforeSave() { return true; }
    protected function afterSave()  { return true;}

    public function save() {
        if($this->beforeSave(true)) {
            parent::save();
            $this->afterSave(true);
        } else {
            throw new Exception('Unable to save data, beforeSave returned false.');
        }
    }
}
?>