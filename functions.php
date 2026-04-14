<?php
function formatPrice($price){
    if($price >= 10000000){
        return round($price / 10000000, 2) . " Cr";
    } elseif($price >= 100000){
        return round($price / 100000, 2) . " Lakh";
    } else {
        return $price;
    }
}
?>