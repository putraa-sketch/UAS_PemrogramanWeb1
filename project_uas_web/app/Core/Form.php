<?php
namespace Core;
use Config\Config;

class Form {
    private $action;
    private $fields = [];
    private $enctype = "";

    public function __construct($action) { 
        $this->action = $action; 
    }

    public function setEnctype($enctype) { 
        $this->enctype = $enctype; 
    }

    public function addTextField($name, $label, $val='', $req=false) {
        $this->fields[] = ['type'=>'text', 'name'=>$name, 'label'=>$label, 'val'=>$val, 'req'=>$req];
    }
    public function addNumberField($name, $label, $val='', $req=false) {
        $this->fields[] = ['type'=>'number', 'name'=>$name, 'label'=>$label, 'val'=>$val, 'req'=>$req];
    }
    public function addSelectField($name, $label, $opt=[], $sel='', $req=false) {
        $this->fields[] = ['type'=>'select', 'name'=>$name, 'label'=>$label, 'opt'=>$opt, 'sel'=>$sel, 'req'=>$req];
    }
    public function addFileField($name, $label) {
        $this->fields[] = ['type'=>'file', 'name'=>$name, 'label'=>$label];
    }

    public function display() {
        echo "<form action='$this->action' method='POST'";
        if($this->enctype) echo " enctype='$this->enctype'"; 
        echo " class='card p-4 shadow-sm'>";
        
        foreach($this->fields as $f) {
            echo "<div class='mb-3'><label class='fw-bold'>".$f['label']."</label>";
            $req = isset($f['req']) && $f['req'] ? 'required' : '';
            
            if($f['type']=='select') {
                echo "<select name='".$f['name']."' class='form-control'>";
                foreach($f['opt'] as $k=>$v) {
                    $sel = ($k==$f['sel']) ? 'selected' : '';
                    echo "<option value='$k' $sel>$v</option>";
                }
                echo "</select>";
            } elseif($f['type']=='file') {
                echo "<input type='file' name='".$f['name']."' class='form-control'>";
            } else {
                echo "<input type='".$f['type']."' name='".$f['name']."' value='".$f['val']."' class='form-control' $req>";
            }
            echo "</div>";
        }
        echo "<button type='submit' name='submit' class='btn btn-primary w-100'>Simpan</button>";
        echo "<a href='".Config::BASE_URL."/barang' class='btn btn-link w-100 mt-2'>Kembali</a>";
        echo "</form>";
    }
}