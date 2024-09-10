<?php 
function generateRandomString($length) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    
    for ($i = 0; $i < $length; $i++) {
        $randomIndex = random_int(0, $charactersLength - 1);
        $randomString .= $characters[$randomIndex];
    }
    
    return $randomString;
}
?>