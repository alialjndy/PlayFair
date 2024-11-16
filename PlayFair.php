<?php 
class PlayFair {
    public $key; 
    public $plainText;
    public $arr = array([],[],[],[],[]);
    public $alphabet = "abcdefghiklmnopqrstuvwxyz";
    public $usedAlphabet; 
    public $cipherText = "";

    public function __construct($key , $plainText) {
        $this->key = $key; 
        $this->plainText = $plainText;
    }
    public function checkDoubleCharacter($key) { 
        $result = "";
        for ($i = 0; $i < strlen($key) - 1; $i++) {
            if ($key[$i] != $key[$i + 1]) {
                $result .= $key[$i];
            }
        }
        $result .= $key[strlen($key) - 1];
        return $result;
    }
    public function createAlphabet($newKey){
        $defferince = implode("",array_diff(str_split($this->alphabet) , str_split($newKey)));
        return $defferince ; 
    }
    public function separeteCharacterInPlainText($plainText){
        for($i = 0 ; $i < strlen($plainText)-1 ; $i++){
            if($plainText[$i] == $plainText[$i+1]){
                $part1 = substr($plainText , 0 , $i+1);
                $part2 = substr($plainText ,  $i+1);
                $plainText = $part1 . "x" .$part2;
                print("$plainText \n");
            }
        }
        if(strlen($plainText) % 2 != 0){
            $plainText .= "z";
            print("$plainText \n");
        }
        print("Final PlainText is : $plainText \n");
        return $plainText ; 
    }
    public function printPlainTextAfterSeparete($word){
        for($i = 0 ; $i < strlen($word) ; $i += 2){
            print($word[$i].$word[$i+1]." ");
        }
        print("\n");
    }
    public function createArray($word){
        $word_arr = str_split($word);
        $index = 0 ; 
        $res = 0 ;
        for($i = 0 ; $i < 5 ; $i++){
            for($j = 0 ; $j < 5 ; $j++){
                if($index < count($word_arr)){
                    $this->arr[$i][$j] = $word_arr[$index];
                    $index++ ;
                }else{
                    $SpecificAlphabet = $this->createAlphabet($this->checkDoubleCharacter($this->key));
                    $this->arr[$i][$j] = $SpecificAlphabet[$res];
                    $res++;
                }
            }
        }
    }
    public static function findIndexOfElement($character,$array){
        for($i = 0 ; $i < 5 ;$i++){
            for($j = 0 ; $j < 5 ; $j++){
                if($array[$i][$j] == $character){
                    return ([$i ,$j]);
                }
            }
        }
        print("vlaue not found \n");
        return ;
    }
    public function EncryptPlainText($FinalPlainText){
        $finalText = "";
        for($i = 0 ; $i < strlen($FinalPlainText) - 1 ; $i+= 2){
            $index1 = $this->findIndexOfElement($FinalPlainText[$i],$this->arr);
            $rowForOneValue = $index1[0];
            $ColumnForOneValue = $index1[1];

            //

            $index2 = $this->findIndexOfElement($FinalPlainText[$i+1],$this->arr);
            $rowForTowValue = $index2[0];
            $ColumnForTowValue = $index2[1];

            if($rowForOneValue == $rowForTowValue){
                if($ColumnForOneValue == 4){
                    $this->cipherText[$i] = $this->arr[$rowForOneValue][0];
                    $this->cipherText[$i+1] = $this->arr[$rowForTowValue][$ColumnForTowValue+1];
                }else 
                if($ColumnForTowValue == 4){
                    $this->cipherText[$i+1] = $this->arr[$rowForTowValue][0];
                    $this->cipherText[$i] = $this->arr[$rowForOneValue][$ColumnForOneValue+1];
                }else{
                    $this->cipherText[$i] = $this->arr[$rowForOneValue][$ColumnForOneValue + 1];
                    $this->cipherText[$i + 1] = $this->arr[$rowForTowValue][$ColumnForTowValue + 1];
                }


            }else if($ColumnForOneValue == $ColumnForTowValue){
                if($rowForOneValue == 4){
                    $this->cipherText[$i] == $this->arr[0][$ColumnForOneValue];
                    $this->cipherText[$i+1] == $this->arr[$rowForTowValue + 1][$ColumnForTowValue] ;
                }else
                if($rowForTowValue == 4){
                    $this->cipherText[$i+1] == $this->arr[0][$ColumnForTowValue];
                    $this->cipherText[$i] == $this->arr[$rowForOneValue + 1][$ColumnForOneValue] ;
                }else{
                    $this->cipherText[$i] = $this->arr[$rowForOneValue + 1][$ColumnForOneValue];
                    $this->cipherText[$i + 1] = $this->arr[$rowForTowValue + 1][$ColumnForTowValue];
                }
            }else{
                $this->cipherText[$i] = $this->arr[$rowForTowValue][$ColumnForOneValue];
                $this->cipherText[$i + 1] = $this->arr[$rowForOneValue][$ColumnForTowValue];
            }
        }
        return $finalText; 
    }
    public function printArray() {
        print("This Array Will Be Used is : \n");
        for($i = 0; $i < 5; $i++) {
            for($j = 0; $j < 5; $j++) {
                echo $this->arr[$i][$j] . " ";
            }
            echo "\n";
        }
    }
}

$p = new PlayFair("hello", "tomorrow");
$usedKey = $p->checkDoubleCharacter($p->key);
print("Used Key is : $usedKey \n");

$separetePlainText = $p->separeteCharacterInPlainText($p->plainText);
$p->printPlainTextAfterSeparete($separetePlainText);

$p->createArray("helo");
$p->printArray();

print("_____________________________________\n");
$p->EncryptPlainText($separetePlainText);
print("\n");
print($p->cipherText);
