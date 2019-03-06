<?php

function convertDate($date)
{
    $date = explode(" ", $date)[0];

    $date = explode("-", $date);

    return $date[2] . '.' . $date[1] . '.' . $date[0];
}

function hiyerarsi($elemanlar, $eleman_id = 0)
{
    $kategori = array();

    foreach ($elemanlar as $eleman) {
        if ($eleman->ust_id == $eleman_id) {
            $altkategori = hiyerarsi($elemanlar, $eleman->kategori_id);

            if ($altkategori) {
                $eleman->children = $altkategori;
            } else {
                $eleman->children = array();
            }

            $kategori[] = $eleman;
        }
    }

    return $kategori;
}

function kategoriYazdirma($itemler)
{
    echo '<ol class="dd-list">';
    foreach ($itemler as $item) {
        echo '<li class="dd-item">'.
                                '<div class="dd-handle"><i class="mdi-navigation-arrow-forward left"></i>'.$item->kategori.'<i onclick="sil('.$item->kategori_id.')" class="mdi-action-delete right"></i><i onclick="duzenle('.$item->kategori_id.')" class="mdi-editor-mode-edit right" ></i></div>'.
                            '</li>';
        if (sizeof($item->children) > 0) {
            kategoriYazdirma($item->children);
        }
    }
    echo '</ol>';
}

?>